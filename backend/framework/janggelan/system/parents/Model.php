<?php namespace system\parents;

use system\dragon_fire\artists\Model as Artist;

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
    protected $artistModelSelect, $artistModelClause;

    // Berikut sengaja dibuat statis agar ArtisModel tidak mengembalikan
    // nilai dari peroperti-properti berikut ketika 'return $this'.
    // 'static::$smartConnection' digunakan sebagai index koneksi ke Database
    protected static $dbConnect, $smartTable, $smartColumn, $smartConnection,
                     $defaultColumn;

   /**
   *
   * Di sini Model akan mengumpulkan data dan membuka koneksi. Data yang dikumpulkan
   * berasal dari fungsi 'tableInformation()' dari Modelnya.
   *
   * @return   void
   *
   */
    public function __construct()
    {
        // Mengatur nilai bawaan variabel untuk Artist
        $this->artistModelSelect = '*';
        $this->artistModelGet    = $this->artistModelClause = '';

        // Mendapatkan nama tabel dan nama kolom. Nama tabel dan nama kolom
        // harus sesuai dengan Database agar bisa bekerja dengan benar.
        $tableInformation      = static::tableInformation();
        static::$smartTable    = key($tableInformation);
        static::$smartColumn   = array_keys(current($tableInformation));
        static::$defaultColumn = current($tableInformation);

        // Membuka koneksi ke database
        return $this->Open();
    }
}
