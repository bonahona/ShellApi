<?php
require_once('./ShellLib/Logging/DatabaseLog.php');
require_once('./ShellLib/Logging/FileLog.php');
class Logging
{
    protected $Loggers;

    function __construct()
    {
        $this->Loggers = array();
    }

    public function SetupLoggers($applicationConfig = null)
    {
        if($applicationConfig == null){
            return false;
        }

        // No logging element found in the config
        if(!isset($applicationConfig['Logging'])){
            return true;
        }

        // Logging element found but no loggers object in it
        if(!isset($applicationConfig['Logging']['Loggers'])){
            return true;
        }

        foreach ($applicationConfig['Logging']['Loggers'] as $logger) {
            foreach($logger as $type => $config) {

                if(isset($config['Name'])){
                    $name = $config['Name'];
                }

                if ($type == 'FileLog') {
                    $logObject = new FileLog();
                } else if ($type == 'DatabaseLog') {
                    $logObject = new DatabaseLog();
                }

                if(isset($logObject) && isset($name)){
                    $this->Loggers[$name] = $logObject;
                }
            }
        }

        // Everything went well
        return true;
    }

    public function __get($loggerName)
    {
        if(array_key_exists($loggerName, $this->Loggers)){
            return $this->Loggers[$loggerName];
        }else{
            return null;
        }
    }
}