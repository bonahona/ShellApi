<?php
function CreateArray($value, $count)
{
    $result = array();

    for($i = 0; $i < $count; $i++) {
        $result[] = $value;
    }

    return $result;
}