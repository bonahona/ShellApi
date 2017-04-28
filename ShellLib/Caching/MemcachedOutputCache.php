<?php
class MemcachedOutputCache implements IOutputCache
{
    public $OutputCacheConfig;
    public $CacheServer = null;
    public $CacheServerConnected = false;

    public function __construct($config)
    {
        $this->OutputCacheConfig = $config;

        $serverHost = $config['ServerHost'];
        $serverPort = $config['ServerPort'];

        if(class_exists('Memcache')){
            $this->CacheServer = new Memcache;
            @$this->CacheServerConnected = $this->CacheServer->connect($serverHost, $serverPort);
        }else if(class_exists('Memcached')){
            $this->CacheServer = new Memcached;
            @$this->CacheServerConnected = $this->CacheServer->addServer($serverHost, $serverPort);
        }
    }

    public function CacheOutput($request, $expires, $data)
    {

    }

    public function IsCached($request)
    {
        if($request['MethodName'] != 'GET'){
            return false;
        }

        $keyName = $this->GetKeyName($request);
        if($this->CacheServer->append($keyName, NULL)){
            return true;
        }

        return false;
    }

    public function GetCache($request)
    {
    }

    public function Invalidate($request)
    {

    }

    protected function GetKeyName($request)
    {
        $data = array(
            'controller=' . $request['ControllerName'],
            'action=' . $request['ActionName'],
            'variables=' . implode(',', $request['Variables'])
        );

        $result = implode(';', $data);
        return $result;
    }
}