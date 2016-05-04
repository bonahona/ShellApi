<?php
class Method extends Model
{
    public $TableName = 'method';

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