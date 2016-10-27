<?php namespace framework\kernel\jobs\traits\checker;

/*
* Class for 'Controller' checker.
*/
trait ControllerChecker
{
    /**
    * Handle for controller checker.
    *
    * @param    string   $path
    * @param    string   $name
    * @param    string   $namespace
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   bool
    */
    public function checkController($path, $name, $namespace)
    {
        // Check if the controller file doesn't exist, throw it to Exception.
        if(!file_exists($path . '/' . str_replace('\\', '/', $name) . '.php'))
        {
            Throw new \framework\kernel\exceptions\KernelHandler(
                \framework\parents\Message::controllerDoesntExist($name));

            return FALSE;
        }

        // Prepared controller namespace.
        $object = $namespace . '\\' . $name;

        // Check if the controller class is not found, throw it to Exception.
        if(!class_exists($object))
        {
            Throw new \framework\kernel\exceptions\KernelHandler(
                \framework\parents\Message::wrongController($name, $namespace));

            return FALSE;
        }

        // If everything is ok, set the controller object to $this->object variable.
        $this->object = new $object;

        return TRUE;
    }
}
