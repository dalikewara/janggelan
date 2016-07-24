<?php namespace system\parents;

/*
||***************************************************************************||
|| Class untuk menghubungkan 'Request' dengan 'RequestController' yang       ||
|| mengatur pengendalian permintaan.                                         ||                                                ||
||***************************************************************************||
||
*/
class Bridge
{
    // Berikut sengaja dibuat 'private' karena memang tidak boleh di akses
    // selain di dalam Class ini.
    private $getDataArray, $getUrlMethod, $getUrl, $getArgs, $getArgsArray,
            $getArgsLeft, $getArgsRight;

    /**
    *
    * Di sini adalah proses pemisahan data dari file 'requests.uri' untuk
    * dikirim menuju Controllernya.
    *
    * @return   void
    *
    */
    public function __construct()
    {
        $open = fopen(__DIR__ . '/../dragon_fire/storages/uri/requests.uri', 'r');

        while(!feof($open))
        {
            $data = fgets($open);

            if($data != NULL OR $data != '')
            {
                $this->getDataArray           = explode(' ___ @_@ ___ ', $data);
                $this->getUrlMethod           = ltrim(reset($this->getDataArray), 'METHOD=');
                $this->getUrl                 = ltrim($this->getDataArray[1], 'URI=');
                $this->getArgs                = ltrim(end($this->getDataArray), 'ARGS=');
                $this->getArgsArray           = explode(' ', $this->getArgs);
                $this->getArgsLeft            = reset($this->getArgsArray);
                $this->getArgsRight           = end($this->getArgsArray);
                $this->getData[$this->getUrl] = [
                    $this->getUrlMethod,
                    "$this->getArgsLeft|$this->getArgsRight"
                ];
            }
        }

        fclose($open);

        $requestController = new \system\dragon_fire\controllers\RequestController;

        return $requestController->controller($request = NULL, $this->getData);
    }
}
