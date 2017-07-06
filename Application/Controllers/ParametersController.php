<?php
require_once('BackendController.php');
class ParametersController extends BackendController
{
    public function Create()
    {
        if($this->IsPost()){
            $parameter = $this->Data->Parse('Parameter', $this->Models->Parameter);
            $parameter->Save();

            $result = $parameter->Object();
            $result['Type'] = $parameter->Type->ClassName;
            return $this->Json($result);
        }

        return $this->HttpNotFound();
    }

    public function Delete($id)
    {
        if(empty($id)){
            return $this->HttpNotFound();
        }

        $parameter = $this->Models->Parameter->Find($id);
        if($parameter == null){
            return $this->HttpNotFound();
        }

        $parameter->Delete();

        return $this->Json(array('Status' => 'ok'));
    }
}