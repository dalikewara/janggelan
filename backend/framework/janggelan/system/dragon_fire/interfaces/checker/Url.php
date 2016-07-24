<?php namespace system\dragon_fire\interfaces\checker;

interface Url
{
    /**
    ***************************************************************************
    * Penanganan Pengecekan Url.
    * Fungsi ini akan mengecek apakah url yang diminta valid atau tidak.
    *
    * @param    string   $url
    * @param    string   $method
    * @param    array    $array
    * @return   mixed
    *
    */
    public function urlChecker($url, $method, array $array);
}
