<?php namespace framework\kernel\abstractions\parents;

/*
* The blueprint of parent 'Message'.
*/
abstract class Message
{
    /**
    * @return   string
    */
    abstract public static function undefinedRouteData();

    /**
    * @return   string
    */
    abstract public static function invalidRouteFormat();

    /**
    * @param    string   $uri
    * @return   string
    */
    abstract public static function uriIsNotRegistered($uri);

    /**
    * @param    string   $uri
    * @return   string
    */
    abstract public static function methodIsNotAllowed($uri);

    /**
    * @param    string   $name
    * @return   string
    */
    abstract public static function controllerDoesntExist($name);

    /**
    * @param    string   $name
    * @param    string   $namespace
    * @return   string
    */
    abstract public static function wrongController($name, $namespace);

    /**
    * @param    string   $method
    * @param    string   $controller
    * @return   string
    */
    abstract public static function userFuncDoesntExist($method, $controller);

    /**
    * @param    string   $name
    * @return   string
    */
    abstract public static function viewDoesntExists($name);

    /**
    * @param    string   $name
    * @return   string
    */
    abstract public static function protectedDoesntExist($name);

    /**
    * @param    string   $name
    * @param    string   $target
    * @return   string
    */
    abstract public static function protectedUnknownTarget($name, $target);

    /**
    * @param    string   $param
    * @return   string
    */
    abstract public static function undefinedProperty($param);

    /**
    * @param    string   $param
    * @return   string
    */
    abstract public static function cantSetUndeclaredProperty($param);
}
