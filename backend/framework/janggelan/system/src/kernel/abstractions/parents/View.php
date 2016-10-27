<?php namespace framework\kernel\abstractions\parents;

/*
* The blueprint of parent 'View'.
*/
abstract class View
{
    /**
    * @param    string   $name
    * @param    array    $data
    * @return   mixed
    */
    abstract public static function init($name, array $data);
}
