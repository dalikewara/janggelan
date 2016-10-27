<?php namespace framework\kernel\abstractions\controllers;

/*
* The blueprint of 'DBProperty' controller.
*/
abstract class DBPropertyController
{
    /**
    * @return   object
    */
    abstract public function connect();

    /**
    * @param    string   $selector
    * @return   string
    */
    abstract protected function db($selector);
}
