<?php
require_once('BackendController.php');
class InheritInterfacesController extends BackendController
{
    public function Create()
    {
        if($this->IsPost()){
            $implementsInheritance = $this->Data->Parse('InheritInterface', $this->Models->InheritInterface);
            $implementsInheritance->Save();
            return $this->Json($implementsInheritance->Object());
        }else{
            return $this->HttpNotFound();
        }
    }
}