<?php namespace system\parents;

use system\dragon_fire\abstractions\request\Route;

/*
||***************************************************************************||
|| Class untuk permintaan (Request). Class ini digunakan oleh file           ||
|| '/mvc/requests.php' untuk mendapatkan permintaan (Request),               ||
|| kemudian akan diteruskan menuju Class 'Bridge' untuk menghubungkannya     ||
|| dengan Controllernya.                                                     ||
||***************************************************************************||
||
*/
class Request extends Route
{
    // Berikut sengaja dibuat 'private' karena memang tidak boleh di akses
    // selain di dalam Class ini.
    private $finalData, $urlData, $requestsFile, $cacheFileName;

    public $cacheRequest, $uri;

    public function __construct()
    {
        $this->requestsFile = \register\paths::getPath()['root'].'/worksheet/requests.php';
        $this->cacheFileName = str_replace(' ', '_', filemtime($this->requestsFile));
        $this->cacheRequest = require_once($this->requestsFile);
        $this->cacheRequest = $this->cacheRequest['cached_requests'];
        $this->uri = __DIR__.'/../dragon_fire/storages/uri/'.$this->cacheFileName.'.uri';
        clearstatcache();
    }

    /**
    ***************************************************************************
    * Di sini Janggelan akan mengumpulkan dan mendapatkan data yang valid
    * dari setiap permintaan (Request) yang di buat di file 'mvc/requests.php'.
    *
    * @return   mixed
    *
    */
    public function get()
    {
        require_once(\register\paths::getPath()['root'].'worksheet/requests.php');

        foreach($this->urlData as $data)
        {
            $this->finalData .= "$data[0]\n";
        }

        // Janggelan menampung data permintaan yang valid di file 'requests.uri'.
        // Hal ini dilakukan agar mempermudah proses pembacaan atau validasi.
        $open = fopen(__DIR__.'/../dragon_fire/storages/uri/'.$this->cacheFileName.'.uri', 'w');

        fwrite($open, $this->finalData);
        fclose($open);
    }

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
    public function url($data, $protected = NULL)
    {
        $data = explode(' ', preg_replace('/\s\s+/', ' ', $data));
        // Janggelan menggunakan indentitas-identitas berikut untuk memisahkan
        // data dari setiap permintaan agar lebih mudah membacanya. Variabel-variabel
        // berikut ini adalah identitas defaultnya(jika data yang diminta tidak valid).
        $separate = ' ___ @_@ ___ ';
        $method = 'METHOD=BAD';
        $url = 'URI=BAD';
        $args = 'ARGS=BAD';
        $protected = (!is_null($protected)) ? $separate.':::'.$protected.':::' : '';

        (isset($data[0]) AND $data[0] != NULL) ? ($method = 'METHOD='.$data[0]) : FALSE;
        (isset($data[1]) AND $data[1] != NULL) ? ($url = 'URI='.$data[1]) : FALSE;
        (isset($data[2]) AND $data[2] != NULL) ? ((preg_match('/@[(][a-zA-Z0-9.\/]*[)]/',
            $data[2])) ? ($args = 'ARGS=view:'.ltrim(preg_replace('/[)(]/', '', $data[2]), '@'))
            : ($args = 'ARGS=controller:'.ltrim(preg_replace('/(::)/', ' method:', $data[2]) , '@')))
            : FALSE;

        $finalData = $this->urlData[] = [$method.$separate.$url.$separate.$args.$protected];

        return $finalData;
    }

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
    public function group($url, array $datas)
    {
        for($i = 0; $i < count($this->urlData); $i++)
        {
            foreach($datas as $data)
            {
                ($data == $this->urlData[$i]) ? ($this->urlData[$i][0] = preg_replace(
                    '/(___ @_@ ___ URI=)/', '___ @_@ ___ URI='.$url, $this->urlData[$i][0])) : FALSE;
            }
        }
    }
}
