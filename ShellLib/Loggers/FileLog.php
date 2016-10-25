<?php
class FileLog implements ILog
{
    /* @var Logging */
    protected $Logging;         // Reference back to the logging instance for shared functionality
    protected $FileHandle;

    public function Setup($config, $logging)
    {
        $this->Logging = $logging;
        $this->FileHandle = null;

        if(!isset($config['Name'])){
            trigger_error('Missing FileLog name', E_USER_WARNING);
            return;
        }

        $name = $config['Name'];

        if(!isset($config['FileName'])){
            trigger_error('File logger ' . $name . ' is missing FileName atribute', E_USER_WARNING);
            return;
        }


        $fileName = $config['FileName'];
        $fileName = Directory($fileName);

        // Make sure the containing folder exists
        $fileDirectory = GetDirectoryFromFilePath($fileName);
        if(!is_dir($fileDirectory)){
            mkdir($fileDirectory, 777, true);
        }

        // Create the file for writing with append in mind. The pointer of the fle will be at the end of its current context
        $this->FileHandle = fopen($fileName, 'a');
    }

    public function Log($message, $context = array(), $logLevel = LOGGING_NOTICE)
    {
        if($this->FileHandle === null || $this->FileHandle === false){
            return;
        }

        $message = $logLevel . ': ' . $this->Logging->Interpolate($message,  $context);
        fwrite($this->FileHandle, $message . '\r\n');
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
}