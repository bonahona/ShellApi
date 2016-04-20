<?php
require_once('BackendController.php');
class ProjectLanguagesController extends BackendController
{

    public function Index()
    {
        $this->Title = 'Project Languages';
        $projectLanguages = $this->Models->ProjectLanguage->All();
        $this->Set('ProjectLanguages', $projectLanguages);
        return $this->View();
    }

    public function Create()
    {
        $this->Title = 'Create Project Language';

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $projectLanguage = $this->Data->Parse('ProjectLanguage', $this->Models->ProjectLanguage);
            $projectLanguage->Save();
            return $this->Redirect('/ProjectLanguages/');
        }else{
            $projectLanguage = $this->Models->ProjectLanguage->Create();
            $this->Set('ProjectLanguage', $projectLanguage);
            return $this->View();
        }
    }

    public function Edit($id)
    {
        if(empty($id)){
            return $this->HttpNotFound();
        }

        $this->Title = 'Edit Project Language';

        $projectLanguage = $this->Models->ProjectLanguage->Find($id);
        if($projectLanguage == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $projectLanguage = $this->Data->DbParse('ProjectLanguage', $this->Models->ProjectLanguage);
            $projectLanguage->Save();
            return $this->Redirect('/ProjectLanguages/');
        }else{
            $this->Set('ProjectLanguage', $projectLanguage);
            return $this->View();
        }
    }

    public function DeleteConfirm($id)
    {
        if(empty($id)){
        return $this->HttpNotFound();
    }

        $this->Title = 'Delete Project Language';

        $projectLanguage = $this->Models->ProjectLanguage->Find($id);
        if($projectLanguage == null){
            return $this->HttpNotFound();
        }

        $this->Set('ProjectLanguage', $projectLanguage);
        return $this->View();
    }

    public function Delete($id)
    {
        if(empty($id)){
            return $this->HttpNotFound();
        }

        if(!$this->IsPost()){
            return $this->Redirect('/ProjectLanguages/');
        }else{
            $projectLanguage = $this->Models->ProjectLanguage->Find($id);
            if($projectLanguage == null){
                return $this->HttpNotFound();
            }else{
                $projectLanguage->Delete();
                return $this->Redirect('/ProjectLanguages/');
            }
        }
    }
}