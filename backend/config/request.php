<?php return [ ////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

/*
|
| Konfigurasi untuk mengalihkan halaman kesalahan berupa View jika Request yang diminta tidak
| valid atau tidak tersedia. Jika nilainya 'default', maka Janggelan akan menggunakan
| sistem pengalihan (redirect) View kesalahan bawaan. Anda bisa mengisi nilainya dengan
| url pengalihan (redirect) Anda sendiri.
|
*/
'redirect_on_false' => [
    'route'         => 'default',
    'requestMethod' => 'default',
    'controller'    => 'default',
    'method'        => 'default',
    'view'          => 'default'
],

///////////////////////////////////////////////////////////////////////////////
]; ////////////////////////////////////////////////////////////////////////////
