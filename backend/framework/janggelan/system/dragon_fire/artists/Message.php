<?php namespace system\dragon_fire\artists;

/*
||***************************************************************************||
|| Class Artist Job digunakan untuk menangani fungsi-fungsi "Jobs" yang      ||
|| menggunakan data, konfigurasi atau sumber-sumber dari sistem Janggelan.   ||
||***************************************************************************||
||
*/
class Message
{
    public function uriNotRegistered($uri)
    {
        return 'Request failed, uri <b>\''.$uri.'\'</b> doesn\'t registered!';
    }

    public function methodRequestNotAllowed()
    {
        return '\'Method Request\' not allowed!';
    }

    public function controllerDoesntExists($protected, $name)
    {
        return '<b>'.$protected.'</b> Controller <b>\''.$name.'\'</b> doest\'t exists.';
    }

    public function wrongController($protected, $namespace, $name)
    {
        return '<b>'.$protected.'</b> Namespace or class <b>\''.$namespace.'\\'.$name.'\'</b>
        not found.';
    }

    public function methodDoesntExists($protected, $method, $className)
    {
        return '<b>'.$protected.'</b> Method <b>\''.$method.'\'</b> not found in controller
        <b>\''.$className.'\'</b>.';
    }

    public function dataMustArray($index)
    {
        return 'Data \''.$index.'\' must be array!';
    }
}
