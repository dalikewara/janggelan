<?php namespace provider;

use phpFastCache\CacheManager;

class PhpFastCache
{
    public function whole($callback)
    {
        $cache = CacheManager::Memcached();
        $keyword_webpage = md5($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
        $resultsItem = $cache->getItem($keyword_webpage);

        if(!$resultsItem->isHit()) {
            ob_start();
            is_callable($callback) ? $callback() : $callback;

            $html = ob_get_contents();

            $resultsItem->set($html)->expireAfter(1800);
            $cache->save($resultsItem);
        }

        // echo $resultsItem->get();
    }
}
