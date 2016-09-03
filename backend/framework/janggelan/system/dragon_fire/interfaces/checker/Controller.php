<?php namespace system\dragon_fire\interfaces\checker;

interface Controller
{
    /**
    ***************************************************************************
    * Penanganan Pengecekan Controller.
    * Fungsi ini akan mengecek apakah Controller yang diminta tersedia
    * atau tidak.
    *
    * @param    string      $path
    * @param    string      $name
    * @param    string      $namespace
    * @param    string      $protected
    * @return   mixed
    *
    */
    public function controllerChecker($path, $name, $namespace, $protected);
}
