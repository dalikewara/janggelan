<?php namespace system\jobs;

trait Validate
{
    /**
    ***************************************************************************
    * Fungsi untuk melakukan pembersihan data 'Single'. Fungsi ini digunakan untuk
    * keamanan Database. Data akan divalidasi untuk menghindari hal-hal yang tidak
    * diinginkan.
    *
    * @param    string|int    $data
    * @return   string|bool
    *
    */
    public function VALIDATE_SQL_DATA($data)
    {
        return (is_string($data) OR is_int($data)) ? ($validData =
            addslashes($data)) : FALSE;
    }
}
