<?php namespace framework\kernel\controllers;

use framework\kernel\abstractions\controllers\ProtectedController as Blueprint;
use framework\kernel\exceptions\KernelHandler as Handler;
use framework\kernel\jobs\traits\checker\ControllerChecker;
use framework\kernel\jobs\traits\checker\UserFuncChecker;

/*
* Class to control 'Protected Rule' data.
*/
class ProtectedController extends Blueprint
{
    // Using global paths, namespaces, some checker functions/methods.
    use \glob\paths, \glob\namespaces, ControllerChecker, UserFuncChecker;

    // The following variables have access in this class only.
    private $message, $config, $protected, $names, $target;

    function __construct()
    {
        // Prepared variables
        $this->config = require $this->getPaths()['config'] . '/protected.php';
        $this->protected = $this->config['protected_rule'];
        $this->names = array_keys($this->protected);
    }

    /**
    * This function/method usage is to initialize 'Protected Rule' data.
    *
    * @param    string   $name
    * @param    bool     $check
    * @return   mixed
    */
    protected function init($name, $check = FALSE)
    {
        if(!$check)
        {
            if(is_array($this->target))
            {
                if(isset($this->target['controller']) AND isset($this->target['method']))
                {
                    // on_false. Die program and redirect to Controller.
                    $this->checkController($this->getPaths()['controller'], $this->target['controller'],
                        $this->getNamespaces()['controller']);
                    $this->checkUserFunc($this->object, $this->target['method'],
                        $this->target['controller']);
                    call_user_func([$this->object, $this->target['method']]);
                    die;
                }
                elseif(isset($this->target['view']))
                {
                    // on_false. Die program and redirect to view.
                    $view = new \framework\kernel\controllers\ViewController;

                    $view->handler($this->target['view'], []);
                    die;
                }

                Throw new Handler(\framework\parents\Message::protectedUnknownTarget($name, 'Array'));
            }
            elseif(is_string($this->target))
            {
                // on_false. Die program and redirect to specified url.
                header('Location: ' . $this->target);
                die;
            }

            Throw new Handler(\framework\parents\Message::protectedUnknownTarget($name, $this->target));
        }

        return FALSE;
    }

    /**
    * This function/method usage is to handle 'Protected Rule' system.
    *
    * @param    string   $name
    * @param    bool     $check
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    public function handler($name, $check = FALSE)
    {
        try
        {
            if(!in_array($name, $this->names) AND !$check)
            {
                Throw new Handler(\framework\parents\Message::protectedDoesntExist($name));
            }

            $this->target = !$check ? $this->protected[$name]['on_false'] : $check;

            isset($_SESSION[md5(base64_encode('_dateAndTime'))]) ? ($indexPrefix =
                $_SESSION[md5(base64_encode('_dateAndTime'))]) : (isset($_COOKIE[
                md5(base64_encode('_dateAndTime'))]) ? ($indexPrefix =
                $_COOKIE[md5(base64_encode('_dateAndTime'))]) : ($indexPrefix = md5(
                base64_encode(date('Y-m-d' . ' __@__ ' . date('H:i:s'))))));

            return (!isset($_SESSION[md5($indexPrefix . md5(base64_encode($name)))])
                AND !isset($_COOKIE[md5($indexPrefix . md5(base64_encode($name)))]))
                ? $this->init($name, $check) : TRUE;
        }
        catch(Handler $e)
        {
            // Die program on unwanted condition.
            die($e->err());
        }
    }

}
