<?php namespace system\dragon_fire\interfaces\support;

interface Auth
{
    /**
    ***************************************************************************
    * Melakukan pengecekan proteksi secara langsung jika pada "Request"
    * menggunakan sistem 'AUTH protected_rule'.
    *
    * @param    string   $index
    * @param    bool     $controller
    * @var      array    $this->authConfig
    * @return   mixed
    *
    */
    public function protected($index, $controller = TRUE);

    /**
    ***************************************************************************
    * Mendapatkan data konfigurasi dari "config/auth.php"
    *
    * @return   array
    *
    */
    public function authConfig();
}
