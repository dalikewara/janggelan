<?php namespace framework\parents;

use framework\kernel\abstractions\parents\Message as Blueprint;

/*
* Class to handle notice or error messages.
*/
class Message extends Blueprint
{
    /**
    * @return   string
    */
    public static function undefinedRouteData()
    {
        return 'Undefined data type of routes!';
    }

    /**
    * @return   string
    */
    public static function invalidRouteFormat()
    {
        return 'Invalid route format parameter!';
    }

    /**
    * @param    string   $uri
    * @return   string
    */
    public static function uriIsNotRegistered($uri)
    {
        return 'Request failed, uri <b>\'' . $uri . '\'</b> is not registered!';
    }

    /**
    * @param    string   $uri
    * @return   string
    */
    public static function methodIsNotAllowed($uri)
    {
        return '\'Method Request\' for uri <b>\'' . $uri . '\'</b> is not allowed!';
    }

    /**
    * @param    string   $name
    * @return   string
    */
    public static function controllerDoesntExist($name)
    {
        return 'Controller <b>\'' . $name . '\'</b> doesn\'t exist!';
    }

    /**
    * @param    string   $name
    * @param    string   $namespace
    * @return   string
    */
    public static function wrongController($name, $namespace)
    {
        return 'Namespace or class <b>\'' . $namespace . '\\' . $name . '\'</b> was not found!';
    }

    /**
    * @param    string   $method
    * @param    string   $controller
    * @return   string
    */
    public static function userFuncDoesntExist($method, $controller)
    {
        return 'User function <b>\'' . $method . '\'</b> was not found in controller
            <b>\'' . $controller . '\'</b>!';
    }

    /**
    * @param    string   $name
    * @return   string
    */
    public static function viewDoesntExists($name)
    {
        return 'View with name <b>\'' . $name . '\'</b> doesn\'t exist!';
    }

    /**
    * @param    string   $name
    * @return   string
    */
    public static function protectedDoesntExist($name)
    {
        return 'Protected Rule with name <b>\'' . $name . '\'</b> doesn\'t exist!';
    }

    /**
    * @param    string   $name
    * @param    string   $target
    * @return   string
    */
    public static function protectedUnknownTarget($name, $target)
    {
        return 'Unknown target <b>\'' . $target . '\'</b> on Protected Rule <b>\'' . $name . '\'</b>!';
    }

    /**
    * @param    string   $param
    * @return   string
    */
    public static function undefinedProperty($param)
    {
        return 'Undefined property <b>\'' . $param . '\'</b>!';
    }

    /**
    * @param    string   $param
    * @return   string
    */
    public static function cantSetUndeclaredProperty($param)
    {
        return 'Can\'t set property to <b>\'' . $param . '\'</b> while it was not declared!';
    }
}
