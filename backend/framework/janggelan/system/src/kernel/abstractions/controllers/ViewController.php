<?php namespace framework\kernel\abstractions\controllers;

/*
* The blueprint of 'View' controller.
*/
abstract class ViewController
{
    /**
    * @param    string   $name
    * @param    array    $data
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    abstract public function handler($name, array $data);
}
