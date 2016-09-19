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
    protected $artistModelSelect, $artistModelClause, $artistModelParam,
              $artistModelRange, $artistModelSelectDef, $artistModelClauseDef,
              $artistModelParamDef, $artistModelRangeDef;

    public function __construct()
    {
        // Mengatur nilai bawaan variabel untuk Artist. Variabel-variabel berikut
        // akan berubah nilainya sesuai dengan tipe seleksi yang diinginkan.
        $this->artistModelSelectDef = $this->artistModelSelect = '*';
        $this->artistModelClauseDef = $this->artistModelClause = '';
        $this->artistModelParamDef = $this->artistModelParam  = [];
        $this->artistModelRangeDef = $this->artistModelRange = '';
    }
}
