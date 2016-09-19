<?php namespace system\dragon_fire\controllers;

use system\dragon_fire\exceptions\DragonHandler;

/*
||***************************************************************************||
|| Class untuk mengendalikan pengaturan "Auth" atau pengaturan proteksi dari ||
|| sistem "Auth" di Janggelan.                                               ||
||***************************************************************************||
||
*/
class AuthController
{
    use \register\paths, \register\namespaces;

    // Berikut sengaja dibuat 'private' karena memang tidak boleh di akses
    // selain di dalam Class ini.
    private $cookie, $protectedData;

    // Sedang dalam proses
    // /**
    // ***************************************************************************
    // * Jika Anda menggunakan sistem "Auth" bawaan Janggelan, maka proses
    // * dari setiap pengaturan atau permintaan akan dikendalikan di sini.
    // *
    // * @param    array   $arrayConfig
    // * @return   mixed
    // *
    // * @throws   \system\dragon_fire\exceptions\DragonHandler
    // *
    // */
    // public function controller(array $authConfig)
    // {
    //     //
    // }

    /**
    ***************************************************************************
    * Sebuah "Request" yang menggunakan sistem "Auth protected_rule" akan
    * diproteksi di sini. Fungsi ini juga digunakan oleh "trait CHECK_RULE()"
    * untuk melakukan pengecekan "Rule".
    *
    * @param    string   $index
    * @param    array    $data
    * @return   mixed
    *
    * @throws   \system\dragon_fire\exceptions\DragonHandler
    *
    */
    public function protected($index, array $data, $controller)
    {
        try
        {
            if(!in_array($index, array_keys($data)))
            {
                if($controller)
                {
                    Throw new DragonHandler('index\''.$index.'\' dari <i>protected_rule</i> tidak ditemukan.');
                }

                return FALSE;
            }

            $controller = $controller ? $data[$index]['on_false'] : $controller;
            $getPath = $this->getPath();
            $false = function() use($controller, $getPath)
            {
                if($controller)
                {
                    if(preg_match('/[(][a-zA-Z0-9 -_\/]*[)]/', $controller))
                    {
                        $view = ltrim(rtrim($controller, ')'), '(');

                        new \system\parents\View($view, [], 'PROTECTED RULE: ');
                    }
                    else
                    {
                        $request = new \system\dragon_fire\controllers\RequestController;
                        $controller = explode('::', $controller);
                        $method = end($controller);
                        $controller = reset($controller);
                        $object = $request->controllerChecker($getPath['controller'],
                            $controller, $this->getNamespace()['controller'], 'PROTECTED RULE: ');

                        $request->methodChecker($object, $method, $controller, 'PROTECTED RULE: ');

                        return $object->$method([]);
                    }
                }

                return FALSE;
            };

            isset($_SESSION[md5(base64_encode('_dateAndTime'))]) ? ($indexPrefix =
                $_SESSION[md5(base64_encode('_dateAndTime'))]) : (isset($_COOKIE[
                md5(base64_encode('_dateAndTime'))]) ? ($indexPrefix =
                $_COOKIE[md5(base64_encode('_dateAndTime'))]) : ($indexPrefix = md5(
                base64_encode(date('Y-m-d' . ' __@__ ' . date('H:i:s'))))));

            return (!isset($_SESSION[md5($indexPrefix . md5(base64_encode($index)))])
                AND !isset($_COOKIE[md5($indexPrefix . md5(base64_encode($index)))]))
                ? $false() : TRUE;
        }
        catch(DragonHandler $e)
        {
            die($e->getError());
        }
    }
}
