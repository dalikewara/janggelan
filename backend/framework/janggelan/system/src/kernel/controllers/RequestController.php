<?php namespace framework\kernel\controllers;

use framework\kernel\abstractions\controllers\RequestController as Blueprint;
use framework\kernel\exceptions\KernelHandler as Handler;
use framework\kernel\jobs\traits\checker\ControllerChecker;
use framework\kernel\jobs\traits\checker\UserFuncChecker;

class RequestController extends Blueprint
{
    // Using global paths and namespaces.
    use \glob\paths, \glob\namespaces, ControllerChecker, UserFuncChecker;

    // The following variable has access in this class only.
    private $data;

    function __construct()
    {
        $this->data = null;
    }

    function __set($param, $value)
    {
        $this->$param = $value;
    }

    /**
    * Initialize routes data and generate into it View or Controller.
    * This method also checking for 'protected_rule' process.
    *
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    protected function init()
    {
        try
        {
            if(isset($this->data->protected))
            {
                // Checking for protected_rule.
                $protected = new \framework\kernel\controllers\ProtectedController;

                $protected->handler($this->data->protected);
            }

            if(isset($this->data->view))
            {
                // Getting the view.
                $view = new \framework\kernel\controllers\ViewController;

                $view->handler($this->data->view, []);
            }
            else
            {
                // Checking for controller.
                $this->checkController($this->getPaths()['controller'], $this->data->controller,
                    $this->getNamespaces()['controller']);
                // Checking for user function.
                $this->checkUserFunc($this->object, $this->data->user_func, $this->data->controller);

                if(!empty($this->data->arguments))
                {
                    return call_user_func_array([$this->object, $this->data->user_func],
                        $this->data->arguments);
                }
                else
                {
                    return $this->object->{$this->data->user_func}([]);
                }
            }
        }
        catch(Handler $e)
        {
            // Die program on unwanted condition.
            die($e->err());
        }
    }

    /**
    * Handle for final request data.
    *
    * @var      object(stdClass)       $this->data
    * @param    array                  $data
    * @return   mixed
    */
    public function handler(array $data)
    {
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
        // Uri is the first thing to check. After it was returned as a valid
        // registered uri, the result(primary data) is set into $this->data variable.
        $this->data = $this->uriChecker($uri, $_SERVER['REQUEST_METHOD'], $data);

        // Check if request contains Closure or Callback.
        // If it true, do not return and call init, but set new property of $this->callback
        // because we need to execute that Closure or Callback directly for user.
        // This property '$this->callback' is required by Parent 'Request'.
        if(isset($this->data->callback) AND $this->data->callback === 1)
        {
            if(isset($this->data->protected))
            {
                // Checking for protected_rule.
                $protected = new \framework\kernel\controllers\ProtectedController;

                $protected->handler($this->data->protected);
            }
            
            $this->callback = $this->data->uri;
        }
        else
        {
            // Final request proceed.
            return $this->init();
        }
    }

    /**
    * Handle for uri and method checker.
    *
    * @param    string                 $uri
    * @param    string                 $method
    * @param    array                  $data
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   stdClass
    */
    protected function uriChecker($uri, $method, array $data)
    {
        // Prepared variables.
        $result = [];

        // Filter and sanitize the uri.
        // If it have '/'  at the end of uri string, the '/' will be removed
        // to avoid some problems.
        if($uri != '/')
        {
            $uri = filter_var(rtrim($uri, '/'), FILTER_SANITIZE_URL);
        }

        // Looping data to find a valid uri.
        foreach($data as $val)
        {
            // If the registered uri has arguments.
            if(preg_match('/[{][a-zA-Z0-9]*[}]/', $val->uri))
            {
                // Prepared variables for getting arguments.
                $val->uri = explode('/', rtrim(ltrim($val->uri, '/'), '/'));
                $uris = explode('/', ltrim($uri, '/'));

                // Getting arguments from registered uri.
                $arguments = array_filter($val->uri, function($e)
                {
                    if(preg_match('/[{][a-zA-Z0-9]*[}]/', $e))
                    {
                        return $e;
                    }
                });

                // Generating new $val->uri with arguments.
                $val->arguments = array_replace($arguments, array_diff_key($uris,
                    array_diff_key($uris, $arguments)));
                $val->uri = str_replace($arguments, $val->arguments, '/' . implode('/', $val->uri));
            }

            if($uri === $val->uri)
            {
                // If the uri is valid but the method is not, throw it to Exception.
                if($method !== $val->method)
                {
                    Throw new Handler(\framework\parents\Message::methodIsNotAllowed($uri));
                }

                // If the valid uri and method was found, return the data directly.
                return $val;
            }
        }

        // If the uri is not valid or is not registered, throw it to Execption.
        Throw new Handler(\framework\parents\Message::uriIsNotRegistered($uri));
    }
}
