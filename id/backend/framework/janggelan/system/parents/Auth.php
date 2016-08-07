<?php namespace system\parents;

/*
||***************************************************************************||
|| Class untuk mendapatkan data konfigurasi dari 'config/auth.php'           ||
|| dan mengirimkan datanya ke 'AuthController', juga mengatur proteksi.      ||
||***************************************************************************||
||
*/
class Auth
{
    use \register\paths;

    /**
    ***************************************************************************
    * Memanggil langsung fungsi 'controller()' dari Class 'AuthController'
    * untuk pengelolaan 'Auth' dan proteksi.
    *
    * @var      array   $this->authConfig
    * @return   mixed
    *
    */
    public function controller()
    {
        $authController = new \system\dragon_fire\controllers\AuthController;
    }

    /**
    ***************************************************************************
    * Melakukan pengecekan proteksi secara langsung jika pada "Request"
    * menggunakan sistem 'AUTH protected_rule'.
    *
    * @param    string   $index
    * @var      array    $this->authConfig
    * @return   mixed
    *
    */
    public function protected($index, $view = TRUE)
    {
        $authController = new \system\dragon_fire\controllers\AuthController;
        $data           = $this->authConfig()['protected_rule'];

        return $authController->protected($index, $data, $view);
    }

    /**
    ***************************************************************************
    * Mendapatkan data konfigurasi dari "config/auth.php"
    *
    * @return   array
    *
    */
    public function authConfig()
    {
        return require($this->getPath()['config'] . '/auth.php');
    }
}
