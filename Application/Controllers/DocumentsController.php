<?php
require_once('BackendController.php');
class DocumentsController extends BackendController
{
    private function StringEquals($a, $b)
    {
        return (strcasecmp($a, $b) == 0);
    }

    public function Create($type = null, $id = null)
    {
        $this->Title = 'Create Document';

        if(empty($type) || empty($id)){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $document = $this->Data->Parse('Document', $this->Models->Document);
            $document->Save();

            if($this->StringEquals($type, 'Project')){
                $project = $this->Models->Project->Find($id);
                return $this->Redirect("/Projects/Details/$project->ProjectName");
            }else if($this->StringEquals($type, 'Class')){
                $projectClass = $this->Models->ProjectClass->Find($id);
                return $this->Redirect('/Projects/Details/' . $projectClass->Project->ProjectName . '/Classes/' . $projectClass->ClassName);
            }else if($this->StringEquals($type, 'Method')){
                $method = $this->Models->Method->Find($id);
                return $this->Redirect('/Projects/Details/' . $method->ProjectClass->Project->ProjectName . '/Classes/' . $method->ProjectClass->ClassName . '/Methods/' . $method->MethodName . $method->CreateLink());
            }else if($this->StringEquals($type, 'Property')){
                $property = $this->Models->Property->Find($id);
                return $this->Redirect('/Projects/Details/' . $property->ProjectClass->Project->ProjectName . '/Classes/' . $property->ProjectClass->ClassName . '/Properties/' . $property->PropertyName);
            }else{
                return $this->Redirect('/Documents/');
            }

        }else{
            $document = $this->Models->Document->Create();

            if($this->StringEquals($type, 'Project')){
                $document->ProjectId = $id;
            } else if($this->StringEquals($type, 'Class')){
                $document->ClassId = $id;
            }else if($this->StringEquals($type, 'Method')){
                $document->MethodId = $id;
            }else if($this->StringEquals('Property', 'Property')){
                $document->PropertyId = $id;
            }

            $this->Set('Document', $document);

            return $this->View();
        }
    }

    public function Content($id)
    {
        $this->Title = 'Edit Document Content';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $document = $this->Models->Document->Find($id);
        if($document == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()) {
            $document = $this->Data->DbParse('Document', $this->Models->Document);
            $document->Save();

            if($document->ProjectId > 0){
                $project = $this->Models->Project->Find($document->ProjectId);
                return $this->Redirect("/Projects/Details/$project->ProjectName");
            }else{
                return  $this->Redirect('/Documents/');
            }

        }else{
            $this->Set('Document', $document);
            return $this->View();
        }
    }

    public function Edit($id)
    {
        $this->Title = 'Edit Document';

        if(empty($id)){
            return $this->HttpNotFound();
        }

        $document = $this->Models->Document->Find($id);
        if($document == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()) {
            $document = $this->Data->DbParse('Document', $this->Models->Document);
            $document->Save();

            if($document->ProjectId > 0){
                $project = $this->Models->Project->Find($document->ProjectId);
                return $this->Redirect("/Projects/Details/$project->ProjectName");
            }else{
                return  $this->Redirect('/Documents/');
            }
        }else{
            $this->Set('Document', $document);
            return $this->View();
        }
    }

    public function DeleteConfirm($id)
    {
        $this->Title = 'Confirm delete document';

        $document = $this->Models->Document->Find($id);
        if($document == null){
            return $this->HttpNotFound();
        }

        $project = $this->Models->Project->Find($document->ProjectId);

        if($this->IsPost()){
            $document->Delete();

            return $this->Redirect('/Projects/Details/' . $project->ProjectName);
        }else {
            $this->Set('Project', $project);
            $this->Set('Document', $document);
            return $this->View();
        }
    }
}