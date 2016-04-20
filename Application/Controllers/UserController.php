<?php
class UserController extends Controller
{
    public function BeforeAction()
    {
        if(!$this->IsLoggedIn() && !$this->Action == "Login"){
            $this->Redirect('/User/Login', array('ref' => $this->RequestUri));
        }
    }

    public function Index()
    {

    }

    public function Login($ref = null)
    {
        $this->Title = 'Login';
        if($this->IsPost() && !$this->Data->IsEmpty()){
            $user = $this->Data->RawParse('User');
            $this->SetLoggedInUser($user);

            if(empty($ref)){
                return $this->Redirect('/');
            }else{
                return $this->Redirect($ref);
            }
        }else{
            $this->Layout = 'Login';
            return $this->View();
        }
    }

    public function Logout()
    {
        $this->LogoutCurrentUser();
        return $this->Redirect('/User/Login');
    }
}