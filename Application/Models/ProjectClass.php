<?php
class ProjectClass extends Model
{
    public $TableName = 'projectclass';

    public function GetLink()
    {
        if($this->IsPrimitive){
            if($this->ExternalSource == ''){
                return $this->ClassName;
            }else{
                return '<a target="_blank" href="' . $this->ExternalSource . '">';
            }
        }else{
            $link = '/Projects/Details/' . $this->Project->ProjectName . '/Classes/' . $this->ClassName;
            $display = $this->ClassName;

            return '<a href="' . $link . '">' . $display . '</a>';
        }
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