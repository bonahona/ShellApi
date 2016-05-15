<?php
class Method extends Model
{
    public $TableName = 'method';

    public function GetLink()
    {
        return '/Projects/Details/' . $this->ProjectClass->Project->ProjectName . '/Classes/' . $this->ProjectClass->ClassName . '/Methods/' . $this->MethodName . $this->CreateLink();
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

    public function CreateLink()
    {
        $parameterType = array();
        foreach($this->Parameters as $parameter){
            $parameterType[] = $parameter->Type->ClassName;
        }

        $parameters = rawurlencode ('(' . implode( $parameterType, ',') . ')');
        return $parameters;
    }

    public function CreateParameterText()
    {
        $parameterTypes = array();
        foreach($this->Parameters as  $parameter){
            $parameterTypes[] = $parameter->Type->ClassName;
        }

        $result = '(' . implode($parameterTypes, ',') . ')';
        return  $result;
    }
}