<?php namespace system\dragon_fire\abstractions\request;

abstract class Route
{
    /**
    ***************************************************************************
    * Di sini Janggelan akan mengumpulkan dan mendapatkan data yang valid
    * dari setiap permintaan (Request) yang di buat di file 'mvc/requests.php'.
    *
    * @return   mixed
    *
    */
    abstract public function get();

    /**
    ***************************************************************************
    * Fungsi ini di gunakan untuk mendaftarkan dan membuat data permintaan
    * dengan gaya 'Satu Baris', yang berarti akan langsung mendaftarkan url
    * tanpa ada pilihan-pilihan lain, kecuali properti bawaannya.
    *
    * @param    array   $data
    * @param    bool    $protected
    * @return   array
    *
    */
    abstract public function url($data, $protected = NULL);

    /**
    ***************************************************************************
    * Fungsi ini di gunakan untuk mendaftarkan dan membuat data permintaan
    * dengan gaya 'Pengelompokan', yang berarti akan mendaftarkan url secara
    * berkelompok. Fungsi ini bisa mendaftarkan banyak url(dari fungsi url()) sekaligus.
    *
    * @param    string   $url
    * @param    array    $datas
    * @return   mixed
    *
    */
    abstract public function group($url, array $datas);
}
