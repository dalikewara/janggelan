<?php namespace system\dragon_fire\controllers;

use system\dragon_fire\abstractions\request\Request;
use system\dragon_fire\interfaces\checker\FileExists as FileChecker;
use system\dragon_fire\interfaces\support\Caller;
use system\dragon_fire\exceptions\DragonHandler;

/*
||***************************************************************************||
|| Class untuk mengontrol dan mengendalikan setiap permintaan(View)          ||
|| yang masuk.                                                               ||
||***************************************************************************||
||
*/
class ViewController extends Request implements Caller, FileChecker
{
    use \register\paths;

    /**
    ***************************************************************************
    * Melakukan pemanggilan
    * @param    array    $data
    * @return   $this
    *
    * @throws   \system\dragon_fire\exceptions\DragonHandler
    *
    */
    public function caller(array $data)
    {
        if(!is_array($data))
        {
            Throw new DragonHandler("Data 'Caller' harus berupa array!");
        }

        extract($data);

        return new $object($path, $compactData);
    }

    /**
    ***************************************************************************
    * Menangani proses data dan pemanggilan fungsi 'Caller'
    *
    * @param    string|array   $request
    * @param    array          $data
    * @param    string         $protected
    * @return   mixed
    *
    */
    public function controller($request, array $data, $protected = '')
    {
        try
        {
            $viewPath = $this->fileExists('view', $request, $protected);

            // Calling the view
            $callerData = ['object' => '\system\dragon_fire\templates\View', 'path' => $viewPath, 'compactData' => $data];
            $this->caller($callerData);
        }
        catch(DragonHandler $e)
        {
            $debugConfig = require($this->getPath()['config'] . '/debug.php');

            if($debugConfig['display_errors'] == TRUE)
            {
                die($e->getError());
            }
        }
    }

    /**
    ***************************************************************************
    * Mengecek apakah 'View/File' ada atau tidak
    *
    * @param    string   $filePath
    * @param    string   $fileName
    * @param    string   $protected
    * @return   mixed
    *
    * @throws   \system\dragon_fire\exceptions\DragonHandler
    *
    */
    public function fileExists($filePath, $fileName, $protected = '')
    {
        if($fileName[0] == '/')
        {
            $filePath = 'public';
            $fileName = ltrim($fileName, '/');

            preg_match('/.php/i', $fileName) ? ($filePhp = '') : ($filePhp = '.php');
            preg_match('/.html/i', $fileName) ? ($fileHTML = '') : ($fileHTML = '.html');
        }
        else
        {
            $fileName = '/' . $fileName;
            $filePhp  = '.php';
            $fileHTML = '.html';
        }

        if(file_exists($return = $this->getPath()[$filePath] . "{$fileName}{$filePhp}"))
        {
            return $return;
        }
        elseif(file_exists($return = $this->getPath()[$filePath] . "{$fileName}{$fileHTML}"))
        {
            return $return;
        }
        else
        {
            Throw new DragonHandler("<b>$protected</b> View <b>'$fileName'</b> tidak ditemukan.");
        }
    }
}
