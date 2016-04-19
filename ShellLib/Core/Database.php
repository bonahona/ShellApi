<?php

class Database
{
    public $Database;
    public $Config;

    function __construct($core)
    {
        $config = ParseConfig($core, 'DatabaseConfig.json');

        if(!$config['Database']['UseDatabase']){
            return;
        }

        $db = new mysqli(
            $config['Database']['Server'],
            $config['Database']['Username'],
            $config['Database']['Password'],
            $config['Database']['Database']
        );

        if($db->connect_errno > 0){
            die('Unable to connect to database, ' . $db->connect_error);
        }

        $this->Database = $db;
        $this->Config = $config;
    }

    public function DescribeTable($tableName)
    {
        $sql = 'describe ' . $tableName;
        $resultSet = $this->Database->query($sql);

        if(!$resultSet){
            return false;
        }

        $columns = array();
        $referenceRows = array();
        while($row = mysqli_fetch_assoc($resultSet)){
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
            // Use the standard to determine what row is being references
            if(strpos($referenceRow['Field'], 'Id') !== false){
                $columnName = str_replace('Id', '', $referenceRow['Field']);
                $references[] = $columnName;
            }
        }

        // Find and set some metadata
        $metaData = array(
            'TableName' => $tableName,
            'PrimaryKey' => $primaryKey,
            'ColumnNames' => $this->GetColumnNames($columns, $primaryKey),
            'References' => $references
        );

        $result = array(
            'MetaData' => $metaData,
            'Columns' => $columns
        );

        return $result;
    }

    // Gets a list containing only the headers of the columns and leaves the primary key columns out
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

    public function Close()
    {
        if($this->Database != null) {
            $this->Database->close();
        }
    }
}