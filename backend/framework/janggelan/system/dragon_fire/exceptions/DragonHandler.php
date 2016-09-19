<?php namespace system\dragon_fire\exceptions;

/*
||***************************************************************************||
|| Class untuk Exception dengan nama 'Dragon'.                               ||                                                ||
||***************************************************************************||
||
*/
class DragonHandler extends \Exception
{
    use \register\paths;

    /**
    *
    * Fungsi ini memanggil template 'Dragon' yang digunakan untuk
    * menampilkan hasil Exception.
    *
    * @var      array   $debugConfig
    * @return   mixed
    *
    */
   public function getError()
   {
       $debugConfig = require($this->getPath()['config'] . '/debug.php');

       if($debugConfig['display_errors'] == TRUE)
       {
           require_once __DIR__ . '/../templates/Dragon.php';
       }
   }
}
