<?php
require_once('BackendController.php');
class SeeAlsoLinksController extends BackendController
{
    public function Create()
    {
        if($this->IsPost()){
            $seeAlsoLink = $this->Data->Parse('SeeAlsoLink', $this->Models->SeeAlsoLink);
            $seeAlsoLink->Save();
            return $this->Json($seeAlsoLink->Object());
        }
    }

    public function Delete($id)
    {
        if(empty($id)){
            $this->HttpNotFound();
        }

        if($this->IsPost()){
            $seeAlsoLink = $this->Models->SeeAlsoLink->Find($id);
            if($seeAlsoLink == null){
                return $this->HttpNotFound();
            }

            $seeAlsoLink->Delete();
        }

        return $this->Json(array());
    }
}