<?php
class BaseController extends Controller
{
    public function BeforeAction()
    {
        $this->SetLinks();
    }

    protected function SetLinks()
    {
        $this->Set('ApplicationLinks', $this->Helpers->ShellAuth->GetApplicationLinks()['data']);
    }
}