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

    public function Details($projectName = '', $sectionType = '', $sectionName = '', $subsectionType = '', $subsectionName = '')
    {
        $this->Title = $projectName;

        $project = $this->Models->Project->Where(array('ProjectName' => $projectName, 'IsActive' => '1'))->First();

        if($project == null) {
            return $this->HttpNotFound();
        }

        if($sectionType == ''){
            return $this->ViewProject($project);
        }else if($this->StringEquals($sectionType, 'Classes') && $sectionName != '' && $subsectionType == ''){
            $projectClass = $this->Models->ProjectClass->Where(array('ProjectId' => $project->Id, 'ClassName' => $sectionName))->First();
            return $this->ViewClass($project, $projectClass);
        }else if($this->StringEquals($sectionType, 'Documents') && $sectionName != '') {
            $document = $this->Models->Document->Where(array('ProjectId' => $project->Id, 'NavigationTitle' => $sectionName))->First();
            return $this->ViewDocument($project, $document);
        }else if($this->StringEquals($sectionType, 'Classes') && $sectionName != '' && $this->StringEquals('Properties', $subsectionType) && $subsectionName != '') {
            $projectClass = $this->Models->ProjectClass->Where(array('ProjectId' => $project->Id, 'ClassName' => $sectionName))->First();
            $property = $this->Models->Property->Where(array('ProjectClassId' => $projectClass->Id, 'PropertyName' => $subsectionName))->First();
            return $this->ViewProperty($project, $projectClass, $property);
        }else if($this->StringEquals($sectionType, 'Classes') && $sectionName != '' && $this->StringEquals('Methods', $subsectionType) && $subsectionName != '') {
            $projectClass = $this->Models->ProjectClass->Where(array('ProjectId' => $project->Id, 'ClassName' => $sectionName))->First();
            return $this->ViewMethod($project, $projectClass, $subsectionName);
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

    private function ViewMethod($project, $projectClass, $methodName)
    {
        // Dissect the parameter list
        $methodName = urldecode($methodName);
        $methodParse = explode('(', $methodName);

        $methodName = $methodParse[0];
        $methodParametersString = str_replace(')', '', $methodParse[1]);

        if($methodParametersString === ''){
            $methodParameters = array();
        }else{
            $methodParameters = explode(',', $methodParametersString);
        }

        // Find a list of all matching methods based on the name alone
        $methods = $this->Models->Method->Where(array('ProjectClassId' => $projectClass->Id, 'MethodName' => $methodName));
        $this->Set('Methods', $methods);

        // Find the one that matches all the parameters in the list
        $foundMethod = null;
        foreach($methods as $method){
            if(count($methodParameters) > 0){
                $allMatches = true;
                $i = 0;
                foreach($method->Parameters as $parameter){
                    $i ++;
                    if(!$this->StringEquals($parameter->Type->ClassName,$methodParameters[0])){
                        $allMatches = false;
                    }
                }
                if($allMatches){
                    $foundMethod = $method;
                }
            }else{
                if(count($method->Parameters) == 0) {
                    $foundMethod = $method;
                }
            }
        }

        // The parameter/method name combination gave no results
        if($foundMethod == null){
            return $this->HttpNotFound();
        }

        $this->Set('Project', $project);
        $this->Set('ProjectClass', $projectClass);
        $this->Set('Method', $foundMethod);

        $documents = $this->Models->Document->Where(array('MethodId' => $method->Id));
        $this->Set('Documents', $documents);

        $seeAlsoLinks = $this->Models->SeeAlsoLink->Where(array('MethodId' => $method->Id));
        $this->Set('SeeAlsoLinks', $seeAlsoLinks);

        // For the logged in create new see also link modal window
        if($this->IsLoggedIn()){
            $classes = $this->Models->ProjectClass->Where(array('ProjectId' => $project->Id));
            $this->Set('Classes', $classes);
            $this->Set('Parameter', $this->Models->Parameter->Create(array('MethodId' => $foundMethod->Id)));
            $this->Set('SeeAlsoLink', $this->Models->SeeAlsoLink->Create(array('MethodId' => $method->Id)));
        }

        return $this->View('ViewMethod');
    }

    private function ViewProperty($project, $projectClass, $property)
    {
        $this->Set('Project', $project);
        $this->Set('ProjectClass', $projectClass);
        $this->Set('Property', $property);

        $documents = $this->Models->Document->Where(array('PropertyId' => $property->Id));
        $this->Set('Documents', $documents);

        $seeAlsoLinks = $this->Models->SeeAlsoLink->Where(array('PropertyId' => $property->Id));
        $this->Set('SeeAlsoLinks', $seeAlsoLinks);

        // For the logged in create new see also link modal window
        if($this->IsLoggedIn()){
            $this->Set('SeeAlsoLink', $this->Models->SeeAlsoLink->Create(array('PropertyId' => $projectClass->Id)));
        }

        return $this->View('ViewProperty');
    }

    private function StringEquals($a, $b)
    {
        return (strcasecmp($a, $b) == 0);
    }

}