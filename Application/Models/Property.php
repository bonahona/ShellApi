<?php
class Property extends Model
{
    public $TableName = 'property';

    public function GetLink()
    {
        return '/Projects/Details/' . $this->ProjectClass->Project->ProjectName . '/Classes/' . $this->ProjectClass->ClassName . '/Properties/' . $this->PropertyName;
    }
	
	public function GetLinkText()
    {
        return '/Projects/Details/' . $this->ProjectClass->Project->ProjectName . '/Classes/' . $this->ProjectClass->ClassName . '/Properties/' . $this->PropertyName;
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