<?php namespace framework\kernel\abstractions\controllers;

/*
* The blueprint of parent 'Request'.
*/
abstract class ProtectedController
{
    /**
    * @param    string   $name
    * @param    bool     $check
    * @return   mixed
    */
    abstract protected function init($name, $check = FALSE);

    /**
    * @param    string   $name
    * @param    bool     $check
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    abstract public function handler($name, $check = FALSE);
}
