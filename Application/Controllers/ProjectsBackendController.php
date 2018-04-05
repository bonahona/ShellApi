<?php
require_once('BackendController.php');
class ProjectsbackendController extends BackendController
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

    public function MultiEditClasses($id)
    {
        $this->Title = 'Multi Edit classes';

        if($id == null || $id == ''){
            return $this->HttpNotFound();
        }

        $project = $this->Models->Project->Find($id);
        if($project == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $parsedClasses = $this->Data->RawParse('Classes');

            foreach($parsedClasses as $classData){
                $class = $this->Models->ProjectClass->Find($classData['Id']);
                if($class != null){
                    $class->ShortDescription = $classData['Description'];
                    $class->Save();
                }
            }

            return $this->Redirect('/Projects/Details/' . $project->ProjectName);
        }else{
            $classes = $this->Models->ProjectClass->Where(array('ProjectId' => $project->Id, 'IsPrimitive' => 0))->OrderBy('ClassName');
            $this->Set('Classes', $classes);
            $this->Set('Project', $project);

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

        $this->EnqueueCssFiles([
            'summernote.css',
        ]);

        $this->EnqueueJavascript([
            'summernote.min.js',
            'editor.js'
        ]);

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

    public function GenerateDefaultPrimitives($id)
    {
        if(empty($id)){
            return $this->HttpNotFound();
        }

        $project = $this->Models->Project->Find($id);
        if($project == null){
            return $this->HttpNotFound();
        }

        if($project->ProjectLanguage->DisplayName == 'C#'){
            $generatedClasses = $this->GenerateCSharpClasses($project);
        }else if($project->ProjectLanguage->DisplayName == 'Php'){
             $generatedClasses = $this->GeneratePhpClasses($project);
        }

    }

    private function GenerateCSharpClasses($project)
    {
        $result = array();

        if(!$this->ClassExist('byte', $project)) {
            $byteClass = $this->GenerateClass('byte', 'https://msdn.microsoft.com/en-us/library/system.byte%28v=vs.90%29.aspx', $project);
            $result[] = $byteClass;
        }

        if(!$this->ClassExist('double', $project)) {
            $doubleClass = $this->GenerateClass('double', 'https://msdn.microsoft.com/en-us/library/system.double%28v=vs.90%29.aspx', $project);
            $result[] = $doubleClass;
        }

        if(!$this->ClassExist('char', $project)) {
            $charClass = $this->GenerateClass('char', 'https://msdn.microsoft.com/en-us/library/system.char%28v=vs.90%29.aspx', $project);
            $result[] = $charClass;
        }

        if(!$this->ClassExist('int', $project)) {
            $intClass = $this->GenerateClass('int', 'https://msdn.microsoft.com/en-us/library/5kzh1b5w.aspx', $project);
            $result[] = $intClass;
        }

        if(!$this->ClassExist('long', $project)) {
            $longClass = $this->GenerateClass('long', 'https://msdn.microsoft.com/en-us/library/ctetwysk.aspx', $project);
            $result[] = $longClass;
        }

        if(!$this->ClassExist('bool', $project)) {
            $boolClass = $this->GenerateClass('bool', 'https://msdn.microsoft.com/en-us/library/c8f5xwh7.aspx', $project);
            $result[] = $boolClass;
        }

        if(!$this->ClassExist('float', $project)) {
            $floatClass = $this->GenerateClass('float', 'https://msdn.microsoft.com/en-us/library/b1e65aza.aspx', $project);
            $result[] = $floatClass;
        }

        if(!$this->ClassExist('void', $project)) {
            $voidClass = $this->GenerateClass('void', 'https://msdn.microsoft.com/en-us/library/yah0tteb.aspx', $project);
            $result[] = $voidClass;
        }

        if(!$this->ClassExist('String', $project)) {
            $stringClass = $this->GenerateClass('String', 'https://msdn.microsoft.com/en-us/library/system.string%28v=vs.90%29.aspx', $project);
            $result[] = $stringClass;
        }

        if(!$this->ClassExist('Object', $project)) {
            $objectClass = $this->GenerateClass('Object', 'https://msdn.microsoft.com/en-us/library/system.object(v=vs.90).aspx', $project);
            $result[] = $objectClass;
        }

        return $result;
    }

    private function GeneratePhpClasses($project)
    {
        $result = array();

        if(!$this->ClassExist('boolean', $project)) {
            $booleanClass = $this->GenerateClass('boolean', 'http://php.net/manual/en/language.types.boolean.php', $project);
            $result[] = $booleanClass;
        }

        if(!$this->ClassExist('integers ', $project)) {
            $intergerClass = $this->GenerateClass('integers ', 'http://php.net/manual/en/language.types.integer.php', $project);
            $result[] = $intergerClass;
        }

        if(!$this->ClassExist('float ', $project)) {
            $floatClass = $this->GenerateClass('float ', 'http://php.net/manual/en/language.types.float.php', $project);
            $result[] = $floatClass;
        }

        if(!$this->ClassExist('string ', $project)) {
            $stringClass = $this->GenerateClass('string ', 'http://php.net/manual/en/language.types.string.php', $project);
            $result[] = $stringClass;
        }

        if(!$this->ClassExist('array ', $project)) {
            $arrayClass = $this->GenerateClass('array ', 'http://php.net/manual/en/language.types.array.php', $project);
            $result[] = $arrayClass;
        }

        if(!$this->ClassExist('object ', $project)) {
            $objectClass = $this->GenerateClass('object ', 'http://php.net/manual/en/language.types.object.php', $project);
            $result[] = $objectClass;
        }

        if(!$this->ClassExist('mixed ', $project)) {
            $mixedClass = $this->GenerateClass('mixed ', 'http://php.net/manual/en/language.pseudo-types.php#language.types.mixed', $project);
            $result[] = $mixedClass;
        }

        return $result;
    }

    private function ClassExist($className, $project)
    {
        return $this->Models->ProjectClass->Any(array('ProjectId' => $project->Id, 'ClassName' => $className));
    }

    private function GenerateClass($className, $source, $project)
    {
        $result = $this->Models->ProjectClass->Create();
        $result->ProjectId = $project->Id;
        $result->ClassName = $className;
        $result->IsPrimitive = 1;
        $result->ExternalSource = $source;

        $result->Save();
        return $result;
    }
}