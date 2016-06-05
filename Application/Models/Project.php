<?php
class Project extends Model
{
    public $TableName = "project";

    public function GetLink()
    {
        return '/Projects/Details/' . $this->ProjectName;
    }

    public function GetLinkText()
    {
        return '/Projects/Details/' . $this->ProjectName;
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