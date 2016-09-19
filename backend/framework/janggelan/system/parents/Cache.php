<?php namespace system\parents;

class Cache
{
    private $controller, $object, $cache;

    public function __construct($cache)
    {
        $this->cache = $cache;
        $this->controller = new \system\dragon_fire\controllers\CacheController;
        $this->object = $this->controller->getObject($this->cache);
    }

    public function connect()
    {
        return $this->controller->connectCache($this->object, $this->cache);
    }

    public function set(array $products)
    {
        $type = (count($products) > 1) ? 'multi' : 'default';

        return $this->controller->setCache($products, $this->object, $type, $this->cache);
    }

    public function get(array $keys)
    {
        $type = (count($keys) > 1) ? 'multi' : 'default';

        return $this->controller->getCache($keys, $this->object, $type, $this->cache);
    }
}
