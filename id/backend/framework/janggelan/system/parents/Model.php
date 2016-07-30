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
              $artistModelSelectDef, $artistModelClauseDef, $artistModelParamDef;

    // Berikut sengaja dibuat statis agar ArtisModel tidak mengembalikan
    // nilai dari peroperti-properti berikut ketika melakukan 'return $this'.
    // 'static::$dbProperties' digunakan sebagai index properti data untuk Database
    protected static $dbConnect, $smartTable, $smartColumn, $defaultColumn, $dbProperties;

   /**
   ****************************************************************************
   * Di sini Model akan mengumpulkan data dan membuka koneksi. Data yang dikumpulkan
   * berasal dari fungsi 'tableInformation()' dari Modelnya. Pastikan Anda mengisinya
   * dengan data yang valid.
   *
   * @var      array   $tableInformation
   * @static   array   static::$defaultColumn
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

        // Mendapatkan nama tabel dan nama kolom. Nama tabel dan nama kolom
        // harus sesuai dengan Database agar bisa bekerja dengan benar.
        $tableInformation      = static::tableInformation();
        static::$smartTable    = key($tableInformation);
        static::$smartColumn   = array_keys(current($tableInformation));
        static::$defaultColumn = current($tableInformation);

        // Membuka koneksi ke Database. Jika konfigurasi (config/database.php)
        // 'auto_connect' bernilai FALSE, maka Janggelan tidak akan melakukan koneksi
        // ke Database secara otomatis. Untuk membuat koneksi ke Database
        // Anda bisa melakukannya secara manual dengan menggunakan fungsi 'Open()'.
        static::$dbProperties = new DatabasePropertyController;

        static::$dbProperties->autoConnect() ? $this->Open() : FALSE;
    }
}
