<?php
require_once('BaseController.php');
abstract class BackendController extends BaseController
{
    public function BeforeAction()
    {
        parent::BeforeRender();

        if(!$this->IsLoggedIn()){
            $this->Redirect('/Admin/', array('ref' => $this->RequestUri));
        }

        $this->Set('Sidebar', $this->GenerateSidebarData());
    }

    protected function GenerateSidebarData()
    {
        $result = array();

        $result[0] = array(
            'Title' => 'Configurations',
            'Items' => array(
                array(
                    'Link' => '/ProjectLanguages/',
                    'DisplayName' => 'Project Languages'
                ),
                array(
                    'Link' => '/ProjectCategories/',
                    'DisplayName' => 'Project Categories'
                )
            )
        );

        return $result;
    }

    protected function GetAccessModifierList()
    {
        return array(
            1 => 'private',
            2 => 'protected',
            3 => 'public'
        );
    }
}