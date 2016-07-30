<?php namespace system\dragon_fire\interfaces\connection;

interface DatabaseProperty
{
    /**
    ***************************************************************************
    * Fungsi untuk mengembalikan dan memfilter nilai konfigurasi 'auto_connect()'
    *
    * @return   string
    *
    */
    public function autoConnect();

    /**
    ***************************************************************************
    * Fungsi untuk membuat properti proses koneksi ke database.
    *
    * @return   object   \PDO
    *
    */
    public function connectProperty();

    /**
    ***************************************************************************
    * Fungsi untuk membuat properti proses pembuatan tabel ke database.
    *
    * @param    string   $tableName
    * @param    string   $data
    * @return   string
    *
    */
    public function createProperty($tableName, $data);

    /**
    ***************************************************************************
    * Fungsi untuk membuat properti proses mendapatkan data dari database.
    *
    * @param    string   $select
    * @param    string   $tablename
    * @param    string   $clause
    * @return   string
    *
    */
    public function selectProperty($select, $tableName, $clause);
}
