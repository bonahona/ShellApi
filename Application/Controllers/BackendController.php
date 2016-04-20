<?php
abstract class BackendController extends Controller
{
    public function BeforeAction()
    {
        if(!$this->IsLoggedIn()){
            $this->Redirect('/Admin/', array('ref' => $this->RequestUri));
        }

        $this->Set('Sidebar', $this->GenerateSidebarData());
    }

    public function GenerateSidebarData()
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
}