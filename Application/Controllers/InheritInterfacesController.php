<?php
require_once('BackendController.php');
class InheritInterfacesController extends BackendController
{
    public function Create()
    {
        if($this->IsPost()){
            $implementsInheritance = $this->Data->Parse('InheritInterface', $this->Models->InheritInterface);
            $implementsInheritance->Save();

            $result = $implementsInheritance->Object();
            $result['Type'] = $implementsInheritance->InheritInterface->ClassName;
            return $this->Json($result);
        }else{
            return $this->HttpNotFound();
        }
    }

    public function Delete($id)
    {
        if(empty($id)) {
            return $this->HttpNotFound();
        }

        $implementsInheritance = $this->Models->InheritInterface->Find($id);
        if($implementsInheritance == null){
            return $this->HttpNotFound();
        }

        $implementsInheritance->Delete();
    }
}