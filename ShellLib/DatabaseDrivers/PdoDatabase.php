<?php
class PdoDatabase implements IDatabaseDriver
{
    public $Database;
    public $Config;

    function __construct($core, $config)
    {
        if(!$config['Database']['UseDatabase']){
            return;
        }

        $provider = $config['Database']['Provider'];
        $server = $config['Database']['Server'];
        $database = $config['Database']['Database'];
        $port = 3306;

        $dataSource = "$provider:dbname=$database;host=$server;port=$port";

        $db = new PDO(
            $dataSource,
            $config['Database']['Username'],
            $config['Database']['Password']
        );

        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $this->Database = $db;
        $this->Config = $config;
    }

    public function DescribeTable($tableName){
        $sql = 'describe ' . $tableName;
        $resultSet = $this->Database->query($sql);

        if(!$resultSet){
            return false;
        }

        $columns = array();
        $referenceRows = array();
        foreach($resultSet as $row){
            $row['PreparedStatementType'] = $this->GetPreparedStatementType($row['Type']);
            $columns[$row['Field']] = $row;

            if($row['Key'] == 'PRI'){
                $primaryKey = $row['Field'];
            }else if($row['Key'] == 'MUL'){
                $referenceRows[] = $row;
            }
        }

        // Handle the references
        $references = array();
        foreach($referenceRows as $referenceRow){
            $fieldName = $referenceRow['Field'];
            $references[$fieldName] = $this->DescribeRelation($tableName, $fieldName);
        }

        // Find and set some metadata
        $metaData = array(
            'TableName' => $tableName,
            'PrimaryKey' => $primaryKey,
            'ColumnNames' => $this->GetColumnNames($columns, $primaryKey)
        );

        $result = array(
            'MetaData' => $metaData,
            'Columns' => $columns,
            'References' => $references,    // These will turn into ModelCollections.
            'ReversedReferences' => array()  // These will turn into ModelCollectionProxies. Impossible to know at this stage, but create the element so it's there later.
        );

        return $result;
    }

    function GetColumnNames($columns, $primaryKey)
    {
        $result = array();

        foreach(array_keys($columns) as $key){
            if($key != $primaryKey ){
                $result[] = $key;
            }
        }

        return $result;
    }

    function GetPreparedStatementType($type){
        if(strpos($type, 'int') !== false){
            return "i";
        }elseif(strpos($type,'char') !== false){
            return "s";
        }elseif(strpos($type, 'datetime') !== false){
            return "s";
        }

        return "";
    }

    public function DescribeRelation($class, $column)
    {
        $sqlStatement = "select
        TABLE_NAME,COLUMN_NAME,REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
        from INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        where
        TABLE_NAME=? and COLUMN_NAME=?";

        if(!$preparedStatement = $this->Database->prepare($sqlStatement)) {
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $params = array($class, $column);
        $preparedStatement->execute($params);
        $row = $preparedStatement->fetch();

        $result = array(
            'Field' => ucfirst($row['COLUMN_NAME']),
            'TableName' => $row['REFERENCED_TABLE_NAME'],
            'TableColumn' => $row['REFERENCED_COLUMN_NAME']
        );

        return $result;
    }

    public function Close()
    {
        // Not required for a PDO database object
    }

    public function Find($modelCollection, $id)
    {
        $tableName = $modelCollection->ModelCache['MetaData']['TableName'];
        $primaryKey = $modelCollection->ModelCache['MetaData']['PrimaryKey'];
        $columns = array_keys($modelCollection->ModelCache['Columns']);

        $sqlStatement = "SELECT * FROM $tableName WHERE $primaryKey=?";
        if(!$preparedStatement = $this->Database->prepare($sqlStatement)){
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $params = array($id);

        $preparedStatement->execute($params);
        if($preparedStatement->rowCount() == 0){
            return null;
        }

        $row = $preparedStatement->fetch();
        $result = new $modelCollection->ModelName($modelCollection);
        $result->FlagAsSaved();
        foreach($columns as $key){
            $result->$key = $row[$key];
        }

        return $result;
    }

    public function Exists($modelCollection, $id)
    {
        $tableName = $modelCollection->ModelCache['MetaData']['TableName'];
        $primaryKey = $modelCollection->ModelCache['MetaData']['PrimaryKey'];

        $sqlStatement = "SELECT $primaryKey FROM $tableName WHERE $primaryKey=?";
        if(!$preparedStatement = $this->Database->prepare($sqlStatement)){
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $params = array(0 => $id);

        $preparedStatement->execute($params);
        if($preparedStatement->rowCount() == 0){
            return false;
        }else{
            return true;
        }
    }

    public function Where($modelCollection, $conditions, $parameters)
    {
        $result = new Collection();

        $tableName = $modelCollection->ModelCache['MetaData']['TableName'];
        $columns = array_keys($modelCollection->ModelCache['Columns']);

        $sqlStatement = "SELECT * FROM $tableName WHERE $conditions";

        if(!$preparedStatement = $this->Database->prepare($sqlStatement)){
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $preparedStatement->execute($parameters);

        $fields = array();
        foreach($columns as $column){
            $name = $column;
            $$name = null;
            $fields[$name] = &$$name;
        }
        foreach($preparedStatement as $row){
            $item = new $modelCollection->ModelName($modelCollection);
            $item->FlagAsSaved();
            foreach($fields as $key => $value){
                $item->$key = $row[$key];
            }

            $result->Add($item);
        }

        return $result;
    }

    public function First($modelCollection)
    {
        $tableName = $modelCollection->ModelCache['MetaData']['TableName'];
        $primaryKey = $modelCollection->ModelCache['MetaData']['PrimaryKey'];
        $columns = array_keys($modelCollection->ModelCache['Columns']);

        $sqlStatement = "SELECT * FROM $tableName LIMIT 1";
        if(!$preparedStatement = $this->Database->prepare($sqlStatement)){
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $preparedStatement->execute();
        if($preparedStatement->rowCount() == 0){
            return null;
        }

        $row = $preparedStatement->fetch();
        $result = new $modelCollection->ModelName($modelCollection);
        $result->FlagAsSaved();
        foreach($columns as $key){
            $result->$key = $row[$key];
        }

        return $result;
    }

    public function Any($modelCollection, $conditions, $parameters)
    {
        $tableName = $modelCollection->ModelCache['MetaData']['TableName'];
        $primaryKey = $modelCollection->ModelCache['MetaData']['PrimaryKey'];

        $sqlStatement = "SELECT count($primaryKey) as RowExists FROM $tableName WHERE $conditions";

        if(!$preparedStatement = $this->Database->prepare($sqlStatement)){
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $preparedStatement->execute($parameters);
        $row = $preparedStatement->fetch();

        return $row['RowExists'] != 0;
    }

    public function Keys($modelCollection)
    {
        $result = array();

        $primaryKey = $modelCollection->ModelCache['MetaData']['PrimaryKey'];
        $tableName = $modelCollection->ModelCache['MetaData']['TableName'];

        $sqlStatement = "SELECT $primaryKey FROM $tableName";

        if(!$preparedStatement = $this->Database->prepare($sqlStatement)){
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $preparedStatement->execute();

        foreach($preparedStatement as $row){
            $result[] = $row[$primaryKey];
        }

        return $result;
    }

    public function All($modelCollection)
    {
        $result = new Collection();

        $tableName = $modelCollection->ModelCache['MetaData']['TableName'];
        $columns = array_keys($modelCollection->ModelCache['Columns']);

        $sqlStatement = "SELECT * FROM $tableName";

        if(!$preparedStatement = $this->Database->prepare($sqlStatement)){
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $preparedStatement->execute();

        $fields = array();
        foreach($columns as $column){
            $name = $column;
            $$name = null;
            $fields[$name] = &$$name;
        }
        foreach($preparedStatement as $row){
            $item = new $modelCollection->ModelName($modelCollection);
            $item->FlagAsSaved();
            foreach($fields as $key => $value){
                $item->$key = $row[$key];
            }

            $result->Add($item);
        }

        return $result;
    }

    public function Delete($modelCollection, $model)
    {
        if(!$model->IsSaved()){
            return;
        }

        $tableName = $modelCollection->ModelCache['MetaData']['TableName'];
        $primaryKey = $modelCollection->ModelCache['MetaData']['PrimaryKey'];
        $id = $model->$primaryKey;

        $sqlStatement = "DELETE FROM $tableName WHERE $primaryKey = ?;";
        if(!$preparedStatement = $this->Database->prepare($sqlStatement)){
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $params = array($id);
        $preparedStatement->execute($params);
    }

    public function Clear($modelCollection)
    {
        $tableName = $modelCollection->ModelCache['MetaData']['TableName'];

        $sqlStatement = "delete from $tableName";
        if(!$preparedStatement = $this->Database->prepare($sqlStatement)){
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->erroInfo);
        }

        $preparedStatement->execute();
    }

    public function Insert($modelCollection, &$model)
    {
        $tableName = $modelCollection->ModelCache['MetaData']['TableName'];
        $columns = implode($modelCollection->ModelCache['MetaData']['ColumnNames'], ',');
        $valuePlaceHolders = implode(CreateArray('?', count($modelCollection->ModelCache['MetaData']['ColumnNames'])),',');

        // Create the required SQL
        $sqlStatement = "INSERT INTO $tableName($columns) VALUES($valuePlaceHolders);";

        if(!$preparedStatement = $this->Database->prepare($sqlStatement)){
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $values = array();
        foreach($modelCollection->ModelCache['MetaData']['ColumnNames'] as $key){

            $value = $model->$key;
            $values[] = $value;
        }

        /*
        $params = array();
        foreach($values as $key => $value){
            if($value == '0'){
                $params[] = null;
            }else {
                $params[] = $values[$key];
            }
        }
        */

        if(!$preparedStatement->execute($values)){
            echo "Failed to execute PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $insertId = $this->Database->lastInsertId();

        $primaryKey = $modelCollection->ModelCache['MetaData']['PrimaryKey'];
        $model->$primaryKey = $insertId;
    }

    public function Update($modelCollection, $model)
    {
        if(!$model->IsDirty()){
            return;
        }

        $tableName = $modelCollection->ModelCache['MetaData']['TableName'];
        $primaryKey = $modelCollection->ModelCache['MetaData']['PrimaryKey'];
        $columns = $modelCollection->ModelCache['MetaData']['ColumnNames'];

        $values = array();
        foreach($columns as  $column){
            $values[] = $column . '=?';
        }
        $values = implode($values, ',');

        // Create the required SQL
        $sqlStatement = "UPDATE $tableName SET $values WHERE $primaryKey=?";

        if(!$preparedStatement = $this->Database->prepare($sqlStatement)){
            echo "Failed to prepare PDO statement";
            var_dump($this->Database->errorInfo());
        }

        $values = array();
        foreach($modelCollection->ModelCache['MetaData']['ColumnNames'] as $key){
            $values[] = $model->$key;
        }

        $id = $model->$primaryKey;

        $params = array();
        foreach($values as $key => $value){
            echo "$key = $value";
            if($value == '0'){
                $params[] = null;
            }else {
                $params[] = $values[$key];
            }
        }

        $params[] = $id;
        if(!$preparedStatement->execute($params)){
            echo "Failed to execute PDO statement";
            var_dump($this->Database->errorInfo());
        }
    }
}