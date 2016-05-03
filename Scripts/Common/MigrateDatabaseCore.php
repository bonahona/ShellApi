<?php
define('APPLICATION_FOLDER',    '/Application');
define('CONFIG_FOLDER',         '/Config/');
define('MODELS_FOLDER',         '/Models/');
define('PLUGINS_FOLDER',        '/Plugins/');
define('MODEL_CACHE_FOLDER',    '/Application/Temp/Cache/Models/');
define('DATABASE_DRIVER_FOLDER','./ShellLib/DatabaseDrivers/');
define('MODEL_CACHE_FILE_ENDING', '.model');

require_once('/../../ShellLib/Core/ConfigParser.php');
require_once('/../../ShellLib/Core/Model.php');
require_once('/../../ShellLib/Core/Models.php');
require_once('/../../ShellLib/Helpers/DirectoryHelper.php');
require_once('/../../ShellLib/Helpers/ModelHelper.php');
require_once('/../../ShellLib/Collections/ICollection.php');
require_once('/../../ShellLib/Collections/IDataCollection.php');
require_once('/../../ShellLib/Collections/ModelCollection.php');

/* This class is really a scaled down version of the core in ShellLib, only resposible for Models and plugins (for their models)
*/
class MigrateDatabaseCore
{
    public static $Instance;

    protected $DatabaseConfig;          // Server information and credentials to the database to use (if any).
    protected $ModelCache;
    protected $Models;
    protected $ModelHelper;
    protected $IsPrimaryCode;

    // Used for the primary core of the application
    protected $Plugins;

    // Used for the plugins
    protected $PluginPath;
    protected $PrimaryCore;

    protected $ConfigFolder;
    protected $ModelFolder;

    public function __construct()
    {

    }

    protected function SetupFolders()
    {
        $this->ConfigFolder = APPLICATION_FOLDER . CONFIG_FOLDER;
        $this->ModelFolder = APPLICATION_FOLDER . MODELS_FOLDER;
    }

    protected function SetupPluginFolders()
    {
        $this->ConfigFolder = $this->PluginPath . CONFIG_FOLDER;
        $this->ModelFolder = $this->PluginPath . MODELS_FOLDER;
    }

    public function ExportDatabase($targetFile = null)
    {
        echo "Exporting database to " . $targetFile;
        touch($targetFile);
    }

    public function ImportDatabase($targetFile = null)
    {

    }
}