<?php
require_once('BackendController.php');
class ParametersController extends BackendController
{
    public function Create()
    {
        if($this->IsPost()){
            $parameter = $this->Data->Parse('Parameter', $this->Models->Parameter);
            $parameter->Save();
            return $this->Json($parameter->Object());
        }

        return $this->HttpNotFound();
    }
}