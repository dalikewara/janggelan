<?php namespace system\dragon_fire\artists;

use system\dragon_fire\exceptions\DragonHandler;
use system\dragon_fire\controllers\DatabaseDataController;

/*
||***************************************************************************||
|| Class Artist Job digunakan untuk menangani fungsi-fungsi "Jobs" yang      ||
|| menggunakan data, konfigurasi atau sumber-sumber dari sistem Janggelan.   ||
||***************************************************************************||
||
*/
class Job
{
    // Berikut sengaja dibuat 'private' karena memang tidak boleh di akses
    // selain di dalam Class ini. Variabel-variabel di bawah diperlukan sebagai
    // index data.
    private $dbConnection;

    /**
    ***************************************************************************
    * Fungsi ini akan mendapatkan nama koneksi database bawaan untuk "Jobs" agar
    * bisa digunakan oleh "user-level".
    *
    * @return   string
    *
    */
    public function getConnection()
    {
        $this->dbConnection = new DatabaseDataController;

        return $this->dbConnection->data()['DB_DEFAULT_CONNECTION'];
    }
}
