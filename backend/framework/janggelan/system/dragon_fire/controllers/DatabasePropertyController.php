<?php namespace system\dragon_fire\controllers;

use system\dragon_fire\interfaces\connection\DatabaseProperty as Property;
use system\dragon_fire\controllers\DatabaseDataController;
use system\dragon_fire\exceptions\DragonHandler;
use system\jobs\Validate;

/*
||***************************************************************************||
|| Class untuk mengatur properti-properti Database yang dibutuhkan untuk     ||
|| beberapa tugas seperti; mendapatkan data atau memproses koneksi.          ||
||***************************************************************************||
||
*/
class DatabasePropertyController implements Property
{
    use \register\paths, Validate;

    // Berikut sengaja dibuat 'private' karena memang tidak boleh di akses
    // selain di dalam Class ini. Variabel-variabel di bawah diperlukan sebagai
    // index data.
    private $properties, $dbHost, $dbName, $dbUsername, $dbPassword, $dbConn,
            $autoConnect;

    public function __construct()
    {
        // Data properti untuk koneksi Database berasal dari kelas 'DatabaseDataController',
        // namun belum melakukan proses pembersihan data untuk keamanan.
        // Di sini, data tersebut akan di validasi untuk meencegah hal-hal yang tidak
        // diinginkan.
        $this->properties  = new DatabaseDataController;
        $this->properties  = $this->properties->data();
        $this->autoConnect = $this->properties['AUTO_CONNECT'];
        $this->dbHost      = $this->VALIDATE_SQL_DATA($this->properties['DB_HOST']);
        $this->dbName      = $this->VALIDATE_SQL_DATA($this->properties['DB_NAME']);
        $this->dbUsername  = $this->VALIDATE_SQL_DATA($this->properties['DB_USERNAME']);
        $this->dbPassword  = $this->VALIDATE_SQL_DATA($this->properties['DB_PASSWORD']);
        $this->dbConn      = $this->VALIDATE_SQL_DATA($this->properties['DB_DEFAULT_CONNECTION']);
    }

    /**
    ***************************************************************************
    * Fungsi untuk mengembalikan dan memfilter nilai konfigurasi 'auto_connect()'
    *
    * @return   string
    *
    */
    public function autoConnect()
    {
        $this->autoConnect = !is_bool($this->autoConnect) ? FALSE : $this->autoConnect = $this->autoConnect;

        return $this->autoConnect;
    }

    /**
    ***************************************************************************
    * Fungsi untuk membuat properti proses koneksi ke database.
    *
    * @return   object   \PDO
    *
    */
    public function connectProperty()
    {
        switch($this->dbConn)
        {
            default:
                return new \PDO("$this->dbConn:host=$this->dbHost;dbname=$this->dbName",
                                 $this->dbUsername, $this->dbPassword);
                break;
        }
    }

    /**
    ***************************************************************************
    * Fungsi untuk membuat properti proses pembuatan tabel ke database.
    *
    * @param    string   $tableName
    * @param    string   $data
    * @return   string
    *
    */
    public function createProperty($tableName, $data)
    {
        switch($this->dbConn)
        {
            default:
                return "CREATE TABLE IF NOT EXISTS $tableName ($data)";
                break;
        }
    }

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
    public function selectProperty($select, $tableName, $clause)
    {
        switch($this->dbConn)
        {
            default:
                return "SELECT $select FROM $tableName $clause";
                break;
        }
    }
}
