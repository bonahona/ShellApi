<?php
class ProjectClass extends Model
{
    public $TableName = 'projectclass';

    public function GetLink()
    {
        return '/Projects/Details/' . $this->Project->ProjectName . '/Classes/' . $this->ClassName;
    }

    public function GetSearchResultContext($maxLength = 300)
    {
        $descriptionLength = strlen($this->Description);

        if($descriptionLength <= $maxLength){
            return $this->Description;
        }else{
            return substr($this->Description, 0, $maxLength) . " ...";
        }
    }
}