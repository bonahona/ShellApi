<?php
class ProjectsController extends Controller
{
    public function Index()
    {
        $projectCategories = $this->Models->ProjectCategory->Where(array('IsActive' => 1));
        $this->Set('ProjectCategories', $projectCategories);
        return $this->View();
    }

    public function Details($projectName = '')
    {
        $project = $this->Models->Project->Where(array('ProjectName' => $projectName, 'IsActive' => '1'))->First();

        if($project == null){
            return $this->HttpNotFound();
        }

        $seeAlsoLinks = $this->Models->SeeAlsoLink->Where(array('ProjectId' => $project->Id));
        $this->Set('SeeAlsoLinks', $seeAlsoLinks);

        $this->Set('Project', $project);
        return $this->View();
    }
}