<?php namespace system\dragon_fire\interfaces\connection;

interface DataFilter
{
    /**
    ***************************************************************************
    * Fungsi untuk mendapatkan data
    *
    * @return   mixed
    *
    */
    public function getData();

    /**
    ***************************************************************************
    * Melakukan filter data dari file konfigurasi
    *
    * @param    array   $data
    * @return   array
    *
    */
    public function dataFilter(array $data);

    /**
    ***************************************************************************
    * Memberikan data valid yang terstruktur agar mudah digunakan
    *
    * @return   array
    *
    */
    public function data();
}
