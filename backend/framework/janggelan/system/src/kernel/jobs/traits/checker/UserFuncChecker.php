<?php namespace framework\kernel\jobs\traits\checker;

/*
* Class for 'User Function' checker.
*/
trait UserFuncChecker
{
    /**
    * Handle for user function checker.
    *
    * @param    object   $object
    * @param    string   $method
    * @param    string   $class
    * @throws   framework\kernel\exceptions\KernelHandler
    * @return   bool
    */
    public function checkUserFunc($object, $method, $class)
    {
        // Check if the user function is not found, throw it to Exception.
        if(!method_exists($object, $method))
        {
            Throw new \framework\kernel\exceptions\KernelHandler(
                \framework\parents\Message::userFuncDoesntExist($method, $class));

            return FALSE;
        }

        return TRUE;
    }
}
