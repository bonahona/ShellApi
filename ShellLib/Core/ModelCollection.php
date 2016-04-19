<?php
/**
 * Wrapper around a model to allow for model interaction such as load and save of data to the database
 */

define('INT', "i");
define('STRING', "s");

class ModelCollection
{
    public $ModelCache;
    public $ModelName;

    public function Create()
    {
        return new $this->ModelName($this);
    }

    public function Find($id)
    {
        $db = Core::$Instance->GetDatabase();
        $tableName = $this->ModelCache['MetaData']['TableName'];
        $primaryKey = $this->ModelCache['MetaData']['PrimaryKey'];
        $columns = array_keys($this->ModelCache['Columns']);

        $sqlStatement = "SELECT * FROM $tableName WHERE $primaryKey = ?;";
        if(!$preparedStatement = $db->Database->prepare($sqlStatement)){
            echo $db->Database->error;
        }


        $params = array(
            $this->ModelCache['Columns'][$primaryKey]['PreparedStatementType'],
            &$id
        );

        call_user_func_array(array($preparedStatement, 'bind_param'), $params);
        $preparedStatement->execute();
        if(!$meta = $preparedStatement->result_metadata()){
            return null;
        }

        // Make sure something was found ur return null
        $preparedStatement->store_result();
        if($preparedStatement->num_rows == 0){
            return null;
        }

        $fields = array();
        foreach($columns as $column){
            $name = $column;
            $$name = null;
            $fields[$name] = &$$name;
        }

        call_user_func_array(array($preparedStatement, 'bind_result'), $fields);

        $preparedStatement->fetch();
        $preparedStatement->close();

        $result = new $this->ModelName($this);
        $result->FlagAsSaved();
        foreach($fields as $key => $value){
            $result->$key = $value;
        }

        return $result;
    }

    public function Exists($id)
    {
        $db = Core::$Instance->GetDatabase();
        $tableName = $this->ModelCache['MetaData']['TableName'];
        $primaryKey = $this->ModelCache['MetaData']['PrimaryKey'];

        $sqlStatement = "SELECT count($primaryKey) as elementExists FROM $tableName WHERE $primaryKey = ?;";
        if(!$preparedStatement = $db->Database->prepare($sqlStatement)){
            echo $db->Database->error;
        }

        $params = array(
            $this->ModelCache['Columns'][$primaryKey]['PreparedStatementType'],
            &$id
        );

        call_user_func_array(array($preparedStatement, 'bind_param'), $params);
        $preparedStatement->execute();
        if(!$meta = $preparedStatement->result_metadata()){
            return false;
        }

        // Make sure something was found ur return null
        $preparedStatement->store_result();
        if($preparedStatement->num_rows == 0){
            return false;
        }

        $elementExists = "";
        $fields = array(
            'elementExists' => &$elementExists
        );

        call_user_func_array(array($preparedStatement, 'bind_result'), $fields);

        $preparedStatement->fetch();
        $preparedStatement->close();

        if($elementExists == 0){
            return false;
        }

        return true;
    }

    public function Where($conditions)
    {
        $result = new Collection();

        $db = Core::$Instance->GetDatabase();
        $tableName = $this->ModelCache['MetaData']['TableName'];
        $columns = array_keys($this->ModelCache['Columns']);

        if(!is_array($conditions)){
            return null;
        }

        $whereClause = "";
        $whereType = array();
        foreach($conditions as $key => $value){
            $whereClause[] = "$key = ?";
            if(is_string($value)){
                $whereType[] = STRING;
            }else if(is_int($value)){
                $whereType[] = INT;
            }
        }

        $whereClause = implode($whereClause," AND ");
        $whereType = implode($whereType,"");
        $sqlStatement = "SELECT * FROM $tableName WHERE $whereClause";

        if(!$preparedStatement = $db->Database->prepare($sqlStatement)){
            echo $db->Database->error;
        }

        $params = array(&$whereType);
        foreach($conditions as &$value){
            $params[] = &$value;
        }

        call_user_func_array(array($preparedStatement, 'bind_param'), $params);
        $preparedStatement->execute();
        if(!$meta = $preparedStatement->result_metadata()){
            return null;
        }

        $fields = array();
        foreach($columns as $column){
            $name = $column;
            $$name = null;
            $fields[$name] = &$$name;
        }

        call_user_func_array(array($preparedStatement, 'bind_result'), $fields);

        while($preparedStatement->fetch()){
            $item = new $this->ModelName($this);
            $item->FlagAsSaved();
            foreach($fields as $key => $value){
                $item->$key = $value;
            }

            $result->Add($item);
        }

        $preparedStatement->close();

        return $result;
    }

    public function All()
    {
        $result = new Collection();

        $db = Core::$Instance->GetDatabase();
        $tableName = $this->ModelCache['MetaData']['TableName'];
        $columns = array_keys($this->ModelCache['Columns']);

        $sqlStatement = "SELECT * FROM $tableName";
        if(!$preparedStatement = $db->Database->prepare($sqlStatement)){
            echo $db->Database->error;
        }

        $preparedStatement->execute();
        if(!$meta = $preparedStatement->result_metadata()){
            return null;
        }

        $fields = array();
        foreach($columns as $column){
            $name = $column;
            $$name = null;
            $fields[$name] = &$$name;
        }

        call_user_func_array(array($preparedStatement, 'bind_result'), $fields);

        while($preparedStatement->fetch()){
            $item = new $this->ModelName($this);
            $item->FlagAsSaved();
            foreach($fields as $key => $value){
                $item->$key = $value;
            }

            $result->Add($item);
        }

        $preparedStatement->close();

        return $result;
    }

    public function Save($model){

        $db = Core::$Instance->GetDatabase();

        if($model->IsSaved()){
            $this->Update($model, $db);
        }else{
            $this->Insert($model, $db);
        }
    }

    public function Delete($model)
    {
        if(!$model->IsSaved()){
            return;
        }

        $db = Core::$Instance->GetDatabase();
        $tableName = $this->ModelCache['MetaData']['TableName'];
        $primaryKey = $this->ModelCache['MetaData']['PrimaryKey'];
        $id = $model->$primaryKey;

        $sqlStatement = "DELETE FROM $tableName WHERE $primaryKey = ?;";
        if(!$preparedStatement = $db->Database->prepare($sqlStatement)){
            echo $db->Database->error;
        }


        $params = array(
            $this->ModelCache['Columns'][$primaryKey]['PreparedStatementType'],
            &$id
        );

        call_user_func_array(array($preparedStatement, 'bind_param'), $params);
        $preparedStatement->execute();
        $preparedStatement->Close();
    }

    protected function Insert(&$model, $db)
    {
        $tableName = $this->ModelCache['MetaData']['TableName'];
        $columns = implode($this->ModelCache['MetaData']['ColumnNames'], ',');
        $valuePlaceHolders = implode(CreateArray('?', count($this->ModelCache['MetaData']['ColumnNames'])),',');

        // Create the required SQL
        $sqlStatement = "INSERT INTO $tableName($columns) VALUES($valuePlaceHolders);";

        if(!$preparedStatement = $db->Database->prepare($sqlStatement)){
            echo $db->Database->error;
        }

        $preparedStatementTypes = array();
        $values = array();
        foreach($this->ModelCache['MetaData']['ColumnNames'] as $key){
            $preparedStatementTypes[] = $this->ModelCache['Columns'][$key]['PreparedStatementType'];
            $values[] = $model->$key;
        }

        $preparedStatementTypes = implode($preparedStatementTypes);
        $params = array();
        $params[] = $preparedStatementTypes;
        foreach($values as $key => $value){
            $params[] = &$values[$key];
        }

        call_user_func_array(array($preparedStatement, 'bind_param'), $params);
        if(!$preparedStatement->execute()){
            echo $db->Database->error;
        }

        $insertId = $db->Database->insert_id;

        $primaryKey = $this->ModelCache['MetaData']['PrimaryKey'];
        $model->$primaryKey = $insertId;

        $preparedStatement->close();
    }

    protected function Update($model, $db)
    {
        if(!$model->IsDirty()){
            return;
        }

        $tableName = $this->ModelCache['MetaData']['TableName'];
        $primaryKey = $this->ModelCache['MetaData']['PrimaryKey'];
        $columns = $this->ModelCache['MetaData']['ColumnNames'];

        $values = array();
        foreach($columns as  $column){
            $values[] = $column . '=?';
        }
        $values = implode($values, ',');

        // Create the required SQL
        $sqlStatement = "UPDATE $tableName SET $values WHERE $primaryKey=?";

        if(!$preparedStatement = $db->Database->prepare($sqlStatement)){
            echo $db->Database->error;
        }

        $preparedStatementTypes = array();
        $values = array();
        foreach($this->ModelCache['MetaData']['ColumnNames'] as $key){
            $preparedStatementTypes[] = $this->ModelCache['Columns'][$key]['PreparedStatementType'];
            $values[] = $model->$key;
        }
        $preparedStatementTypes[] = $this->ModelCache['Columns'][$primaryKey]['PreparedStatementType'];

        $id = $model->$primaryKey;
        $preparedStatementTypes = implode($preparedStatementTypes);

        $params = array();
        $params[] = $preparedStatementTypes;
        foreach($values as $key => $value){
            $params[] = &$values[$key];
        }
        $params[] = &$id;

        call_user_func_array(array($preparedStatement, 'bind_param'), $params);
        $preparedStatement->execute();
        $preparedStatement->close();
    }
}