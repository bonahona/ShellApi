<?php
require_once('BackendController.php');
class ClassesController extends BackendController
{
    public function Create($projectId)
    {
        $this->Title = 'Create Class';

        if(empty($projectId)){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $class = $this->Data->Parse('ProjectClass', $this->Models->ProjectClass);
            $class->Save();
		
            $project = $this->Models->Project->Find($projectId);
            return $this->Redirect('/Projects/Details/' . $project->ProjectName);
        }else{
            $projects = $this->Models->Project->Where(array('IsActive' => '1'));
            $this->Set('Projects', $projects);

            $classes = $this->Models->ProjectClass->Where(array('ProjectId' => $projectId));
            $this->Set('Classes', $classes);

            $project = $this->Models->Project->Find($projectId);
            $this->Set('Project', $project);

            $class = $this->Models->ProjectClass->Create(array('ProjectId' => $projectId));
            $this->Set('ProjectClass', $class);

            return $this->View();
        }
    }

    public function Edit($id)
    {
        $this->Title = 'Edit Class';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $class = $this->Models->ProjectClass->Find($id);
        if($class == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $class = $this->Data->DbParse('ProjectClass', $this->Models->ProjectClass);
            $class->Save();
            return $this->Redirect('/Projects/Details/' . $class->Project->ProjectName);
        }else{
            $this->Set('ProjectClass', $class);

            $projects = $this->Models->Project->Where(array('IsActive' => '1'));
            $this->Set('Projects', $projects);

            $classes = $this->Models->ProjectClass->Where(array('ProjectId' => $class->ProjectId));
            $this->Set('Classes', $classes);

            return $this->View();
        }
    }

    public function MultiEditMethods($id)
    {
        $this->Title = 'Multi edit methods';

        if($id == null || $id == ''){
            return $this->HttpNotFound();
        }

        $projectClass = $this->Models->ProjectClass->Find($id);
        if($projectClass == null){
            return $projectClass;
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $methods = $this->Data->RawParse('Methods');

            foreach($methods as $methodData){
                $method = $this->Models->Method->Find($methodData['Id']);
                if($method != null) {
                    $method->ShortDescription = $methodData['Description'];
                    $method->Save();
                }
            }

            return $this->Redirect('/Projects/Details/' . $projectClass->Project->ProjectName . '/Classes/' . $projectClass->ClassName);
        }else{
            $methods = $this->Models->Method->Where(array('ProjectClassId' => $projectClass->Id))->OrderBy('MethodName');
            $this->Set('Methods', $methods);
            $this->Set('ProjectClass', $projectClass);

            return $this->View();
        }
    }

    public function Description($id)
    {
        $this->Title = 'Edit Class Description';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $class = $this->Models->ProjectClass->Find($id);
        if($class == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $class = $this->Data->DbParse('ProjectClass', $this->Models->ProjectClass);
            $class->Save();
            return $this->Redirect('/Projects/Details/' . $class->Project->ProjectName);
        }else{
            $this->Set('ProjectClass', $class);
            return $this->View();
        }
    }
}