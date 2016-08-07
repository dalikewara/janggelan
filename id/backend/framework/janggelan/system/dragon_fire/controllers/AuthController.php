<?php namespace system\dragon_fire\controllers;

use system\dragon_fire\exceptions\DragonHandler;

/*
||***************************************************************************||
|| Class untuk mengendalikan pengaturan "Auth" atau pengaturan proteksi dari ||
|| sistem "Auth" di Janggelan.                                               ||
||***************************************************************************||
||
*/
class AuthController
{
    use \register\paths;

    // Berikut sengaja dibuat 'private' karena memang tidak boleh di akses
    // selain di dalam Class ini.
    private $cookie, $protectedData;

    // Sedang dalam proses
    // /**
    // ***************************************************************************
    // * Jika Anda menggunakan sistem "Auth" bawaan Janggelan, maka proses
    // * dari setiap pengaturan atau permintaan akan dikendalikan di sini.
    // *
    // * @param    array   $arrayConfig
    // * @return   mixed
    // *
    // * @throws   \system\dragon_fire\exceptions\DragonHandler
    // *
    // */
    // public function controller(array $authConfig)
    // {
    //     //
    // }

    /**
    ***************************************************************************
    * Sebuah "Request" yang menggunakan sistem "Auth protected_rule" akan
    * diproteksi di sini. Fungsi ini juga digunakan oleh "trait CHECK_RULE()"
    * untuk melakukan pengecekan "Rule".
    *
    * @param    string   $index
    * @param    array    $data
    * @return   mixed
    *
    * @throws   \system\dragon_fire\exceptions\DragonHandler
    *
    */
    public function protected($index, array $data, $view)
    {
        try
        {
            if(!in_array($index, array_keys($data)))
            {
                if($view)
                {
                    Throw new DragonHandler("index '$index' dari <i>protected_rule</i> tidak ditemukan.");
                }

                return FALSE;
                die;
            }

            $view  = $view ? $data[$index]['on_false'] : $view;
            $index = md5($index);

            if(!isset($_SESSION[$index]) AND !isset($_COOKIE[$index]))
            {
                if($view)
                {
                    new \system\parents\View($view, []);
                    die;
                }

                return FALSE;
            }

            return TRUE;
        }
        catch(DragonHandler $e)
        {
            $debugConfig = require($this->getPath()['config'] . '/debug.php');

            if($debugConfig['display_errors'] == TRUE)
            {
                die($e->getError());
            }
        }
    }
}
