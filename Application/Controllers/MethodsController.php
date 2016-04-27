<?php
require_once('BackendController.php');
class MethodsController extends  BackendController
{
    public function Create($classId = null)
    {
        if(empty($classId)){
            return $this->HttpNotFound();
        }

        $accessModifiers = $this->GetAccessModifierList();
        $this->Set('AccessModifiers', $accessModifiers);

        $projectClass = $this->Models->ProjectClass->Find($classId);
        $this->Set('ProjectClass', $projectClass);

        $projectClasses = $this->Models->ProjectClass->Where(array('ProjectId' => $projectClass->ProjectId));
        $this->Set('ProjectClasses', $projectClasses);

        $method = $this->Models->Method->Create(array('ProjectClassId' => $classId, 'AccessModifierId' => 3));
        $this->Set('Method', $method);

        return $this->View();
    }
}