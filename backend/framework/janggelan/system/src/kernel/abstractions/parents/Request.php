<?php namespace framework\kernel\abstractions\parents;

/*
* The blueprint of parent 'Request'.
*/
abstract class Request
{
    /**
    * @return   mixed
    */
    abstract protected function get();

    /**
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    abstract public function init();

    /**
    * @param    string                 $route
    * @param    function|bool(false)   $callback
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    abstract protected function request($route, $callback = FALSE);

    /**
    * @param    string   $route
    * @param    array    $routes
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    abstract protected function group($route, array $routes);
}
