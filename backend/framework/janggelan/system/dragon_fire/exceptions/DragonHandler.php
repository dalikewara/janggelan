<?php namespace system\dragon_fire\exceptions;

/*
||***************************************************************************||
|| Class untuk Exception dengan nama 'Dragon'.                               ||                                                ||
||***************************************************************************||
||
*/
class DragonHandler extends \Exception
{
    /**
    *
    * Fungsi ini memanggil template 'Dragon' yang digunakan untuk
    * menampilkan hasil Exception.
    *
    * @return   mixed
    *
    */
   public function getError()
   {
      require_once __DIR__ . '/../templates/Dragon.php';
   }
}
