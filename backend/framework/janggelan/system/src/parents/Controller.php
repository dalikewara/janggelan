<?php namespace framework\parents;

use framework\kernel\jobs\traits\support\ProtectedRule;
use framework\kernel\jobs\traits\support\LoadView;
use framework\kernel\jobs\traits\support\Cache;

/*
 * Class for base Controller that already included some tasks.
*/
class Controller
{
    use ProtectedRule, LoadView, Cache;

    function __construct()
    {
        //
    }

    /**
    * Every controller classes that extend this Base Controller cannot call
    * undefined property.
    *
    * @param    string   $param
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    function __get($param)
    {
        try
        {
            Throw new \framework\kernel\exceptions\KernelHandler(
                \framework\parents\Message::undefinedProperty($param));
        }
        catch(\framework\kernel\exceptions\KernelHandler $e)
        {
            die($e->err());
        }
    }

    /**
    * Every controller classes that extend this Base Controller cannot set
    * value to undeclared property.
    *
    * @param    string   $param
    * @param    string   $value
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    function __set($param, $value)
    {
        try
        {
            Throw new \framework\kernel\exceptions\KernelHandler(
                \framework\parents\Message::cantSetUndeclaredProperty($param));
        }
        catch(\framework\kernel\exceptions\KernelHandler $e)
        {
            die($e->err());
        }
    }
}
