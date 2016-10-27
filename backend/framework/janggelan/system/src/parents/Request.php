<?php namespace framework\parents;

use framework\kernel\abstractions\parents\Request as Blueprint;
use framework\kernel\exceptions\KernelHandler as Handler;
use framework\kernel\controllers\RequestController as Controller;
use framework\parents\Message;

/*
* Class for base Request.
*/
class Request extends Blueprint
{
    // Using global paths.
    use \glob\paths;

    // Initialize callback data.
    private $callback = [];

    // The following variables have a public access.
    public $routes, $data, $cache, $cacheName, $cacheFile, $controller;

    function __construct()
    {
        // Prepared variables.
        $this->controller = new Controller;
        $this->routes = $this->data = [];
        $this->cacheName = str_replace(' ', '_', filemtime($this->getPaths()['worksheet']
            . '/requests.php'));
        $this->cache = require_once $this->getPaths()['config'] . '/request.php';
        $this->cache = $this->cache['cached_routes'];
        $this->cacheFile = __DIR__ . '/../storage/cache/uri/' . $this->cacheName . '.uri';

        // Every modified properties that get from filemtime() is cached by PHP as default.
        // This require to destroy the cache to get more accurate modified properties.
        clearstatcache();
    }

    /**
    * This method will gets all routes data.
    *
    * @return   mixed
    */
    protected function get()
    {
        // Checking for cache config.
        if($this->cache)
        {
            if(file_exists($this->cacheFile))
            {
                // Get data from cache file if the file is exists.
                // Return and decode JSON data to standart array.
                return json_decode(file_get_contents($this->cacheFile));
            }
            else
            {
                // Auto create new file and set the content(as JSON) if cache file doesn't
                // exists before.
                require_once $this->getPaths()['worksheet'] . '/requests.php';
                file_put_contents($this->cacheFile, json_encode($this->routes));

                // Return current data.
                return json_decode(file_get_contents($this->cacheFile));
            }
        }
        else
        {
            // Do standart process if user doesn't use route cache system.
            require_once $this->getPaths()['worksheet'] . '/requests.php';

            return $this->routes;
        }
    }

    /**
    * This method will initialize and validate routes data before it send
    * to the controller.
    *
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    public function init()
    {
        // Getting data.
        // If user using route cache system, re-define '$this->routes' is required.
        $this->routes = $this->get();

        try
        {
            // The data must be an array.
            if(!is_array($this->routes))
            {
                Throw new Handler(\framework\parents\Message::undefinedRouteData());
            }

            // Calls and send data to the routes controller if everything is ok.
            $this->controller->handler($this->routes);

            // If this line is reached, then the request is used Closure or Callback.
            // So, we need to set up back $this->routes to empty array and require
            // again the main request file to call that Closure or Callback.
            // User should using Closure or Callback ONLY WHEN they are on testing.
            $this->routes = [];

            require $this->getPaths()['worksheet'] . '/requests.php';
        }
        catch(Handler $e)
        {
            // Die program on unwanted condition.
            die($e->err());
        }
    }

    /**
    * This method is used by user to defining a single route data.
    *
    * @param    string                 $route
    * @param    function|bool(false)   $callback
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    protected function request($route, $callback = FALSE)
    {
        // Prepared variables.
        $data = explode(' ', rtrim(preg_replace('/\s+/', ' ', $route), ' '));
        $num = count($data);

        // Placed process into Exception Handler, in this case using 'KernelHandler'.
        // Auto die program if an unwated condition occurs.
        try
        {
            // $route is separate by space ' ', and after it exploded, it must come with
            // 3 or 4 number length or 2 with Closure or Callback. The three is must,
            // but the four is an optional. The four is passed when user using 'protected_rule' system.
            if($num > 4 AND $num < 2 OR ($num === 2 AND !$callback))
            {
                Throw new Handler(\framework\parents\Message::invalidRouteFormat());
            }

            // This selection only works after second proceed of Closure or Callback validation.
            // Variable '$this->controller->callback' was came from 'RequestController'.
            // And, here that will be executed.
            if(isset($this->controller->callback) AND $this->controller->callback === $data[1])
            {
                die($callback());
            }

            // Storing uri and method data.
            $this->data['method'] = $data[0];
            $this->data['uri'] = $data[1];

            if($callback !== FALSE)
            {
                $this->data['callback'] = 1;
                $this->callback[] = [$data[1] => $callback];
            }

            // Auto select data number three or ($data[2]).
            // If it contains "(anythingString)", then it will be decided as a View.
            // But, if it contains "@" or "::", it will be decided as a Controlelr.
            if(isset($data[2]) AND preg_match('/[(][a-zA-Z0-9.\/]*[)]/', $data[2]))
            {
                $this->data['view'] = preg_replace('/[)(]+/', '', $data[2]);
            }
            elseif(isset($data[2]) AND preg_match('/^(@)|(::)/', $data[2]))
            {
                $conn = explode('::', $data[2]);

                if(!isset($conn[1]))
                {
                    Throw new Handler(\framework\parents\Message::invalidRouteFormat());
                }

                $this->data['controller'] = ltrim($conn[0], '@');
                $this->data['user_func'] = $conn[1];
            }

            // Here is to check whether users use the 'protected_rule' system or not.
            if(isset($data[2]) AND preg_match('/^(!!)/', $data[2]))
            {
                $this->data['protected'] = ltrim($data[2], '!!');
            }
            elseif(isset($data[3]) AND preg_match('/^(!!)/', $data[3]))
            {
                $this->data['protected'] = ltrim($data[3], '!!');
            }
        }
        catch(Handler $e)
        {
            // Die program on unwanted condition.
            die($e->err());
        }

        // Store data into global route variable.
        $this->routes[] = $this->data;
        // Clean the data after stored to avoid duplicate entries.
        $this->data = [];
    }

    /**
    * This method is used by user to defining a route data with group system.
    *
    * @param    string   $route
    * @param    array    $routes
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    protected function group($route, array $routes)
    {
        // Under development...
    }
}
