<?php
function ArrayKeyExistsCaseInsensitive($needle, $haystack)
{
    foreach(array_keys($haystack) as $key){
        if(strtolower(($key) == strtolower($needle))){
            return true;
        }
    }

    return false;
}