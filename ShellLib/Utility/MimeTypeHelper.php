<?php

function GetMimeTypeFromFile($filePath)
{
    $fileInfo = pathinfo($filePath);

    $fileEnding = $fileInfo[PATHINFO_EXTENSION];

    $mimeTypes = array(
        '.js' => 'application/javascript',
        '.cs' => 'text/css',
        '.jpg' => 'image/jpge',
        '.jpeg' => 'image/jpeg',
        '.png' => 'image/png',
        '.icon' => 'image/x-icon',
        '.eot' => 'application/vnd.ms-fontobject',
        '.svg' => 'image/svg+xml',
        '.ttf' => 'application/x-font-ttf',
        '.woff' => 'application/x-font-woff',
        '.woff2' => 'application/x-font-woff',
    );

    return $mimeTypes[$fileEnding];
}