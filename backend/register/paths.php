<?php namespace register; trait paths { static function getPath() { return [ //
///////////////////////////////////////////////////////////////////////////////

/*
|------------------------------------------------------------------------------
| Configurasi Path
|------------------------------------------------------------------------------
|
| Ini adalah pendaftaran path atau alamat dari suatu file atau
| direktori. Ada beberapa path yang otomatis telah tersedia, dan itu
| dibutuhkan oleh sistem. Sebaiknya Anda tidak merubahnya, kecuali merubah
| nilainya (jika Anda mengerti apa yang Anda lakukan).
|
*/
'realpath'   => __DIR__ . '/../',
'root'       => __DIR__ . '/../../',
'config'     => __DIR__ . '/../config',
'controller' => __DIR__ . '/../mvc/controllers',
'view'       => __DIR__ . '/../mvc/views'

///////////////////////////////////////////////////////////////////////////////
];}} //////////////////////////////////////////////////////////////////////////
