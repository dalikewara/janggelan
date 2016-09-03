<?php namespace system\dragon_fire\interfaces\checker;

interface Method
{
    /**
    ***************************************************************************
    * Penanganan Pengecekan Controller Method.
    * Fungsi ini akan mengecek apakah controller yang diminta memiliki
    * method yang sesuai atau tidak.
    *
    * @param    object   $objectClass   Namespace\To\Class
    * @param    string   $method
    * @param    string   $className
    * @param    string   $protected
    * @return   mixed
    *
    */
    public function methodChecker($objectClass, $method, $className, $protected);
}
