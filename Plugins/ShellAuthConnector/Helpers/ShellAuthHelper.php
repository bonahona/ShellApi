<?php
class ShellAuthHelper implements  IHelper
{
    public $ApplicationName;
    public $PublicKey;

    public $ShellAuthServer;
    public $ShellAuthPort;
    public $ShellAuthMethodPaths;
    public $Controller;

    public function Init($config, $controller)
    {
        $this->ApplicationName = $config['ShellApplication']['Name'];
        $this->PublicKey = $config['ShellApplication']['PublicKey'];

        $this->ShellAuthServer = $config['ShellAuthServer']['Server'];
        $this->ShellAuthPort = $config['ShellAuthServer']['Port'];
        $this->ShellAuthMethodPaths = $config['ShellAuthServer']['MethodPaths'];

        $this->Controller = $controller;
    }

    public function CreateApplication($application)
    {
        $payLoad = array(
            'ShellApplication' => $application
        );

        $callPath = $this->GetApplicationPath('CreateApplication');
        return $this->SendToServer($payLoad, $callPath);
    }

    public function EditApplication($application)
    {
        $payload = array(
            'ShellApplication' => $application
        );

        $callPath = $this->GetApplicationPath('EditApplication');
        return $this->SendToServer($payload, $callPath);
    }

    public function DeleteApplication($id)
    {
        $payLoad = $id;
        $callPath = $this->GetApplicationPath('DeleteApplication');
        return $this->SendToServer($payLoad, $callPath);
    }

    public function GetApplication($id = null)
    {
        if($id == null){
            $payLoad = array();
        }else{
            $payLoad = array(
                'Id' => $id
            );
        }

        $callPath = $this->GetApplicationPath('GetApplication');
        return $this->SendToServer($payLoad, $callPath);
    }

    public function CreateUser($shellUser)
    {
        $payLoad = array(
            'ShellUser' => $shellUser
        );

        $callPath = $this->GetApplicationPath('CreateUser');
        return $this->SendToServer($payLoad, $callPath);
    }

    public function EditUser($shellUser)
    {
        $payLoad = array(
            'ShellUser' => $shellUser
        );

        $callPath = $this->GetApplicationPath('EditUser');
        return $this->SendToServer($payLoad, $callPath);
    }

    public function ResetPassword($userId, $password)
    {
        $payLoad = array(
            'ShellUser' => array(
                'Id' => $userId,
                'Password' => $password
            )
        );

        $callPath = $this->GetApplicationPath('ResetPassword');
        return $this->SendToServer($payLoad, $callPath);
    }

    public function Login($username, $password)
    {
        $payLoad = array(
            'ShellUser' => array(
                'Username' => $username,
                'Password' => $password,
            )
        );

        $callPath = $this->GetApplicationPath('Login');
        $response =  $this->SendToServer($payLoad, $callPath);

        if($response['Error'] == 0){
            $this->Controller->Session['SessionToken'] = $response['Data']['AccessToken'];
            $this->Controller->SetLoggedInUser($response['Data']['User']);
        }

        return $response;
    }

    public function Logout($accessToken = null)
    {
        if($accessToken == null){
            $accessToken = $this->Controller->Session['SessionToken'];
        }
        $payLoad = array(
            'AccessToken' => $accessToken
        );

        $callPath = $this->GetApplicationPath('Logout');
        $this->Controller->Session->Destroy();
        return $this->SendToServer($payLoad, $callPath);
    }

    public function CheckAccessToken($accessToken = null)
    {
        if($accessToken == null){
            $accessToken = $this->Controller->Session['SessionToken'];
        }
        $payLoad = array(
            'AccessToken' => $accessToken
        );

        $callPath = $this->GetApplicationPath('CheckAccessToken');
        return $this->SendToServer($payLoad, $callPath);
    }

    public function GetUser($id = null)
    {
        if($id != null){
            $payLoad = array(
                'Id' => $id
            );
        }else{
            $payLoad = array();
        }

        $callPath = $this->GetApplicationPath('GetUser');
        return $this->SendToServer($payLoad, $callPath);
    }

    public function GetLocalUsers()
    {
        $callPath = $this->GetApplicationPath('GetLocalUsers');
        return $this->SendToServer(array(), $callPath);
    }

    public function SetPrivilegeLevel($userLevel, $userId, $applicationId = null)
    {
        $payLoad = array(
            'ShellUserPrivilege' => array(
                'ShellUserId' => $userId,
                'UserLevel' => $userLevel
            )
        );

        if($applicationId != null){
            $payLoad['ShellUserPrivilege']['ShellApplicationId'] = $applicationId;
        }

        $callPath = $this->GetApplicationPath('SetPrivilegeLevel');
        return $this->SendToServer($payLoad, $callPath);
    }

    protected function GetApplicationPath($callName)
    {
        if(!array_key_exists($callName, $this->ShellAuthMethodPaths)){
            die("ShellAuthHelper callpath $callName does not exists");
        }
        $result = 'http://' . $this->ShellAuthServer . ":" . $this->ShellAuthPort . $this->ShellAuthMethodPaths[$callName];

        return $result;
    }

    protected function SendToServer($payload, $callPath)
    {
        $data = array(
            'ShellAuth' => array(
                'Application' => array(
                    'ApplicationName' => $this->ApplicationName
                ),
                'PayLoad' => $payload
            )
        );

        $data = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $callPath);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, "ShellAuthConnector");
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'data' => $data
        ));

        if(!$response = curl_exec($curl)){
            $curlError = curl_error($curl);
            //$curlErrorCode = curl_errno($curl);

            return array(
                'Error' => 1,
                    'ErrorList' => array(
                        $curlError
                    )
            );
        }

        curl_close($curl);
        return json_decode($response, true);
    }
}