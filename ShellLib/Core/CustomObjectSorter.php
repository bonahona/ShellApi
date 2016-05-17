<?php
class CustomObjectSorter
{
    private $SortByField;

    public function Compare($a, $b)
    {
        $fieldName = $this->SortByField;
        $aValue = $a->$fieldName;
        $bValue = $b->$fieldName;

        if($aValue == $bValue){
            return 0;
        }

        if($aValue < $bValue){
            return -1;
        }else{
            return 1;
        }
    }

    public function SortCollection(&$array, $field)
    {
        $tmpArray = $array;
        $this->SortByField = $field;
        usort($tmpArray, array($this, 'Compare'));

        $result = new Collection();
        $result->Copy($tmpArray);
        return $result;
    }
}