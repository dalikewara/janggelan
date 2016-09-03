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
    public function __construct($eVIEWPATHe, array $eCOMPACTDATAe)
    {
        !is_null($eCOMPACTDATAe) ? extract($eCOMPACTDATAe) : FALSE;
        require_once($eVIEWPATHe);
    }
}
