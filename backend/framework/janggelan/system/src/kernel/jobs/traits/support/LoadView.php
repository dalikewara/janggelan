<?php namespace framework\kernel\jobs\traits\support;

/*
* The built in 'Load View' class.
*/
trait LoadView
{
    /**
    * This method/function used to call 'View'.
    *
    * @param    string   $name
    * @return   bool
    */
    public function LOAD_VIEW($name, array $data = [])
    {
        // Call the 'View' handler.
        $view = new \framework\kernel\controllers\ViewController;

        $view->handler($name, $data);
    }
}
