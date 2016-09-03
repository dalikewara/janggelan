<?php namespace system\dragon_fire\abstractions\request;

abstract class Request
{
    /**
    ***************************************************************************
    * Menangani proses data sebelum memanggil fungsi 'Caller'
    *
    * @param    string|array   $request
    * @param    array          $data
    * @return   mixed
    *
    */
    abstract public function controller($request, array $data);
}
