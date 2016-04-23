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
}