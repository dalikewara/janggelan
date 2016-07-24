<?php namespace system\dragon_fire\abstractions\database;

abstract class Connection
{
    /**
    ***************************************************************************
    * Melakukan koneksi ke Database
    *
    * @return   mixed
    *
    */
    abstract public function connect();
}
