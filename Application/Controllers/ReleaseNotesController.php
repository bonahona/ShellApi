<?php
require_once('BackendController.php');
class ReleaseNotesController extends BackendController
{
    public function Create($projectId)
    {
        $this->Title = 'Create release notes';

        $project = $this->Models->Project->Find($projectId);
        if($project == null){
            return $this->HttpNotFound();
        }

        if($this->IsPost() && !$this->Data->IsEmpty()){
            $releaseNotes = $this->Data->Parse('ReleaseNotes', $this->Models->ReleaseNotes);
            $releaseNotes->Save();

            return $this->Redirect('/Projects/Details/' . $project->ProjectName);
        }else{
            $releaseNotes = $this->Models->ReleaseNotes->Create(array('ProjectId' => $projectId));
            $this->Set('ReleaseNotes', $releaseNotes);
            return $this->View();
        }
    }

    public function Edit($id)
    {
        $this->Title = 'Edit release notes';

        $releaseNotes = $this->Models->ReleaseNotes->Find($id);
        if($releaseNotes == null){
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
            $releaseNotes = $this->Data->DbParse('ReleaseNotes', $this->Models->ReleaseNotes);
            $releaseNotes->Save();

            return $this->Redirect('/Projects/Details/' . $releaseNotes->Project->ProjectName);
        }else{
            $this->Set('ReleaseNotes', $releaseNotes);

            return $this->View();
        }
    }
}