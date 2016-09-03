<?php namespace system\parents;

/*
||***************************************************************************||
|| Class untuk permintaan pemanggilan (View). Setiap permintaan (View)       ||
|| yang ada akan dikirim menuju Class 'ViewController' untuk di proses.      ||
||***************************************************************************||
||
*/
class View
{
    /**
    ***************************************************************************
    * Memanggil langsung fungsi 'controller()' dari Class 'ViewController'
    * untuk pengelolaan permintaan (View).
    *
    * @param    string   $request
    * @param    array    $data
    * @param    string   $protected
    * @return   void
    *
    */
    public function __construct($request, array $data, $protected = '')
    {
        $requestController = new \system\dragon_fire\controllers\ViewController;

        return $requestController->controller($request, $data, $protected);
    }
}
