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
        $this->properties = new DatabaseDataController;
        $this->properties = $this->properties->data();
        $this->autoConnect = $this->properties['AUTO_CONNECT'];
        $this->dbHost = $this->VALIDATE_SQL_DATA($this->properties['DB_HOST']);
        $this->dbName = $this->VALIDATE_SQL_DATA($this->properties['DB_NAME']);
        $this->dbUsername = $this->VALIDATE_SQL_DATA($this->properties['DB_USERNAME']);
        $this->dbPassword = $this->VALIDATE_SQL_DATA($this->properties['DB_PASSWORD']);
        $this->dbConn = $this->VALIDATE_SQL_DATA($this->properties['DB_DEFAULT_CONNECTION']);
    }

    /**
    ***************************************************************************
    * Fungsi untuk mengembalikan dan memfilter nilai konfigurasi 'auto_connect()'
    *
    * @return   bool
    *
    */
    public function autoConnect()
    {
        $this->autoConnect = !is_bool($this->autoConnect) ? FALSE :
            $this->autoConnect = $this->autoConnect;

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
                return new \PDO($this->dbConn.':host='.$this->dbHost.
                    ';dbname='.$this->dbName,$this->dbUsername, $this->dbPassword);
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
                return 'CREATE TABLE IF NOT EXISTS '.$tableName.' ('.$data.')';
                break;
        }
    }

    /**
    ***************************************************************************
    * Fungsi untuk membuat properti penambahan data ke database.
    *
    * @param    string   $tableName
    * @param    string   $columnName
    * @param    string   $value
    * @return   string
    *
    */
    public function insertProperty($tableName, $columnName, $value)
    {
        switch($this->dbConn)
        {
            default:
                return 'INSERT INTO '.$tableName.' ('.$columnName.') VALUES ('.$value.')';
                break;
        }
    }

    /**
    ***************************************************************************
    * Fungsi untuk membuat properti perbaruan data di database.
    *
    * @param    string   $tableName
    * @param    string   $value
    * @param    string   $whereClause
    * @return   string
    *
    */
    public function updateProperty($tableName, $value, $whereClause)
    {
        switch($this->dbConn)
        {
            default:
                return 'UPDATE '.$tableName.' SET '.$value.' WHERE '.$whereClause;
                break;
        }
    }

    /**
    ***************************************************************************
    * Fungsi untuk membuat properti menghapus data di database.
    *
    * @param    string   $tableName
    * @param    string   $columnName
    * @param    string   $value
    * @return   string
    *
    */
    public function deleteProperty($tableName, $whereClause, $all = FALSE)
    {
        switch($this->dbConn)
        {
            default:
                return $all ? 'DELETE FROM '.$tableName : 'DELETE FROM '.
                    $tableName.' WHERE '.$whereClause;
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
    * @param    string   $range
    * @return   string
    *
    */
    public function selectProperty($select, $tableName, $clause, $range = '')
    {
        switch($this->dbConn)
        {
            default:
                return 'SELECT '.$select.' FROM '.$tableName.' '.$clause.' '.$range;
                break;
        }
    }

    /**
    ***************************************************************************
    * Fungsi untuk membuat properti proses pembatasan jumlah data.
    *
    * @param    integer   $take
    * @param    integer   $skip
    * @return   string
    *
    */
    public function rangeProperty($take, $skip)
    {
        switch($this->dbConn)
        {
            default:
                return 'LIMIT '.$take.' OFFSET '.$skip;
                break;
        }
    }
}
