<?php
require_once('BackendController.php');
class MethodsController extends  BackendController
{
    public function Create($classId = null)
    {
        $this->Title = 'Create method';

        if(empty($classId)){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $method = $this->Data->Parse('Method', $this->Models->Method);
            $method->Save();

            $redirectUrl = "/Projects/Details/" . $method->ProjectClass->Project->ProjectName . "/Classes/" . $method->ProjectClass->ClassName;
            return $this->Redirect($redirectUrl);

        }else {
            $accessModifiers = $this->GetAccessModifierList();
            $this->Set('AccessModifiers', $accessModifiers);

            $projectClass = $this->Models->ProjectClass->Find($classId);
            $this->Set('ProjectClass', $projectClass);

            $projectClasses = $this->Models->ProjectClass->Where(array('ProjectId' => $projectClass->ProjectId));
            $this->Set('ProjectClasses', $projectClasses);

            $method = $this->Models->Method->Create(array('ProjectClassId' => $classId, 'AccessModifierId' => 3));
            $method->Load();

            $this->Set('Method', $method);

            return $this->View();
        }
    }

    public function Description($id = null)
    {
        $this->Title = 'Edit Method Description';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $method = $this->Models->Method->Find($id);
        if($method == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $method = $this->Data->DbParse('Method', $this->Models->Method);
            $method->Save();

            $redirectUrl = "/Projects/Details/" . $method->ProjectClass->Project->ProjectName . "/Classes/" . $method->ProjectClass->ClassName;
            return $this->Redirect($redirectUrl);
        }else{
            $this->Set('Method', $method);

            return $this->View();
        }
    }

    public function Edit($id = null)
    {
        $this->Title = 'Edit Method';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $method = $this->Models->Method->Find($id);
        if($method == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $method = $this->Data->DbParse('Method', $this->Models->Method);
            $method->ConvertNullToNull();
            $method->Save();
            
            $redirectUrl = "/Projects/Details/" . $method->ProjectClass->Project->ProjectName . "/Classes/" . $method->ProjectClass->ClassName;
            return $this->Redirect($redirectUrl);
        }else{
            $accessModifiers = $this->GetAccessModifierList();
            $this->Set('AccessModifiers', $accessModifiers);

            $projectClass = $this->Models->ProjectClass->Find($method->ProjectClassId);
            $this->Set('ProjectClass', $projectClass);

            $projectClasses = $this->Models->ProjectClass->Where(array('ProjectId' => $projectClass->ProjectId));
            $this->Set('ProjectClasses', $projectClasses);

            $genericTypes = $this->Models->GenericType->Where(array('MethodId' => $method->Id));
            $this->Set('GenericTypes', $genericTypes);

            $this->Set('Method', $method);

            return $this->View();
        }
    }

    public function Delete($id)
    {
        $method = $this->Models->Method->Find($id);

        if($method == null){
            return $this->HttpNotFound();
        }else{
            $method->Delete();
            $redirectUrl = "/Projects/Details/" . $method->ProjectClass->Project->ProjectName . "/Classes/" . $method->ProjectClass->ClassName;
            return $this->Redirect($redirectUrl);
        }
    }
}