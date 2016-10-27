<?php namespace framework\kernel\abstractions\controllers;

/*
* The blueprint of 'Request' controller.
*/
abstract class RequestController
{
    /**
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    abstract protected function init();

    /**
    * @var      object(stdClass)       $this->data
    * @param    array                  $data
    * @return   mixed
    */
    abstract public function handler(array $data);

    /**
    * @param    string                 $uri
    * @param    string                 $method
    * @param    array                  $data
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   stdClass
    */
    abstract protected function uriChecker($uri, $method, array $data);

    /**
    * @param    string   $path
    * @param    string   $name
    * @param    string   $namespace
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    abstract protected function checkController($path, $name, $namespace);

    /**
    * @param    object   $object
    * @param    string   $method
    * @param    string   $class
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    abstract protected function checkUserFunc($object, $method, $class);
}
