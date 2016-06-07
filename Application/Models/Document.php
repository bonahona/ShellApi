<?php
class Document extends Model
{
    public $TableName = 'document';

    public function GetLink()
    {
        if($this->ProjectId != 0){
            $project = $this->Models->Project->Find($this->ProjectId);
            return '/Projects/Details/' . $project->ProjectName . '/Documents/' . $this->NavigationTitle;
        }else if($this->ClassId != 0){
            $projectClass = $this->Models->ProjectClass->Find($this->ClassId);
            return '/Projects/Details/' . $projectClass->Project->ProjectName . '/Classes/' . $projectClass->ClassName . '/Documents/' . $this->NavigationTitle;
        }else if($this->MethodId != 0){
            $method = $this->Models->Method->Find($this->MethodId);
            return '/Projects/Details/' . $method->ProjectClass->Project->ProjectName . '/Classes/' . $method->ProjectClass->ClassName . '/Methods/' . $method->MethodName . '/Documents/' . $this->NavigationTitle;
        }else if($this->PropertyId != 0){
            $property = $this->Models->Property->Find($this->PropertyId);
            return '/Projects/Details/' . $property->ProjectClass->Project->ProjectName . '/Classes/' . $property->ProjectClass->ClassName . '/Properties/' . $property->PropertyName . '/Documents/' . $this->NavigationTitle;
        }else{
            return '';
        }
    }
	
	public function GetLinkText()
    {
        if($this->ProjectId != 0){
            $project = $this->Models->Project->Find($this->ProjectId);
            return '/Projects/Details/' . $project->ProjectName . '/Documents/' . $this->NavigationTitle;
        }else if($this->ClassId != 0){
            $projectClass = $this->Models->ProjectClass->Find($this->ClassId);
            return '/Projects/Details/' . $projectClass->Project->ProjectName . '/Classes/' . $projectClass->ClassName . '/Documents/' . $this->NavigationTitle;
        }else if($this->MethodId != 0){
            $method = $this->Models->Method->Find($this->MethodId);
            return '/Projects/Details/' . $method->ProjectClass->Project->ProjectName . '/Classes/' . $method->ProjectClass->ClassName . '/Methods/' . $method->MethodName . '/Documents/' . $this->NavigationTitle;
        }else if($this->PropertyId != 0){
            $property = $this->Models->Property->Find($this->PropertyId);
            return '/Projects/Details/' . $property->ProjectClass->Project->ProjectName . '/Classes/' . $property->ProjectClass->ClassName . '/Properties/' . $property->PropertyName . '/Documents/' . $this->NavigationTitle;
        }else{
            return '';
        }
    }

    public function GetSearchResultContext($maxLength = 300)
    {
        $descriptionLength = strlen($this->Content);

        if($descriptionLength <= $maxLength){
            return $this->Content;
        }else{
            return substr($this->Content, 0, $maxLength) . " ...";
        }
    }
}