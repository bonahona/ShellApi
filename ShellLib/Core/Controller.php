<?php

define('DEFAULT_MIME_TYPE', 'text/html');
define('DEFAULT_RETURN_CODE', '200');

class Controller
{
    // State data
    public $Action;
    public $Controller;
    public $Verb;
    public $RequestUri;
    public $RequestString;
    public $Parameters = array();        // Stores all parameters sent in in the uri that follow the Controller and Action
    public $Models;
    public $Form;
    public $Html;
    public $ModelValidation;
    public $Core;                       // Main core for this controller
    public $CurrentCore;                // Should usually be the same one as the Core, bit might, during rendering, be set to some other one for resource purposes
    public $Config;
    public $Helpers;                    // Reference the main core's helpers list

    // Data sent
    public $Post;                       // Stores all Post data variables sent in
    public $Get;                        // Stores all get variables sent in
    public $Data;                       // Stores both the Get and Post variables
    public $Files;                      // Stores any files sent with the request
    public $Session = array();          // Stores all the session data
    public $Cookies = array();          // Stores all cookies sent
    public $Server = array();           // Stores all server variables

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

    public function GetCore()
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

    public function IsPost(){
        return ($this->Verb == "POST");
    }

    public function IsGet()
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
            die('Partial view missing ' . $partialViewName);
        }

        if($partialViewVars != null){
            if(is_array($partialViewVars)) {
                foreach ($partialViewVars as $key => $var) {
                    $$key = $var;
                }
            }else{
                die('$PartialViewVars is not an array');
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

    public function GetCurrentUser()
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
    public function BeforeRender(){
        header('Content-Type: ' . $this->MimeType);
    }
}