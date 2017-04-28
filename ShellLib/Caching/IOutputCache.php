<?php
interface IOutputCache
{
    public function CacheOutput($request, $expires, $data);
    public function IsCached($request);
    public function GetCache($request);
    public function Invalidate($request);
}