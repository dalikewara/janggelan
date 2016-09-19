<?php return [

    /*
    |
    | Cached the requests can be speed up performance, because system doesn't needs
    | to process Request System everytime when users made it. But, you have to be careful
    | if you are using dinamical requests (cached the request may not be a good solution).
    |
    | Dinamical requests example: You are using query/database result to generate new requests.
    |
    */
    'cached_requests' => TRUE,

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

];
