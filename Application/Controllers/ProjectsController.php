<?php
class ProjectsController extends Controller
{
    public function Index()
    {
        $this->Title = 'Projects';

        $projectCategories = $this->Models->ProjectCategory->Where(array('IsActive' => 1));
        $this->Set('ProjectCategories', $projectCategories);
        return $this->View();
    }

    public function Details($projectName = '')
    {
        $this->Title = $projectName;

        $project = $this->Models->Project->Where(array('ProjectName' => $projectName, 'IsActive' => '1'))->First();

        if($project == null) {
            return $this->HttpNotFound();
        }
        $seeAlsoLinks = $this->Models->SeeAlsoLink->Where(array('ProjectId' => $project->Id));
        $this->Set('SeeAlsoLinks', $seeAlsoLinks);

        // For the logged in create new see aslo link modal window
        if($this->IsLoggedIn()){
            $this->Set('SeeAlsoLink', $this->Models->SeeAlsoLink->Create(array('ProjectId' => $project->Id)));
        }


        $this->Set('Project', $project);
        return $this->View();
    }
}