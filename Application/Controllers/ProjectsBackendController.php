<?php
require_once('BackendController.php');
class ProjectsBackendController extends BackendController
{
    public function Index()
    {
        $this->Title = 'Projects';

        $projectCategories = $this->Models->ProjectCategory->All();
        $this->Set('ProjectCategories', $projectCategories);

        $uncategorizedProjects = $this->Models->Project->Where(array('ProjectCategoryId' => null));
        $this->Set('UncategorizedProjects', $uncategorizedProjects);

        return $this->View();
    }

    public function Create()
    {
        $this->Title = "Create Project";

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $project = $this->Data->Parse('Project', $this->Models->Project);
            $project->Save();
            return $this->Redirect('/ProjectsBackend/');
        }else{
            $project = $this->Models->Project->Create();
            $this->Set('Project', $project);

            $projectCategories = $this->Models->ProjectCategory->Where(array('IsActive' => 1));
            $this->Set('ProjectCategories', $projectCategories);

            $projectLanguages = $this->Models->ProjectLanguage->Where(array('IsActive' => 1));
            $this->Set('ProjectLanguages', $projectLanguages);

            return $this->View();
        }
    }

    public function Edit($id)
    {
        $this->Title = 'Edit Project';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $project = $this->Models->Project->Find($id);
        if($project == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $project = $this->Data->DbParse('Project', $this->Models->Project);
            $project->Save();
            return $this->Redirect('/ProjectsBackend/');
        }else{
            $this->Set('Project', $project);

            $projectCategories = $this->Models->ProjectCategory->Where(array('IsActive' => 1));
            $this->Set('ProjectCategories', $projectCategories);

            $projectLanguages = $this->Models->ProjectLanguage->Where(array('IsActive' => 1));
            $this->Set('ProjectLanguages', $projectLanguages);

            return $this->View();
        }
    }

    public function Description($id)
    {
        $this->Title = 'Edit Project Description';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $project = $this->Models->Project->Find($id);
        if($project == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $project = $this->Data->DbParse('Project', $this->Models->Project);
            $project->Save();
            return $this->Redirect('/ProjectsBackend/');
        }else{
            $this->Set('Project', $project);

            return $this->View();
        }
    }

    public function DeleteConfirm($id)
    {
        $this->Title = 'Delete Project';
    }

    public function Delete($id)
    {
    }
}