<?php namespace system\dragon_fire\templates;

/*
||***************************************************************************||
|| Di sinilah sebuah 'View' akan dipanggil. Janggelan melakukan              ||
|| 'require_once' untuk memanggil View yang diinginkan. Dan melakukan        ||
|| ekstrak data apabila Controller mengirim data ke View.                    ||
||***************************************************************************||
||
*/
class View
{
    // Berikut sengaja dibuat 'private' karena memang tidak boleh di akses
    // selain di dalam Class ini.
    protected $eCOMPACTDATAe;

    public function __construct($eVIEWPATHe, array $eCOMPACTDATAe)
    {
        if(!is_null($this->eCOMPACTDATAe))
        {
            extract($this->eCOMPACTDATAe);
        }

        require_once($eVIEWPATHe);
    }
}
