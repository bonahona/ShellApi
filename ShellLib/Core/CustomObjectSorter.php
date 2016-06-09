<?php
define('Ascending', 1);
define('Descending', 2);

class CustomObjectSorter
{
    private $SortByField;

    public function CompareAscending($a, $b)
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

    public function CompareDescending($a, $b)
    {
        $fieldName = $this->SortByField;
        $aValue = $a->$fieldName;
        $bValue = $b->$fieldName;

        if($aValue == $bValue){
            return 0;
        }

        if($aValue < $bValue){
            return 1;
        }else{
            return -1;
        }
    }

    public function SortCollection(&$array, $field, $sortOrder = Ascending)
    {
        $tmpArray = $array;
        $this->SortByField = $field;

        if($sortOrder == Ascending) {
            usort($tmpArray, array($this, 'CompareAscending'));
        }else{
            usort($tmpArray, array($this, 'CompareDescending'));
        }

        $result = new Collection();
        $result->Copy($tmpArray);
        return $result;
    }
}