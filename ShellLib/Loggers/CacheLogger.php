<?php
// The cache logger does not write its log to any specific place but only stores it in memory until the end of execution.
// The fetch method can e used to get an array of all the log entries that has been entered
// This logger is used to avoid the usage of var_dumps thatputs content directly ito the file stream. Instead, create a CacheLogger and write all var_dumps to it. Later, get them with Fetch();
class CacheLogger implements  ILog
{
    /* @var Logging */
    protected $Logging;         // Reference back to the logging instance for shared functionality

    /*@var array */
    protected $LogEntries;

    public function Setup($config, $logging)
    {
        $this->Logging = $logging;
        $this->LogEntries = array();
    }

    public function Log($message, $context = array(), $logLevel = LOGGING_NOTICE)
    {
        $this->LogEntries[] = array(
            'Data' => $this->Logging->Interpolate($message),
            'Context' => $context,
            'Level' => $logLevel
        );
    }

    public function Emergency($message, $context = array())
    {
        $this->Log($message, $context, LOGGING_EMERGENCY);
    }

    public function Alert($message, $context = array())
    {
        $this->Log($message, $context, LOGGING_ALERT);
    }

    public function Critical($message, $context = array())
    {
        $this->Log($message, $context, LOGGING_CRITICAL);
    }

    public function Error($message, $context = array())
    {
        $this->Log($message, $context, LOGGING_ERROR);
    }

    public function Warning($message, $context = array())
    {
        $this->Log($message, $context, LOGGING_WARNING);
    }

    public function Notice($message, $context = array())
    {
        $this->Log($message, $context, LOGGING_NOTICE);
    }

    public function Info($message, $context = array())
    {
        $this->Log($message, $context, LOGGING_INFO);
    }

    public function Debug($message, $context = array())
    {
        $this->Log($message, $context, LOGGING_DEBUG);
    }

    public function Fetch()
    {
        $result = array();

        foreach($this->LogEntries as $entry){
            $result[] = $entry['Data'];
        }
        return $result;
    }
}