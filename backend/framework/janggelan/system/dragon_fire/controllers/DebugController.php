<?php namespace system\dragon_fire\controllers;

use system\dragon_fire\exceptions\DragonHandler;

/*
||***************************************************************************||
|| Class untuk mengendalikan pengaturan 'Debug' atau 'Error Reporting' dari  ||
|| sistem PHP dan Janggelan.                                                 ||
||***************************************************************************||
||
*/
class DebugController
{
    /**
    ***************************************************************************
    * Mengontrol 'debug' dan error 'reporting'
    *
    * @param    array   $debugConfig
    * @return   mixed
    *
    * @throws   \system\dragon_fire\exceptions\DragonHandler
    *
    */
    public function controller(array $debugConfig)
    {
        if(!is_array($debugConfig))
        {
            Throw new DragonHandler("Data konfigurasi 'config/debug.php' harus berupa array!");
        }

        ini_set('display_errors', $debugConfig['display_errors']);
        error_reporting($debugConfig['error_reporting']);
        error_log($debugConfig['error_log']);
    }
}
