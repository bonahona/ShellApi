<?php
require_once('BackendController.php');
class PropertiesController extends BackendController
{
    public function Create($classId)
    {
        $this->Title = 'Create property';

        if(empty($classId)){
            return $this->HttpNotFound();
        }

        $projectClass = $this->Models->ProjectClass->Find($classId);
        if($projectClass == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $property = $this->Data->Parse('Property', $this->Models->Property);
            $property->Save();

            $redirectUrl = "/Projects/Details/" . $property->ProjectClass->Project->ProjectName . "/Classes/" . $property->ProjectClass->ClassName;
            return $this->Redirect($redirectUrl);
        }else{
            $property = $this->Models->Property->Create(array('ProjectClassId' => $classId, 'AccessModifierId' => 3));
            $this->Set('Property', $property);

            $projectClasses = $this->Models->ProjectClass->Where(array('ProjectId' => $projectClass->ProjectId));
            $this->Set('ProjectClasses', $projectClasses);

            $accessModifiers = $this->GetAccessModifierList();
            $this->Set('AccessModifiers', $accessModifiers);

            $this->Set('ProjectClass', $projectClass);

            return $this->View();
        }
    }

    public function Description($id)
    {
        $this->Title = 'Edit property documentation';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $property = $this->Models->Property->Find($id);
        if($property == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $property = $this->Data->DbParse('Property', $this->Models->Property);
            $property->Save();

            $redirectUrl = "/Projects/Details/" . $property->ProjectClass->Project->ProjectName . "/Classes/" . $property->ProjectClass->ClassName;
            return $this->Redirect($redirectUrl);
        }else{
            $this->Set('Property', $property);
            $this->Set('ProjectClass', $property->ProjectClass);

            return $this->View();
        }
    }

    public function Edit($id)
    {
        $this->Title = 'Edit property';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $property = $this->Models->Property->Find($id);
        if($property == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $property = $this->Data->DbParse('Property', $this->Models->Property);
            $property->Save();

            $redirectUrl = "/Projects/Details/" . $property->ProjectClass->Project->ProjectName . "/Classes/" . $property->ProjectClass->ClassName;
            return $this->Redirect($redirectUrl);
        }else{
            $this->Set('Property', $property);

            $projectClasses = $this->Models->ProjectClass->Where(array('ProjectId' => $property->ProjectClass->ProjectId));
            $this->Set('ProjectClasses', $projectClasses);

            $accessModifiers = $this->GetAccessModifierList();
            $this->Set('AccessModifiers', $accessModifiers);

            $this->Set('ProjectClass', $property->ProjectClass);

            return $this->View();
        }
    }
}