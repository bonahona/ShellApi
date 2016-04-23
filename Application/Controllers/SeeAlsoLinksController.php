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
}