<?php
class Method extends Model
{
    public $TableName = 'method';

    public function GetLink()
    {
        return '/Projects/Details/' . $this->ProjectClass->Project->ProjectName . '/Classes/' . $this->ProjectClass->ClassName . '/Methods/' . $this->MethodName . $this->CreateLink();
    }

    public function GetLinkText()
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
        if($this->Parameters != null) {
            foreach ($this->Parameters as $parameter) {
                $parameterType[] = $parameter->Type->ClassName;
            }
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

    public function GetHeaderText($project, $htmlHelper)
    {
        $result = htmlspecialchars($this->MethodName);

        if(count($this->GenericTypes) > 0) {
            $genericTypes = array();
            foreach ($this->GenericTypes->OrderBy('SortIndex') as $genericType) {
                $genericTypes[] = $genericType->TypeName;
            }

            $result .= htmlspecialchars('<' . implode(',', $genericTypes) . '>');
        }

        $parameters = array();
        foreach($this->Parameters as $parameter){

            if($parameter->Type->IsPrimitive){
                if ($parameter->Type->ExternalSource == null) {
                    if($parameter->IsExtension){
                        $parameters[] = 'this ' . $parameter->Type->ClassName . ' ' . $parameter->ParameterName;
                    }else {
                        $parameters[] = $parameter->Type->ClassName . ' ' . $parameter->ParameterName;
                    }
                } else {
                    $url = $parameter->Type->ExternalSource;
                    $parameters[] = $htmlHelper->Link($url, $parameter->Type->ClassName);
                }
            }else{
                $url = '/Projects/Details/' . $project->ProjectName . '/Classes/' . $this->ReturnType->ClassName;
                $parameters[] = $htmlHelper->Link($url, $parameter->Type->ClassName);
            }
        }

        return $result . '(' . implode(',', $parameters) . ')';
    }

    public function GetConstraints()
    {
        $result = array();

        foreach($this->GenericTypes->OrderBy('SortIndex') as $genericType){
            if($genericType->Constraint != ''){
                $result[] = htmlspecialchars('where ' . $genericType->TypeName . ': ' . $genericType->Constraint);
            }
        }

        return $result;
    }
}