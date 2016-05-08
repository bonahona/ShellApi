<?php
class ProjectsController extends Controller
{
    public function Index()
    {
        $this->Title = 'Projects';

        $projectCategories = $this->Models->ProjectCategory->Where(array('IsActive' => 1));
        $this->Set('ProjectCategories', $projectCategories);

        $this->Set('Sidebar', $this->GenerateSidebar());

        return $this->View();
    }

    public function Details($projectName = '', $sectionType = '', $sectionName = '', $subsectionType = '', $subsectionName = '', $lowestType = '', $lowestName = '')
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
            return $this->ViewDocument($project, null, null, null, $document);
        }else if($this->StringEquals($sectionType, 'Classes') && $sectionName != '' && $this->StringEquals('Documents', $subsectionType) && $subsectionName != '') {
            $projectClass = $this->Models->ProjectClass->Where(array('ProjectId' => $project->Id, 'ClassName' => $sectionName))->First();
            $document = $this->Models->Document->Where(array('ClassId' => $projectClass->Id, 'NavigationTitle' => $subsectionName))->First();
            return $this->ViewDocument($project, $projectClass, null, null, $document);
        }else if($this->StringEquals($sectionType, 'Classes') && $sectionName != '' && $this->StringEquals('Properties', $subsectionType) && $subsectionName != '' && $lowestType == '') {
            $projectClass = $this->Models->ProjectClass->Where(array('ProjectId' => $project->Id, 'ClassName' => $sectionName))->First();
            $property = $this->Models->Property->Where(array('ProjectClassId' => $projectClass->Id, 'PropertyName' => $subsectionName))->First();
            return $this->ViewProperty($project, $projectClass, $property);
        }else if($this->StringEquals($sectionType, 'Classes') && $sectionName != '' && $this->StringEquals('Methods', $subsectionType) && $subsectionName != '') {
            $projectClass = $this->Models->ProjectClass->Where(array('ProjectId' => $project->Id, 'ClassName' => $sectionName))->First();
            return $this->ViewMethod($project, $projectClass, $subsectionName, $lowestType, $lowestName);
        }else if($this->StringEquals($sectionType, 'Classes') && $sectionName != '' && $this->StringEquals('Properties', $subsectionType) && $subsectionName != '' && $this->StringEquals($lowestType, 'Documents') && $lowestName != '') {
            $projectClass = $this->Models->ProjectClass->Where(array('ProjectId' => $project->Id, 'ClassName' => $sectionName))->First();
            $property = $this->Models->Property->Where(array('ProjectClassId' => $projectClass->Id, 'PropertyName' => $subsectionName))->First();
            $document = $this->Models->Document->Where(array('PropertyId' => $property->Id))->First();
            return $this->ViewDocument($project, $projectClass, null, $property, $document);
        }else{
            return $this->HttpNotFound();
        }
    }

    private function ViewProject($project)
    {
        $examples = $this->Models->Example->Where(array('ProjectId' => $project->Id));
        $this->Set('Examples', $examples);

        $documents = $this->Models->Document->Where(array('ProjectId' => $project->Id));
        $this->Set('Documents', $documents);

        $seeAlsoLinks = $this->Models->SeeAlsoLink->Where(array('ProjectId' => $project->Id));
        $this->Set('SeeAlsoLinks', $seeAlsoLinks);

        $publicClasses = $project->ProjectClasses->Where(array('ExternalSource' => ''));
        $this->Set('PublicClasses', $publicClasses);

        $this->Set('Sidebar', $this->GenerateSidebar($project));
        $this->Set('BreadCrumbs', $this->GenerateBreadCrumbs($project));

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
        $examples = $this->Models->Example->Where(array('ClassId' => $projectClass->Id));
        $this->Set('Examples', $examples);

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

        $this->Set('Sidebar', $this->GenerateSidebar($project, $projectClass));
        $this->Set('BreadCrumbs', $this->GenerateBreadCrumbs($project, $projectClass));

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

    private function ViewDocument($project, $class, $method, $property, $document)
    {
        if($document == null){
            return $this->HttpNotFound();
        }

        $this->Title = $document->PageTitle;

        $this->Set('Project', $project);
        $this->Set('Document', $document);

        $this->Set('Sidebar', $this->GenerateSidebar($project, null, $document));
        $this->Set('BreadCrumbs', $this->GenerateBreadCrumbs($project, $class, $method, $property, $document));

        return $this->View('ViewDocument');
    }

    private function ViewMethod($project, $projectClass, $methodName, $lowestType = '', $lowestName = '')
    {
        // Dissect the parameter list
        $methodName = urldecode($methodName);
        $methodParse = explode('(', $methodName);

        if(count($methodParse) == 0){
            return$this->HttpNotFound();
        }

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

        // Special case for methods. Now that one has been found we can check if a document is wanted
        if($this->StringEquals($lowestType, 'Documents')){
            $document = $this->Models->Document->Where(array('MethodId' => $foundMethod->Id, 'NavigationTitle' => $lowestName))->First();
            return $this->ViewDocument($project, $projectClass, $foundMethod, null, $document);
        }

        $this->Set('Project', $project);
        $this->Set('ProjectClass', $projectClass);
        $this->Set('Method', $foundMethod);

        $examples = $this->Models->Example->Where(array('MethodId' => $foundMethod->Id));
        $this->Set('Examples', $examples);

        $documents = $this->Models->Document->Where(array('MethodId' => $foundMethod->Id));
        $this->Set('Documents', $documents);

        $seeAlsoLinks = $this->Models->SeeAlsoLink->Where(array('MethodId' => $foundMethod->Id));
        $this->Set('SeeAlsoLinks', $seeAlsoLinks);

        $this->Set('Sidebar', $this->GenerateSidebar($project, $projectClass));
        $this->Set('BreadCrumbs', $this->GenerateBreadCrumbs($project, $projectClass, $foundMethod));

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
        $examples = $this->Models->Example->Where(array('PropertyId' => $property->Id));
        $this->Set('Examples', $examples);

        $this->Set('Project', $project);
        $this->Set('ProjectClass', $projectClass);
        $this->Set('Property', $property);

        $documents = $this->Models->Document->Where(array('PropertyId' => $property->Id));
        $this->Set('Documents', $documents);

        $seeAlsoLinks = $this->Models->SeeAlsoLink->Where(array('PropertyId' => $property->Id));
        $this->Set('SeeAlsoLinks', $seeAlsoLinks);

        $this->Set('Sidebar', $this->GenerateSidebar($project, $projectClass));
        $this->Set('BreadCrumbs', $this->GenerateBreadCrumbs($project, $projectClass, null, $property));

        // For the logged in create new see also link modal window
        if($this->IsLoggedIn()){
            $this->Set('SeeAlsoLink', $this->Models->SeeAlsoLink->Create(array('PropertyId' => $projectClass->Id)));
        }

        return $this->View('ViewProperty');
    }

    private function GenerateSidebar($project = null, $class = null, $document = null)
    {
        $result = array();

        if($project != null) {
            $projectEntry = array(
                'Title' => $project->ProjectName,
                'Items' => array()
            );

            $namespacesExists = $this->NamespacesExists($project);
            if($namespacesExists){
                $namespaces = $this->FilterClassesByNamespace($project);

                foreach($namespaces as $namespaceName => $namespace){
                    $namespaceEntry = array(
                        'SubsectionName' => 'Namespace ' . $namespaceName,
                        'Items' => array()
                    );

                    foreach($namespace as $projectClass){
                        $namespaceEntry['Items'][] = array(
                            'Link' => '/Projects/Details/' . $project->ProjectName . '/Classes/' . $projectClass->ClassName,
                            'DisplayName' => $projectClass->ClassName
                        );
                    }

                    $projectEntry['Items'][] = $namespaceEntry;
                }
            }else{
                $classes = $project->ProjectClasses->Where(array('IsPrimitive' => 0));
                foreach($classes as $projectClass){
                    $projectEntry['Items'][] = array(
                        'Link' => '/Projects/Details/' . $project->ProjectName . '/Classes/' . $projectClass->ClassName,
                        'DisplayName' => $projectClass->ClassName
                    );
                }
            }

            $documents = $this->Models->Document->Where(array('ProjectId' => $project->Id, 'ShowInMenu' => '1'));

            if(count($documents) > 0) {
                $documentSubSection = array(
                    'SubsectionName' => 'Documents',
                    'Items' => array()
                );

                foreach ($documents as $document) {
                    $documentSubSection['Items'][] = array(
                        'Link' => '/Projects/Details/' . $project->ProjectName . '/Documents/' . $document->NavigationTitle,
                        'DisplayName' => 'PageTitle'
                    );
                }

                $projectEntry['Items'][] = $documentSubSection;
            }

            $result[] = $projectEntry;
        }

        $projectCategories = $this->Models->ProjectCategory->Where(array('IsActive' => 1));

        foreach($projectCategories as $projectCategory){
            if(count($projectCategory->Projects) > 0) {
                $projectEntry = array(
                    'Title' => $projectCategory->Name,
                    'Items' => array()
                );

                foreach ($projectCategory->Projects->Where(array('IsActive' => 1)) as $project) {
                    $projectEntry['Items'][] = array(
                        'Link' => '/Projects/Details/' . $project->ProjectName,
                        'DisplayName' => $project->ProjectName
                    );
                }

                $result[] = $projectEntry;
            }
        }


        // Generate the standard links that all pages shows
        $result[] = array(
            'Items' => array(
                array(
                    'Link' => 'http://fyrvall.com',
                    'DisplayName' => 'Fyrvall.com'
                ),
                array(
                    'Link' => '/',
                    'DisplayName' => 'Documentation'
                )
            )
        );

        return $result;
    }

    private function NamespacesExists($project)
    {
        foreach($project->ProjectClasses->Where(array('IsPrimitive' => '0')) as $projectClass){
            if($projectClass !== ''){
                return true;
            }
        }

        return false;
    }

    private function FilterClassesByNamespace($project)
    {
        $result = array();

        foreach($project->ProjectClasses->Where(array('IsPrimitive' => '0')) as $projectClass){
            $namespace = $projectClass->Namespace;
            if($namespace !== ''){
                if(!isset($result[$namespace])){
                    $result[$namespace] = array();
                }

                $result[$namespace][] = $projectClass;

            }
        }

        return $result;
    }

    private function GenerateBreadCrumbs($project = null, $class = null, $method = null, $property = null, $document = null)
    {
        $result = array();

        if($project != null) {
            $result[] = array(
                'Link' => '/Projects/Details/' . $project->ProjectName,
                'Text' => $project->ProjectName
            );
        }

        if($class != null){
            $result[] = array(
                'Link' => '/Projects/Details/' . $project->ProjectName . '#Classes/',
                'Text' => 'Classes'
            );

            $result[] = array(
                'Link' => '/Projects/Details/' . $project->ProjectName . '/Classes/' . $class->ClassName,
                'Text' => $class->ClassName
            );
        }

        if($method != null){
            $result[] = array(
                'Link' => '/Projects/Details/' . $project->ProjectName. '/Classes/' . $class->ClassName . '#Methods/',
                'Text' => 'Methods'
            );

            $result[] = array(
                'Link' => '/Projects/Details/' . $project->ProjectName . '/Classes/' . $class->ClassName . '/Methods/' . $method->MethodName . $method->CreateLink(),
                'Text' => $method->MethodName
            );
        }

        if($property != null){
            $result[] = array(
                'Link' => '/Projects/Details/' . $project->ProjectName . '#Properties/',
                'Text' => 'Properties'
            );

            $result[] = array(
                'Link' => '/Projects/Details/' . $project->ProjectName . '/Classes/' . $class->ClassName . '/Properties/' . $property->PropertyName,
                'Text' => $property->PropertyName
            );
        }

        if($document != null)
        {
            if($class != null){
                if($method != null){
                    $result[] = array(
                        'Link' => '/Projects/Details/' . $project->ProjectName . '/Classes/' . $class->ClassName . '/Methods/' . $method->MethodName . $method->CreateLink() .'#Documents/',
                        'Text' => 'Documents'
                    );

                    $result[] = array(
                        'Link' => '/Projects/Details/' . $project->ProjectName . '/Classes/' . $class->ClassName . '/Methods/' . $method->MethodName . $method->CreateLink() . '/Documents/'. $document->NavigationTitle,
                        'Text' => $document->PageTitle
                    );
                }else if($property != null){
                    $result[] = array(
                        'Link' => '/Projects/Details/' . $project->ProjectName . '/Classes/' . $class->ClassName . '/Properties/' . $property->PropertyName .'#Documents/',
                        'Text' => 'Documents'
                    );

                    $result[] = array(
                        'Link' => '/Projects/Details/' . $project->ProjectName . '/Classes/' . $class->ClassName . '/Properties/' . $property->PropertyName . '/Documents/'. $document->NavigationTitle,
                        'Text' => $document->PageTitle
                    );
                }else{
                    $result[] = array(
                        'Link' => '/Projects/Details/' . $project->ProjectName . '/Classes/' . $class->ClassName . '#Documents/',
                        'Text' => 'Documents'
                    );

                    $result[] = array(
                        'Link' => '/Projects/Details/' . $project->ProjectName . '/Classes/' . $class->ClassName . '/Documents/'. $document->NavigationTitle,
                        'Text' => $document->PageTitle
                    );
                }
            }else{
                $result[] = array(
                    'Link' => '/Projects/Details/' . $project->ProjectName . '#Documents/',
                    'Text' => 'Documents'
                );

                $result[] = array(
                    'Link' => '/Projects/Details/' . $project->ProjectName . '/Documents/'. $document->NavigationTitle,
                    'Text' => $document->PageTitle
                );
            }
        }

        return $result;
    }

    private function StringEquals($a, $b)
    {
        return (strcasecmp($a, $b) == 0);
    }

}