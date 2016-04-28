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

    public function Details($projectName = '', $sectionType = '', $sectionName = '')
    {
        $this->Title = $projectName;

        $project = $this->Models->Project->Where(array('ProjectName' => $projectName, 'IsActive' => '1'))->First();

        if($project == null) {
            return $this->HttpNotFound();
        }

        if($sectionType == ''){
            return $this->ViewProject($project);
        }else if($this->StringEquals($sectionType, 'Classes') && $sectionName != ''){
            $projectClass = $this->Models->ProjectClass->Where(array('ProjectId' => $project->Id, 'ClassName' => $sectionName))->First();
            return $this->ViewClass($project, $projectClass);
        }else if($this->StringEquals($sectionType, 'Documents') && $sectionName != '') {
            $document = $this->Models->Document->Where(array('ProjectId' => $project->Id, 'NavigationTitle' => $sectionName))->First();
            return $this->ViewDocument($project, $document);
        }else if($this->StringEquals($sectionType, 'Classes' && $sectionName != '')) {
        }else{
            return $this->HttpNotFound();
        }
    }

    private function ViewProject($project)
    {
        $documents = $this->Models->Document->Where(array('ProjectId' => $project->Id));
        $this->Set('Documents', $documents);

        $seeAlsoLinks = $this->Models->SeeAlsoLink->Where(array('ProjectId' => $project->Id));
        $this->Set('SeeAlsoLinks', $seeAlsoLinks);

        $publicClasses = $project->ProjectClasses->Where(array('ExternalSource' => ''));
        $this->Set('PublicClasses', $publicClasses);

        if($this->IsLoggedIn()){
            $externalClasses = $project->ProjectClasses->WhereNot(array('ExternalSource' => ''));
            $this->Set('ExternalClasses', $externalClasses);
        }

        // For the logged in create new see also link modal window
        if($this->IsLoggedIn()){
            $this->Set('SeeAlsoLink', $this->Models->SeeAlsoLink->Create(array('ProjectId' => $project->Id)));
        }

        $this->Set('Project', $project);
        return $this->View('ViewProject');
    }

    private function ViewClass($project, $projectClass)
    {
        $inheritInterfaces = $this->Models->InheritInterface->Where(array('ProjectClassId' => $projectClass->Id));
        $this->Set('InheritInterfaces', $inheritInterfaces);

        $publicMethods = $this->Models->Method->Where(array('ProjectClassId' => $project->Id, 'AccessModifierId' => 3, 'IsStatic' => '0'));
        $this->Set('PublicMethods', $publicMethods);

        $protectedMethods = $this->Models->Method->Where(array('ProjectClassId' => $project->Id, 'AccessModifierId' => 2, 'IsStatic' => '0'));
        $this->Set('ProtectedMethods', $protectedMethods);

        $staticMethods = $this->Models->Method->Where(array('ProjectClassId' => $project->Id, 'IsStatic' => '1'));
        $this->Set('StaticMethods', $staticMethods);

        $publicProperties =  $this->Models->Property->Where(array('ProjectClassId' => $project->Id, 'AccessModifierId' => 3, 'IsStatic' => '0'));
        $this->Set('PublicProperties', $publicProperties);

        $protectedProperties =  $this->Models->Property->Where(array('ProjectClassId' => $project->Id, 'AccessModifierId' => 2, 'IsStatic' => '0'));
        $this->Set('ProtectedProperties', $protectedProperties);

        $staticProperties =  $this->Models->Property->Where(array('ProjectClassId' => $project->Id, 'AccessModifierId' => 3, 'IsStatic' => '1'));
        $this->Set('StaticProperties', $staticProperties);

        $documents = $this->Models->Document->Where(array('ClassId' => $projectClass->Id));
        $this->Set('Documents', $documents);

        $seeAlsoLinks = $this->Models->SeeAlsoLink->Where(array('ClassId' => $projectClass->Id));
        $this->Set('SeeAlsoLinks', $seeAlsoLinks);

        // For the logged in create new see also link modal window
        if($this->IsLoggedIn()){
            $this->Set('SeeAlsoLink', $this->Models->SeeAlsoLink->Create(array('ClassId' => $projectClass->Id)));
            $this->Set('InheritInterface', $this->Models->InheritInterface->Create(array('ProjectClassId' => $projectClass->Id)));
            $this->Set('Classes', $project->ProjectClasses);
        }

        $this->Set('Project', $project);
        $this->Set('ProjectClass', $projectClass);

        return $this->View('ViewClass');
    }

    private function ViewDocument($project, $document)
    {
        $this->Title = $document->PageTitle;

        $this->Set('Project', $project);
        $this->Set('Document', $document);
        return $this->View('ViewDocument');
    }

    private function ViewMethod($project, $method)
    {
        return $this->View('ViewMethod');
    }

    private function ViewProperty($project, $property)
    {
        return $this->View('ViewProperty');
    }

    private function StringEquals($a, $b)
    {
        return (strcasecmp($a, $b) == 0);
    }

}