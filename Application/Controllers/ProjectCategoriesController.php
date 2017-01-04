<?php
require_once('BackendController.php');
class ProjectcategoriesController extends BackendController
{
    public function Index()
    {
        $this->Title = "Project Categories";

        $projectCategories = $this->Models->ProjectCategory->All();
        $this->Set('ProjectCategories', $projectCategories);
        return $this->View();
    }

    public function Create()
    {
        $this->Title = "Create Project Categories";

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $projectCategory = $this->Data->Parse('ProjectCategory', $this->Models->ProjectCategory);
            $projectCategory->Save();
            return $this->Redirect('/ProjectCategories');
        }else{
            $projectCategory = $this->Models->ProjectCategory->Create();
            $this->Set('ProjectCategory', $projectCategory);
            return $this->View();
        }
    }

    public function Edit($id)
    {
        if(empty($id)){
            return $this->HttpNotFound();
        }

        $this->Title = "Create Project Categories";

        $projectCategory = $this->Models->ProjectCategory->Find($id);

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $projectCategory = $this->Data->DbParse('ProjectCategory', $this->Models->ProjectCategory);
            $projectCategory->Save();
            return $this->Redirect('/ProjectCategories/');
        }else{
            $this->Set('ProjectCategory', $projectCategory);
            return $this->View();
        }
    }

    public function DeleteConfirm($id)
    {
        if(empty($id)){
            return $this->HttpNotFound();
        }

        $this->Title = 'Delete Project Category';

        $projectCategory = $this->Models->ProjectCategory->Find($id);
        if($projectCategory == null){
            return $this->HttpNotFound();
        }

        $this->Set('ProjectCategory', $projectCategory);
        return $this->View();
    }

    public function Delete($id)
    {
        if(empty($id)){
            return $this->HttpNotFound();
        }

        if(!$this->IsPost()){
            return $this->Redirect('/ProjectCategories/');
        }else{
            $projectCategory = $this->Models->ProjectCategory->Find($id);
            if($projectCategory == null){
                return $this->HttpNotFound();
            }else{
                $projectCategory->Delete();
                return $this->Redirect('/ProjectCategories/');
            }
        }
    }
}