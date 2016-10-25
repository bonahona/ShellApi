<?php

define('DEFAULT_MIME_TYPE', 'text/html');
define('DEFAULT_RETURN_CODE', '200');

class Controller
{
    // State data
    /* @var string */
    public $Action;

    /* @var string */
    public $Controller;

    /* @var string */
    public $Verb;

    /* @var string */
    public $RequestUri;

    /* @var string */
    public $RequestString;

    /* @var array */
    public $Parameters = array();        // Stores all parameters sent in in the uri that follow the Controller and Action

    /* @var Models */
    public $Models;

    /* @var FormHelper */
    public $Form;

    /* @var HtmlHelper */
    public $Html;

    /* @var ModelValidationHelper */
    public $ModelValidation;

    /* @var Core */
    public $Core;                       // Main core for this controller

    /* @var Core */
    public $CurrentCore;                // Should usually be the same one as the Core, but might during rendering, be set to some other one for resource purposes

    /* @var array */
    public $Config;

    /* @var Helpers */
    public $Helpers;                    // Reference the main core's helpers list

    /* @var Logging */
    public $Logging;

    /* @var Cache */
    public $Cache;                      // Reference to the Core's cache object

    // Data sent

    /* @var DataHelper */
    public $Post;                       // Stores all Post data variables sent in

    /* @var DataHelper */
    public $Get;                        // Stores all get variables sent in

    /* @var DataHelper */
    public $Data;                       // Stores both the Get and Post variables

    /* @var DataHelper */
    public $Files;                      // Stores any files sent with the request

    /* @var SessionHelper */
    public $Session = array();          // Stores all the session data

    /* @var array */
    public $Cookies = array();          // Stores all cookies sent

    /* @var string */
    public $Server = array();           // Stores all server variables

    /* @var array */
    public $Nonces = array();           // Nonce values fetched from the post data

    // Response data
    public $ReturnCode;
    public $MimeType;
    public $Title;
    public $Layout;

    // Data that will be used in the view
    public $ViewData = array();

    function __construct(){

        // Init the helpers
        $this->Form = new FormHelper($this);
        $this->Html = new HtmlHelper($this);
        $this->ModelValidation = new ModelValidationHelper();

        $this->ReturnCode = DEFAULT_RETURN_CODE;
        $this->MimeType = DEFAULT_MIME_TYPE;

        $this->Post = new DataHelper();
        $this->Get = new DataHelper();
        $this->Data = new DataHelper();
        $this->Files = new DataHelper();
        $this->Session = new SessionHelper();
    }

    public  function GetCore()
    {
        return $this->Core;
    }

    public function GetCurrentCore()
    {
        return $this->CurrentCore;
    }

    public function &GetViewData()
    {
        return $this->ViewData;
    }

    protected function IsPost(){
        return ($this->Verb == "POST");
    }

    protected function IsGet()
    {
        return ($this->Verb == "GET");
    }

    protected function Set($vars, $varValue = null){

        if(is_array($vars)){
            foreach($vars as $key => $value){
                $this->ViewData[$key] = $value;
            }
        }else {
            $this->ViewData[$vars] = $varValue;
        }
    }

    // Inserts a view in the current place int he view
    protected function PartialView($viewName, $partialViewVars = null)
    {
        $partialViewName = PartialViewPath($this->Core, $viewName);

        if(!file_exists($partialViewName)){
            trigger_error('Partial view missing ' . $partialViewName, E_USER_ERROR);
        }

        if($partialViewVars != null){
            if(is_array($partialViewVars)) {
                foreach ($partialViewVars as $key => $var) {
                    $$key = $var;
                }
            }else{
                trigger_error('$PartialViewVars is not an array', E_USER_ERROR);
            }
        }
        include($partialViewName);
    }

    // Different ways to render something
    protected function View($viewName = null){

        if($viewName == null){
            $viewName = $this->Action;
        }

        // Make sure the view exists
        $viewPath = ViewPath($this->Core, $this->Controller, $viewName);
        if(!file_exists($viewPath)) {
            trigger_error('Could not find view ' . $viewPath, E_USER_ERROR);
        }

        // Enable all the the view variables to be available in the view
        foreach($this->ViewData as $key => $value){
            $$key = $value;
        }

        $title = $this->Title;

        $this->BeforeRender();
        ob_start();
        include($viewPath);
        $view = ob_get_clean();

        $layouts = $this->GetLayoutPaths();

        if(empty($layouts)){
            echo $view;
            return;
        }

        // Go through the layout candidate files in order and make sure they exists. The first match will act as the layout for this view
        $foundLayout = null;
        foreach($layouts as $layout){
            if($foundLayout == null){
                if(file_exists($layout['layout'])){
                    $foundLayout = $layout;
                }
            }
        }

        if($foundLayout == null){
            echo $view;
        }else{
            $this->CurrentCore = $foundLayout['core'];
            include($foundLayout['layout']);
            $this->CurrentCore = $this->Core;
        }
    }

    protected function Json($data){
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    protected function Redirect($url, $vars = null, $code = 301){
        if($vars != null){
            $queryParts = array();
            foreach($vars as $key => $value){
                $queryParts[] = "$key=$value";
                $queryString = implode(',', $queryParts);
                header('Location:' . Url($url . '?' . $queryString), true, $code);
            }
        }else {
            header('Location: ' . Url($url), true, $code);
        }
        exit;
    }

    protected function SetType($type){
        header('Content-Type: ' . $type);
    }

    protected function HttpStatus($statusCode)
    {
        $this->ReturnCode = $statusCode;
    }

    function HttpNotFound()
    {
        return $this->HttpStatus(404);
    }

    // Looks trough the Application folder first, then the plugin folders for layout paths
    private function GetLayoutPaths()
    {
        $result = array();
        if($this->Layout == null || $this->Layout == ""){
            return $result;
        }

        if($this->Core->GetIsPrimaryCore()){
            $result[] = array('core' => $this->Core, 'layout' => LayoutPath($this->Core, $this->Layout));

            foreach($this->Core->GetPrimaryCore()->GetPlugins() as $core){
                if($core != $this->Core){
                    $result[] = array('core' => $core, 'layout' => LayoutPath($core, $this->Layout));
                }
            }
        }else{
            $result[] = array('core' => $this->Core->GetPrimaryCore(), 'layout' => LayoutPath($this->Core->GetPrimaryCore(), $this->Layout));
            $result[] = array('core' => $this->Core, 'layout' => LayoutPath($this->Core, $this->Layout));

            foreach($this->Core->GetPrimaryCore()->GetPlugins() as $core){
                if($core != $this->Core){
                    $result[] = array('core' => $core, 'layout' => LayoutPath($core, $this->Layout));
                }
            }
        }

        return $result;
    }

    // Gets the local layout path
    private function GetLayoutPath()
    {
        if($this->Layout == null || $this->Layout == ""){
            return false;
        }

        $layoutPath = LayoutPath($this->Core, $this->Layout);
        if(!file_exists($layoutPath)) {
            return false;
        }

        return $layoutPath;
    }

    public function SetLoggedInUser($user)
    {
        $this->Session['CurrentUser'] = $user;
    }

    public function LogoutCurrentUser()
    {
        $this->Session->Destroy();
    }

    public function IsLoggedIn()
    {
        if(isset($this->Session['CurrentUser'])){
            return true;
        }else{
            return false;
        }
    }

    protected function GetCurrentUser()
    {
        if(isset($this->Session['CurrentUser'])){
            return $this->Session['CurrentUser'];
        }else{
            return null;
        }
    }

    // Function is called before the actions is
    public function BeforeAction(){
    }

    // Function is called after the action but before the page is rendered
    protected function BeforeRender(){
        header('Content-Type: ' . $this->MimeType);
    }

    // CSRF protection using Nonces
    public function GenerateNonce($formName, $ttl = 1){
        $nonceValue = uniqid('', true);

        if(!isset($_SESSION['Nonces'])){
            $_SESSION['Engine']['Nonces'] = array();
        }

        $_SESSION['Nonces'][$formName] = array(
            'Value' => $nonceValue,
            'Ttl' => $ttl
        );

        return $nonceValue;
    }

    public function ValidateNonce($formName){
        if(isset($_SESSION['Nonces']) && isset($_SESSION['Nonces'][$formName])){

            $nonceEntry = $_SESSION['Nonces'][$formName];
            $nonceValue = "";
            if(isset($this->Nonces[$formName])){
                $nonceValue = $this->Nonces[$formName];
            }

            if($nonceEntry['Value'] == $nonceValue){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    // Adds a request identifier to the list of cached output for automatic output cache handling
    protected function EnableOutputCacheFor($requestData, $validity)
    {

    }

    // Manual adding of an output cache entry or updates an existing one
    protected function AddOutputCache($requestData, $output, $validity)
    {

    }

    // Manual invalidation
    protected function InvalidateOutputCache($requestData)
    {

    }

    // Manual check for a cache entry
    protected function IsOutputCached($requestData)
    {

    }
}