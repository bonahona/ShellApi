<?php
function CreateArray($value, $count)
{
    $result = array();

    for($i = 0; $i < $count; $i++) {
        $result[] = $value;
    }

    return $result;
}

function RemoveEmpty($subject)
{
    $result = array();
    foreach($subject as $entry){
        if($entry != ''){
            $result[] = $entry;
        }
    }

    return $result;
}