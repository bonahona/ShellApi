<?php
class Parameter extends Model
{
    public $TableName = 'parameter';

    public function GetLink()
    {
        if ($this->Type->IsPrimitive) {
            if ($this->Type->ExternalSource == '') {
                return $this->Type->ClassName . " " . $this->ParameterName;
            } else {
                return '<a target="_blank" href="' . $this->ExternalSource . '">';
            }
        } else {
            $link = '/Projects/Details/' . $this->Type->Project->ProjectName . '/Classes/' . $this->Type->ClassName;
            $display = $this->Type->ClassName . " " . $this->ParameterName;

            return '<a href="' . $link . '">' . $display . '</a>';
        }
    }
}