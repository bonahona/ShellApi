<?php
class GenericType extends Model
{
    public $TableName = 'generictype';

    public function HasLink()
    {
        return false;
    }

    public function GetName()
    {
        return $this->TypeName;
    }
}