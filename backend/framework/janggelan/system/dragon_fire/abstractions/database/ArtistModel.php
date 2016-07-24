<?php namespace system\dragon_fire\abstractions\database;

abstract class ArtistModel
{
    /**
    ***************************************************************************
    * Menampilkan dan mendapatkan semua data dari tabel
    *
    * @return   array
    *
    */
    abstract public function All();

    /**
    ***************************************************************************
    * Menampilkan semua data berdasarkan nama kolom yang dipilih
    *
    * @param    string   $column
    * @return   $this
    *
    */
    abstract public function Select($column);

    /**
    ***************************************************************************
    * Menyaring data berdasarkan tipe yang ditentukan
    *
    * @param    string   $value
    * @return   $this
    *
    */
    abstract public function Clause($value);


    /**
    ***************************************************************************
    * Menampilkan dan mendapatkan semua data yang sebelumnya di seleksi
    *
    * @return   array
    *
    */
    abstract public function Result();
}
