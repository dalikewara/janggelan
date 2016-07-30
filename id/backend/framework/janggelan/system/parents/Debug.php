<?php namespace system\parents;

/*
||***************************************************************************||
|| Class untuk mendapatkan data konfigurasi dari 'config/debug.php'          ||
|| dan mengirimkan datanya ke 'DebugController'.                             ||                                                ||
||***************************************************************************||
||
*/
class Debug
{
    use \register\paths;

    // Berikut sengaja dibuat 'private' karena memang tidak boleh di akses
    // selain di dalam Class ini.
    private $debugConfig;

    /**
    *
    * Memanggil langsung fungsi 'controller()' dari Class 'DebugController'
    * untuk pengelolaan 'Debug' dan 'Error'.
    *
    * @return   void
    *
    */
    public function __construct()
    {
        $this->debugConfig = require_once($this->getPath()['config'] . '/debug.php');
        $debugController   = new \system\dragon_fire\controllers\DebugController;

        return $debugController->controller($this->debugConfig);
    }
}
