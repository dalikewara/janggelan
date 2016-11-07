<?php namespace framework\kernel\controllers;

use framework\kernel\abstractions\controllers\ViewController as Blueprint;
use framework\kernel\exceptions\KernelHandler as Handler;

class ViewController extends Blueprint
{
    // Using global paths.
    use \glob\paths;

    /**
    * Handle for final view request.
    *
    * @param    string   $name
    * @param    array    $data
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   mixed
    */
    public function handler($name, array $data)
    {
        try
        {
            // If the view doesn't exist, throw it to Exception.
            if(($name[0] === '/' AND !file_exists($this->getPaths()['root'] . $name . '.php')) OR
            ($name[0] !== '/' AND !file_exists($this->getPaths()['view'] . '/' . $name . '.php')))
            {
                Throw new Handler(\framework\parents\Message::viewDoesntExists($name));
            }

            // Generating 'View' path
            if($name[0] === '/')
            {
                $path = $this->getPaths()['root'] . $name . '.php';
            }
            else
            {
                $path = $this->getPaths()['view'] . '/' . $name . '.php';
            }

            // If everything is ok, initialize View class.
            return new \framework\parents\View($path, $data);
        }
        catch(Handler $e)
        {
            // Die program on unwanted condition.
            die($e->err());
        }
    }
}
