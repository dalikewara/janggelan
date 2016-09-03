<?php namespace system\parents;

use system\dragon_fire\artists\Model as Artist;
use system\dragon_fire\controllers\DatabasePropertyController;

/*
||***************************************************************************||
|| Class ini sebagai basis dari Model-Model di MVC(Janggelan).               ||
||***************************************************************************||
||
*/
class Model extends Artist
{
    // ArtisModel membutuhkan properti-properti berikut sebagai
    // bahan acuan fungsinya dan agar nilainya bisa digabungkan.
    protected $artistModelSelect, $artistModelClause, $artistModelParam,
              $artistModelRange, $artistModelSelectDef, $artistModelClauseDef,
              $artistModelParamDef, $artistModelRangeDef;

    // Berikut merupakan properti-properti untuk keperluan koneksi Database
    // '$this->dbProperties' digunakan sebagai index properti data untuk Database
    protected $dbConnect, $smartTable, $smartColumn, $defaultColumn, $dbProperties;

   /**
   ****************************************************************************
   * Di sini Model akan mengumpulkan data dan membuka koneksi. Data yang dikumpulkan
   * berasal dari fungsi 'tableInformation()' dari Modelnya. Pastikan Anda mengisinya
   * dengan data yang valid.
   *
   * @var      array   $tableInformation
   * @static   array   $this->defaultColumn
   * @return   void
   *
   */
    public function __construct()
    {
        // Mengatur nilai bawaan variabel untuk Artist. Variabel-variabel berikut
        // akan berubah nilainya sesuai dengan tipe seleksi yang diinginkan.
        $this->artistModelSelectDef = $this->artistModelSelect = '*';
        $this->artistModelClauseDef = $this->artistModelClause = '';
        $this->artistModelParamDef  = $this->artistModelParam  = [];
        $this->artistModelRangeDef   = $this->artistModelRange = '';

        // Mendapatkan nama tabel dan nama kolom. Nama tabel dan nama kolom
        // harus sesuai dengan Database agar bisa bekerja dengan benar.
        $tableInformation      = static::tableInformation();
        $this->smartTable    = key($tableInformation);
        $this->smartColumn   = array_keys(current($tableInformation));
        $this->defaultColumn = current($tableInformation);

        // Membuka koneksi ke Database. Jika konfigurasi (config/database.php)
        // 'auto_connect' bernilai FALSE, maka Janggelan tidak akan melakukan koneksi
        // ke Database secara otomatis. Untuk membuat koneksi ke Database
        // Anda bisa melakukannya secara manual dengan menggunakan fungsi 'Open()'.
        $this->dbProperties = new DatabasePropertyController;

        // $this->dbProperties->autoConnect() ? $this->Open() : FALSE;
        $this->dbProperties->autoConnect() ? FALSE : FALSE;
    }
}
