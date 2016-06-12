<?php
require_once('BackendController.php');
class ExamplesController extends BackendController
{
    public function Create($type, $id)
    {
        $this->Title = 'Create example';

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $example = $this->Data->Parse('Example', $this->Models->Example);
            $example->Save();

            if($example->ProjectId !== ''){
                $project = $this->Models->Project->Find($example->ProjectId);
                return $this->Redirect('/Projects/Details/' . $project->ProjectName);
            }else if($example->ClassId !== ''){
                $projectClass = $this->Models->ProjectClass->Find($example->ClassId);
                return $this->Redirect('/Projects/Details/' . $projectClass->Project->ProjectName . '/Classes/' . $projectClass->ClassName);
            }else if($example->MethodId !== ''){
                $method = $this->Models->Method->Find($example->MethodId);
                return $this->Redirect('/Projects/Details/' . $method->ProjectClass->Project->ProjectName . '/Classes/' . $method->ProjectClass->ClassName . '/Methods/' . $method->MethodName);
            }else if($example->PropertyId !== '') {
                $property = $this->Models->Property->Find($example->MethodId);
                return $this->Redirect('/Projects/Details/' . $property->ProjectClass->Project->ProjectName . '/Classes/' . $property->ProjectClass->ClassName . '/Properties/' . $property->PropertyName);
            }
        }else{
            $example = $this->Models->Example->Create();

            if($type == 'Project'){
                $example->ProjectId = $id;
                $project = $this->Models->Project->Find($id);
                $example->ProjectLanguageId = $project->ProjectLanguage->Id;
            }else if($type == 'ProjectClass'){
                $example->ClassId = $id;
                $projectClass = $this->Models->ProjectClass->Find($id);
                $example->ProjectLanguageId = $projectClass->Project->ProjectLanguage->Id;
            }else if($type == 'Method'){
                $example->MethodId = $id;
                $method = $this->Models->Method->Find($id);
                $example->ProjectLanguageId = $method->ProjectClass->Project->ProjectLanguage->Id;
            } else if($type == 'Property'){
                $example->PropertId = $id;
                $property = $this->Models->Property->Find($id);
                $example->ProjectLanguageId = $property->ProjectClass->Project->ProjectLanguage->Id;
            }else{
                return $this->HttpNotFound();
            }

            $this->Set('SortOrderList', $this->GenerateSortOrderList());

            $projectLanguages = $this->Models->ProjectLanguage->Where(array('IsActive' => 1));
            $this->Set('ProjectLanguages', $projectLanguages);

            $this->Set('Example', $example);
            return $this->View();
        }
    }

    public function Edit($id)
    {
        $this->Title = 'Edit Example';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $example = $this->Models->Example->Find($id);
        if($example == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $example = $this->Data->DbParse('Example', $this->Models->Example);
            $example->Save();

            if($example->ProjectId !== ''){
                $project = $this->Models->Project->Find($example->ProjectId);
                return $this->Redirect('/Projects/Details/' . $project->ProjectName);
            }else if($example->ClassId !== ''){
                $projectClass = $this->Models->ProjectClass->Find($example->ClassId);
                return $this->Redirect('/Projects/Details/' . $projectClass->Project->ProjectName . '/Classes/' . $projectClass->ClassName);
            }else if($example->MethodId !== ''){
                $method = $this->Models->Method->Find($example->MethodId);
                return $this->Redirect('/Projects/Details/' . $method->ProjectClass->Project->ProjectName . '/Classes/' . $method->ProjectClass->ClassName . '/Methods/' . $method->MethodName);
            }else if($example->PropertyId !== '') {
                $property = $this->Models->Property->Find($example->MethodId);
                return $this->Redirect('/Projects/Details/' . $property->ProjectClass->Project->ProjectName . '/Classes/' . $property->ProjectClass->ClassName . '/Properties/' . $property->PropertyName);
            }
        }else{
            $this->Set('SortOrderList', $this->GenerateSortOrderList());

            $projectLanguages = $this->Models->ProjectLanguage->Where(array('IsActive' => 1));
            $this->Set('ProjectLanguages', $projectLanguages);

            $this->Set('Example', $example);
            return $this->View();
        }
    }

    public function Content($id)
    {
        $this->Title = 'Edit Example Content';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $example = $this->Models->Example->Find($id);
        if($example == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $example = $this->Data->DbParse('Example', $this->Models->Example);
            $example->Save();

            return $this->Redirect($this->GetReturnLink($example));
        }else{
            $this->Set('Example', $example);
            return $this->View();
        }
    }

    public function Delete($id)
    {
        if(empty($id)){
            return $this->HttpNotFound();
        }

        $example = $this->Models->Example->Find($id);
        if($example == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $example->Delete();

            return $this->Redirect($this->GetReturnLink($example));
        }else{
            $this->Set('ReturnLink', $this->GetReturnLink($example));
            $this->Set('Example', $example);

            return $this->View();
        }
    }

    private function GetReturnLink($example)
    {
        if($example->ProjectId !== null){
            $project = $this->Models->Project->Find($example->ProjectId);
            return '/Projects/Details/' . $project->ProjectName;
        }else if($example->ClassId !== null){
            $projectClass = $this->Models->ProjectClass->Find($example->ClassId);
            return '/Projects/Details/' . $projectClass->Project->ProjectName . '/Classes/' . $projectClass->ClassName;
        }else if($example->MethodId !== null){
            $method = $this->Models->Method->Find($example->MethodId);
            return '/Projects/Details/' . $method->ProjectClass->Project->ProjectName . '/Classes/' . $method->ProjectClass->ClassName . '/Methods/' . $method->MethodName;
        }else if($example->PropertyId !== null) {
            $property = $this->Models->Property->Find($example->MethodId);
            return '/Projects/Details/' . $property->ProjectClass->Project->ProjectName . '/Classes/' . $property->ProjectClass->ClassName . '/Properties/' . $property->PropertyName;
        }
    }

    private function GenerateSortOrderList()
    {
        return array(
            0 => '0',
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
            7 => '7',
            8 => '8',
            9 => '9',
        );
    }
}