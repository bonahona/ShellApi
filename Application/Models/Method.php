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
}