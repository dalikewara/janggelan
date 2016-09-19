<?php namespace system\dragon_fire\controllers;

use system\dragon_fire\exceptions\DragonHandler;

class CacheController
{
    use \register\paths;

    private $properties, $list, $servers;

    public function __construct()
    {
        $this->properties = require($this->getPath()['config'].'/cache.php');
        $this->list = array_keys($this->properties);
        $this->servers = array();
    }

    public function getObject($index)
    {
        $object = function($cache)
        {
            $cacheObj = '\\'.$cache;

            return new $cacheObj;
        };

        return in_array($index, $this->list) ? $object($index) : die('Unknown cache driver!');
    }

    public function connectCache($object, $cache)
    {
        $this->servers = array_values($this->properties[$cache]);

        switch($cache)
        {
            case 'Memcached' || 'Memcache':
                $object->addServers($this->servers);
                break;
            default:
                return FALSE;
                break;
        }
    }

    public function setCache(array $products, $object, $type, $cache)
    {
        switch($cache)
        {
            case 'Memcached' || 'Memcache':
                $key = implode('', array_keys($products));
                $product = implode('', array_values($products));

                return ($type === 'default') ? $object->set($key, $product)
                    : $object->setMulti($products);
                break;
            default:
                return FALSE;
                break;
        }
    }

    public function getCache(array $keys, $object, $type, $cache)
    {
        switch($cache)
        {
            case 'Memcached' || 'Memcache':
                return ($type === 'default') ? $object->get(implode('', $keys))
                    : $object->getMulti($keys);
                break;
            default:
                return FALSE;
                break;
        }
    }
}
