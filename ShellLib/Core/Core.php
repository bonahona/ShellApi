<?php
define('SERVER_ROOT', str_ireplace('/Index.php', '', $_SERVER['PHP_SELF']));
define('APPLICATION_ROOT',      $_SERVER['DOCUMENT_ROOT']);
define('APPLICATION_FOLDER',    '/Application');
define('CONFIG_FOLDER',         '/Config/');
define('CONTROLLER_FOLDER',     '/Controllers/');
define('MODELS_FOLDER',         '/Models/');
define('PLUGINS_FOLDER',        '/Plugins/');
define('HELPERS_FOLDER',        '/Helpers/');
define('VIEWS_FOLDER',          '/Views/');
define('PARTIAL_FOLDER',        '/Views/Partial/');
define('LAYOUTS_FOLDER',        '/Views/Layouts');
define('MODEL_CACHE_FOLDER',    '/Application/Temp/Cache/Models/');
define('CSS_FOLDER',            '/Content/Css/');
define('JS_FOLDER',             '/Content/Js/');
define('IMAGE_FOLDER',          '/Content/Images/');
define('DATABASE_DRIVER_FOLDER','./ShellLib/DatabaseDrivers/');

define('VIEW_FILE_ENDING', '.php');
define('MODEL_CACHE_FILE_ENDING', '.model');
define('PHP_FILE_ENDING', '.php');
define('CSS_FILE_ENDING', '.css');
define('JS_FILE_ENDING', '.js');

define('CORE_CLASS', 'Core');

require_once('./ShellLib/Core/ConfigParser.php');
require_once('./ShellLib/Core/Controller.php');
require_once('./ShellLib/Core/ModelProxy.php');
require_once('./ShellLib/Core/ModelProxyCollection.php');
require_once('./ShellLib/Core/Model.php');
require_once('./ShellLib/Core/IDatabaseDriver.php');
require_once('./ShellLib/Core/Models.php');
require_once('./ShellLib/Core/Helpers.php');
require_once('./ShellLib/Core/IHelper.php');
require_once('./ShellLib/Core/DatabaseWhereCondition.php');
require_once('./ShellLib/Core/CustomObjectSorter.php');
require_once('./ShellLib/Files/File.php');
require_once('./ShellLib/Logging/Logging.php');
require_once('./ShellLib/Helpers/DirectoryHelper.php');
require_once('./ShellLib/Helpers/ModelHelper.php');
require_once('./ShellLib/Helpers/UrlHelper.php');
require_once('./ShellLib/Helpers/ArrayHelper.php');
require_once('./ShellLib/Helpers/FormHelper.php');
require_once('./ShellLib/Helpers/ModelValidationHelper.php');
require_once('./ShellLib/Helpers/DataHelper.php');
require_once('./ShellLib/Helpers/SessionHelper.php');
require_once('./ShellLib/Helpers/HtmlHelper.php');
require_once('./ShellLib/Utility/StringUtilities.php');
require_once('./ShellLib/Utility/ArrayUtilities.php');

require_once('./ShellLib/Collections/ICollection.php');
require_once('./ShellLib/Collections/IDataCollection.php');
require_once('./ShellLib/Collections/Collection.php');
require_once('./ShellLib/Collections/ModelCollection.php');
require_once('./ShellLib/Collections/SqlCollection.php');


// External reference to the core instance
class Core
{
    public static $Instance;

    protected $ApplicationConfig;       // Generic application config. Applications and plugins are free to change this to their needs.
    protected $DatabaseConfig;          // Server information and credentials to the database to use (if any).
    protected $RoutesConfig;            // Contains hardcoded non-conventional routes aliases.
    protected $About;                   // About file is only loaded if any feature requiring it is called.

    protected $Logging;
    protected $ModelCache;
    protected $Models;
    protected $Helpers;
    protected $ModelHelper;
    protected $RequestUrl;
    protected $Database;
    protected $Controller;

    protected $IsPrimaryCode;

    // Used for the primary core of the application
    protected $Plugins;

    // Used for the plugins
    protected $PluginPath;
    protected $PrimaryCore;

    protected $ConfigFolder;
    protected $ModelFolder;
    protected $HelperFolder;
    protected $ControllerFolder;
    protected $ViewFolder;
    protected $PartialFolder;
    protected $LayoutFolder;
    protected $CssFolder;
    protected $JsFolder;
    protected $ImageFolder;

    public function GetIsPrimaryCore()
    {
        return $this->IsPrimaryCode;
    }

    public function &GetModelCache(){
        return $this->ModelCache;
    }

    public function &GetDatabase(){
        return $this->Database;
    }

    public function &GetLogging(){
        return $this->Logging;
    }

    public function &GetModelHelper(){
        return $this->ModelHelper;
    }

    public function GetRequestUrl(){
        return $this->RequestUrl;
    }

    public function GetConfigFolder()
    {
        return $this->ConfigFolder;
    }

    public function GetModelFolder()
    {
        return $this->ModelFolder;
    }

    public function GetHelperFolder()
    {
        return $this->HelperFolder;
    }

    public function &GetController()
    {
        return $this->Controller;
    }

    public function GetControllerFolder()
    {
        return $this->ControllerFolder;
    }

    public function GetViewFolder()
    {
        return $this->ViewFolder;
    }

    public function GetPartialFolder()
    {
        return $this->PartialFolder;
    }

    public function GetLayoutFolder()
    {
        return  $this->LayoutFolder;
    }

    public function GetCssFolder()
    {
        return  $this->CssFolder;
    }

    public function GetJsFolder()
    {
        return  $this->JsFolder;
    }

    public function GetImageFolder()
    {
        return  $this->ImageFolder;
    }

    public function GetApplicationConfig()
    {
        return $this->ApplicationConfig;
    }

    public function &GetPrimaryCore()
    {
        return $this->PrimaryCore;
    }

    public function &GetPlugins()
    {
        return $this->Plugins;
    }

    public function &GetHelpers()
    {
        return $this->Helpers;
    }

    public function &GetModels()
    {
        return $this->Models;
    }

    // Creates the core object that is used for the application and any plugins that are included
    // SubPath is used when a plugin is created where the path supplied points out the relative path to the plugin (For model and controller inclusions
    function __construct($subPath = null, $primaryCore = null)
    {
        if($subPath == null){
            $this->IsPrimaryCode = true;
            self::$Instance = $this;
            $this->PrimaryCore = $this;

            $this->ModelCache = array();
            $this->ModelHelper = new ModelHelper();

            $this->SetupFolders();
            if(!$this->ReadConfig()){
                die("Failed to read ApplicationConfig");
            }

            $this->Helpers = new Helpers();
            $this->SetupHelpers();
            $this->SetupLogs();
            $this->SetupDatabase();
            $this->CacheModels();

            $this->PluginPath = '';
            $this->SetupPlugins();

        }else{
            $this->IsPrimaryCode = false;
            $this->PluginPath = $subPath;
            $this->PrimaryCore = $primaryCore;

            $this->SetupPluginFolders();
            $this->ReadPluginConfig();
            $this->CacheModels();
            $this->Logging = $primaryCore->GetLogging();
            $this->Database = $primaryCore->GetDatabase();
            $this->Helpers = $primaryCore->GetHelpers();
            $this->SetupHelpers();
        }

        // We are now sure all models have been loaded and all plugins initialized
        if($subPath == null) {
            $this->UpdateModelReferences();
            $this->SetupModels();
        }
    }

    protected function SetupFolders()
    {
        $this->ConfigFolder = APPLICATION_FOLDER . CONFIG_FOLDER;
        $this->ModelFolder = APPLICATION_FOLDER . MODELS_FOLDER;
        $this->HelperFolder = APPLICATION_FOLDER . HELPERS_FOLDER;
        $this->ControllerFolder = APPLICATION_FOLDER . CONTROLLER_FOLDER;
        $this->ViewFolder = APPLICATION_FOLDER . VIEWS_FOLDER;
        $this->PartialFolder = APPLICATION_FOLDER . PARTIAL_FOLDER;
        $this->LayoutFolder = APPLICATION_FOLDER . LAYOUTS_FOLDER;
        $this->CssFolder = SERVER_ROOT . APPLICATION_FOLDER . CSS_FOLDER;
        $this->JsFolder = SERVER_ROOT . APPLICATION_FOLDER . JS_FOLDER;
        $this->ImageFolder = SERVER_ROOT . APPLICATION_FOLDER . IMAGE_FOLDER;
    }

    protected function SetupPluginFolders()
    {
        $this->ConfigFolder = $this->PluginPath . CONFIG_FOLDER;
        $this->ModelFolder = $this->PluginPath . MODELS_FOLDER;
        $this->HelperFolder = $this->PluginPath . HELPERS_FOLDER;
        $this->ControllerFolder = $this->PluginPath . CONTROLLER_FOLDER;
        $this->ViewFolder = $this->PluginPath . VIEWS_FOLDER;
        $this->PartialFolder = $this->PluginPath . PARTIAL_FOLDER;
        $this->LayoutFolder = $this->PluginPath . LAYOUTS_FOLDER;
        $this->CssFolder =  $this->PluginPath . CSS_FOLDER;
        $this->JsFolder =  $this->PluginPath . JS_FOLDER;
        $this->ImageFolder =  $this->PluginPath . IMAGE_FOLDER;
    }

    protected function ReadConfig()
    {
        // Read the application config
        $this->ApplicationConfig = ParseConfig($this, 'ApplicationConfig.json');
        if($this->ApplicationConfig === false){
            return false;
        }

        // Read database config
        $this->DatabaseConfig = ParseConfig($this, 'DatabaseConfig.json');
        if($this->DatabaseConfig === false){
            $this->DatabaseConfig = array();
        }

        // Read the routes config
        $this->RoutesConfig = ParseConfig($this, 'Routes.json');
        if($this->RoutesConfig === false) {
            $this->RoutesConfig = array();
        }

        return true;
    }

    protected function ReadPluginConfig()
    {
        $this->ApplicationConfig = ParseConfig($this, 'PluginConfig.json');
    }

    protected function SetupLogs()
    {
        $this->Logging = new Logging();
        if(!$this->Logging->SetupLoggers($this->ApplicationConfig)){
            die('Failed to setup logging');
        }
    }

    protected function SetupDatabase()
    {
        if(!empty($this->DatabaseConfig)) {

            $databaseType = $this->DatabaseConfig['Database']['DatabaseType'];

            // Handle the provider types given
            if($databaseType == 'MySqli'){
                $databaseProviderPath = DATABASE_DRIVER_FOLDER . 'MySqliDatabase.php';
                require_once($databaseProviderPath);
                $this->Database = new MySqliDatabase($this, $this->DatabaseConfig);
            }else if($databaseType == 'PDO'){
                $databaseProviderPath = DATABASE_DRIVER_FOLDER . 'PdoDatabase.php';
                require_once($databaseProviderPath);
                $this->Database = new PdoDatabase($this, $this->DatabaseConfig);
            }else{
                die("Unknown database provider type: $databaseType");
            }
        }
    }

    protected function DebugDontCacheModels()
    {
        // Read debug data from the log
        $dontCacheModels = false;
        if($this->ApplicationConfig !== false) {
            if (array_key_exists('Debug', $this->ApplicationConfig)) {
                if (array_key_exists('DontCacheModels', $this->ApplicationConfig['Debug'])) {
                    $dontCacheModels = $this->ApplicationConfig['Debug']['DontCacheModels'];
                }
            }
        }

        return $dontCacheModels;
    }

    protected function DebugDieOnRoutingError()
    {
        // Read debug data from the log
        $dieOnRoutingError = false;
        if($this->ApplicationConfig !== false) {
            if (array_key_exists('Debug', $this->ApplicationConfig)) {
                if (array_key_exists('DieOnRoutingError', $this->ApplicationConfig['Debug'])) {
                    $dieOnRoutingError = $this->ApplicationConfig['Debug']['DieOnRoutingError'];
                }
            }
        }

        return $dieOnRoutingError;
    }

    // Iterates over each model to make sure they are cached
    protected function CacheModels()
    {
        // Read debug data from the log
        $dontCacheModels = $this->DebugDontCacheModels();

        // Make sure the model folder exists
        $modelCacheFolder = Directory($this->ModelFolder);
        if(!is_dir($modelCacheFolder)){
            mkdir($modelCacheFolder, 777, true);
        }

        // Make sure the cache folder and cache folders exists
        $cacheFilePath = Directory(MODEL_CACHE_FOLDER);
        if(!is_dir($cacheFilePath)) {
            mkdir($cacheFilePath, 777, true);
        }

        $modelHelper = Core::$Instance->GetModelHelper();
        $modelFiles = GetAllFiles($modelCacheFolder);
        foreach($modelFiles as $modelFile){
            $cacheFile = $modelHelper->GetModelFilePath($modelFile);
            if(!file_exists($cacheFile)){
                $modelHelper->CacheModelFromModel($this, $modelFile, $cacheFile, $dontCacheModels);
            }else{
                $modelHelper->ReadModelCache($this, $modelFile, $cacheFile);
            }
        }
    }

    protected function SetupModels()
    {
        $this->Models = new Models();
        $this->Models->Setup($this->ModelCache);
    }

    protected function UpdateModelReferences()
    {
        if($this->ModelHelper->ReferencesUpdated()) {
            // Only include this file if its needed
            require_once('./ShellLib/Utility/Pluralizer.php');
            $pluralizer = new Pluralizer();
            foreach(array_keys($this->ModelCache) as $modelName) {
                $this->ModelHelper->CheckForReferences($modelName, $this->ModelCache[$modelName], $pluralizer);

                $dontCacheModels = $this->DebugDontCacheModels();
                if (!$dontCacheModels) {
                    $modelFileName = $this->ModelHelper->GetModelFilePath($modelName);
                    $this->ModelHelper->SaveModelCache($modelFileName, $modelName, $this->ModelCache[$modelName]);
                }
            }
        }
    }

    public function SetupHelpers()
    {
        $helperFileDirectory = Directory($this->HelperFolder);
        $helperFiles = GetAllFiles($helperFileDirectory);

        foreach($helperFiles as $helperFile){
            $helperFileName = $helperFileDirectory . $helperFile;
            $helperName = $this->Helpers->GetHelperName($helperFile);
            $helperClassName = $this->Helpers->GetHelperClassName($helperFile);
            $this->Helpers->AddHelperFile($helperName, $helperFileName, $helperClassName, $this->ApplicationConfig);
        }
    }

    public function ParseRequest()
    {
        // Find the current request folder
        $requestRoot = $_SERVER['SCRIPT_NAME'];
        $requestUrl = $_SERVER['REQUEST_URI'];

        $requestData = $this->ParseUrl($requestRoot, $requestUrl);
        $controllerName = $requestData['ControllerName'];
        $actionName = $requestData['ActionName'];
        $variables = $requestData['Variables'];

        $handler = $this->CreateHandler($controllerName, $actionName, $requestData);

        // The controller or the action does not exists. If debuging is on, die and give an error, otherwise reroute to the notFound route
        if($handler['error'] == 1){
            $dieOnRoutingError = $this->DebugDieOnRoutingError();
            if($dieOnRoutingError){
                die($handler['message']);
            }else{
                $notFoundHandler = $this->CreateNotFoundHandler($requestData);

                // If the not found handler, there is not much to do
                if($notFoundHandler['error'] == 1){
                    die('NotFoundHandler: ' . $notFoundHandler['message']);
                }

                $controller = $notFoundHandler['controller'];
                $actionName = $notFoundHandler['actionName'];
            }
        }else{
            $controller = $handler['controller'];
        }

        $this->ParseData($controller);

        // Call the action
        $controller->BeforeAction();
        call_user_func_array(array($controller, $actionName), $variables);

        // Set data based on the call
        if(function_exists('http_response_code')) {
            http_response_code($controller->ReturnCode);
        }

        // 404 errors use the notFound route specified in the application config
        if($controller->ReturnCode === 404){
            $notFoundHandler = $this->CreateNotFoundHandler($requestData);

            if($notFoundHandler['error'] == 1) {
                die('NotFoundHandler: ' . $notFoundHandler['message']);
            }else{
                $notFoundController = $notFoundHandler['controller'];
                $notFoundAction = $notFoundHandler['actionName'];

                $controller->BeforeAction();
                call_user_func_array(array($notFoundController, $notFoundAction), array());
            }
        }

        // Clean up
        $this->Database->Close();
    }

    public function GetControllerPath($controllerName, $requestData)
    {
        $usedCore = $this;
        $coreControllerPath = $this->CanHandleRoute($controllerName, $requestData);

        if($coreControllerPath !== false){
            return array(
                'path' => $coreControllerPath,
                'core' => $usedCore
            );
        }else{
            foreach($this->Plugins as $plugin){
                $usedCore = $plugin;
                $pluginControllerPath = $plugin->CanHandleRoute($controllerName, $requestData);
                if($pluginControllerPath !== false){
                    return array(
                        'path' => $pluginControllerPath,
                        'core' => $usedCore
                    );
                }
            }
        }

        return false;
    }

    public function CanHandleRoute($controllerName, $requestData)
    {
        $controllerClassName = $controllerName . 'Controller';
        $controllerPath = Directory($this->GetControllerFolder() . $controllerClassName . '.php');

        // Make sure the required controllers source file exists
        if(file_exists($controllerPath)){
            return $controllerPath;
        }else{
            return false;
        }
    }

    public function CreateHandler($controllerName, $actionName, $requestData)
    {
        // Find the controller to use
        $controllerClassName = $controllerName . 'Controller';
        $controllerPath = $this->GetControllerPath($controllerName, $requestData);

        // Make sure the required controllers source file exists
        if ($controllerPath === false){
            return array(
                'error' => 1,
                'message' => 'Controller path ' . $controllerClassName . ' not found'
            );
        }

        require_once($controllerPath['path']);

        // Instanciate the controller
        if(!class_exists($controllerClassName)) {
            return array(
                'error' => 1,
                'message' => 'Controller class ' . $controllerClassName . ' dont exists'
            );
        }

        $controller = new $controllerClassName;

        if(!method_exists($controller, $actionName)){
            return array(
                'error' => 1,
                'message' => 'Called action ' . $actionName . ' does not exists'
            );
        }

        $controller->Core           = $controllerPath['core'];
        $controller->CurrentCore    = $controllerPath['core'];
        $controller->Config         = $controllerPath['core']->GetApplicationConfig();
        $controller->Action         = $actionName;
        $controller->Controller     = $controllerName;
        $controller->Layout         = $this->ApplicationConfig['Application']['DefaultLayout'];
        $controller->Models         = $this->Models;
        $controller->RequestUri     = $requestData['RequestUri'];
        $controller->RequestString  = $requestData['RequestString'];
        $controller->Helpers        = $this->Helpers;
        $controller->Helpers->SetCurrentController($controller);

        return array(
            'error' => 0,
            'controller' => $controller,
            'actionName' => $actionName
        );
    }

    public function CreateNotFoundHandler($requestData)
    {
        if(!isset($this->ApplicationConfig['Application']['NotFoundController'])){
            return array(
                'error' => 1,
                'Application config missing NotFoundController'
            );
        }
        $notFoundControllerName = $this->ApplicationConfig['Application']['NotFoundController'];

        if(!isset($this->ApplicationConfig['Application']['NotFoundAction'])){
            return array(
                'error' => 1,
                'Application config missing NotFoundAction'
            );
        }
        $notFoundAction = $this->ApplicationConfig['Application']['NotFoundAction'];

        return $this->CreateHandler($notFoundControllerName, $notFoundAction, $requestData);
    }

    protected function ParseUrl($requestRoot, $requestUrl)
    {
        $requestString = $requestUrl;

        // If there is a query part of the request url, remove it
        if(strpos($requestUrl, '?') !== false) {
            $requestUrl = substr($requestUrl,0,strpos($requestUrl, '?'));
        }

        // Made sure the request url is valid with a trailing slash
        $requestUrl = rtrim($requestUrl, '/') . '/';

        // First, go trough the routes in the config and see if there is a route overriding the default routing
        foreach($this->RoutesConfig['Routes'] as $route => $routeData) {
            if (strcasecmp($route, $requestUrl) == 0) {
                return array(
                    'ControllerName' => $routeData['Controller'],
                    'ActionName' => $routeData['Action'],
                    'Variables' => array(),
                    'RequestUri' => $requestUrl,
                    'RequestString' => $requestString

                );
            }
        }

        $requestPath = explode('/', $requestRoot);

        // Remove only the last part of the string
        $requestRoot = str_replace(end($requestPath), '', $requestRoot);


        // If the request root is the root, there's nothing to clear out
        if($requestRoot != '/') {
            $requestResource = str_replace($requestRoot, '', $requestUrl);
        }else{
            $requestResource = $requestUrl;
        }

        $this->RequestUrl = $requestUrl;

        $requestParameters = explode('/', $requestResource);

        // Check if a specific controller has been specified
        if(!empty($requestParameters[1])){
            $controllerName = $requestParameters[1];
        }else{
            $controllerName = $this->ApplicationConfig['Application']['DefaultController'];
        }

        // Find if a specific action has been specified
        if(!empty($requestParameters[2])){
            $actionName = $requestParameters[2];
        }else{
            $actionName = $this->ApplicationConfig['Application']['DefaultAction'];
        }

        // Go through the rest of the parameters to filter out the variables
        $variables = array();
        foreach($requestParameters as $key => $parameter){
            // The first 3 are not used as variables
            if($key != 0 && $key != 1 && $key != 2){
                $variables[] = $parameter;
            }
        }

        return array(
            'ControllerName' => $controllerName,
            'ActionName' => $actionName,
            'Variables' => $variables,
            'RequestUri' => $requestUrl,
            'RequestString' => $requestString
        );
    }

    function ParseData($controller)
    {
        // Find the request method
        $controller->Verb = $_SERVER['REQUEST_METHOD'];

        // Parse the post data sent it
        if(isset($_POST)){
            foreach($_POST as $key => $value) {
                // Special case for the keyword 'data' as the automatic generated input tags uses that prefix
                if($key == 'data' && is_array($value)){
                    foreach($_POST['data'] as $subKey => $subValue){
                        $controller->Post->Add($subKey, $subValue);
                        $controller->Data->Add($subKey, $subValue);
                    }
                }else {
                    $controller->Post->Add($key, $value);
                    $controller->Data->Add($key, $value);
                }
            }
        }

        if(isset($_GET)){
            foreach($_GET as $key => $value) {
                $getData[$key] = $value;
                // Special case for the keyword 'data' as the automatic generated input tags uses that prefix
                if ($key == 'data' && is_array($value)) {
                    foreach ($value as $subKey => $subValue) {
                        $controller->Get->Add($subKey, $subValue);
                        $controller->Data->Add($subKey, $subValue);
                    }
                } else {
                    $controller->Get->Add($key, $value);
                    $controller->Data->Add($key, $value);
                }
            }
        }

        if(isset($_FILES)){
            foreach($_FILES as $key => $file) {
                if(is_array($file['name'])){

                    $files = new DataHelper();
                    for($i = 0; $i < count($file['name']); $i++){
                        $storedFile = new File();
                        if($file['error'][$i] == 0) {
                            $storedFile->Name = $file['name'][$i];
                            $storedFile->Size = $file['size'][$i];
                            $storedFile->Path = $file['tmp_name'][$i];
                            $storedFile->Type = $file['type'][$i];
                            $files[] = $storedFile;
                        }
                    }

                    $controller->Files[$key] = $files;
                }else{
                    if($file['error'] == 0) {
                        $storedFile = new File();
                        $storedFile->Name = $file['name'];
                        $storedFile->Size = $file['size'];
                        $storedFile->Path = $file['tmp_name'];
                        $storedFile->Type = $file['type'];

                        $controller->Files[$key] = $storedFile;
                    }
                }
            }
        }
    }

    public function SetupPlugins()
    {
        $this->Plugins = array();
        $pluginFolder = Directory(PLUGINS_FOLDER);
        if(!is_dir($pluginFolder)){
            mkdir($pluginFolder, 777, true);
        }
        foreach(GetAllDirectories($pluginFolder) as $plugin){
            $pluginCore = new Core(PLUGINS_FOLDER . $plugin, $this);
            $this->Plugins[] = $pluginCore;
        }
    }
}