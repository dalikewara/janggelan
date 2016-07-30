<?php return [ ////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

/*
|
| Kami sengaja melakukan kebijakan ini. Anda bebas menginginkan apakah Janggelan
| boleh melakukan koneksi ke Database secara otomatis ketika Anda membuat objek
| dari sebuah Model. Jika Anda tidak memperbolehkan Janggelan melakukan koneksi
| secara otomatis, maka Anda bisa melakukan koneksi secara manual kapanpun Anda mau
| dengan menggunakan fungsi 'Open()';
|
*/
'auto_connect' => TRUE,

/*
|
| Nama koneksi standart yang dipakai untuk setiap koneksi ke database.
| Janggelan menggunakan PDO untuk koneksi ke database dan memperbolehkan
| beberapa nama-nama koneksi yang bisa dipakai sesuai dengan daftar
| koneksi di index 'connections'.
|
*/
'default_connection' => 'mysql',

/*
|
| PDO memiliki beberapa opsi untuk menampilkan data, Anda bisa mengubah opsi
| tersebut dengan mengubah nilai di bawah.
|
*/
'pdo_fetch_style' => PDO::FETCH_CLASS,

/*
|
| Konfigurasi dari setiap koneksi-koneksi database. Pastikan Anda mengisi
| setiap nilai dari koneksi yang Anda inginkan dengan data yang benar.
|
*/
'connections' => [

    'mysql' => [
        'DB_HOST'     => 'localhost',
        'DB_NAME'     => 'janggelan',
        'DB_USERNAME' => 'root',
        'DB_PASSWORD' => ''
    ]

]

///////////////////////////////////////////////////////////////////////////////
]; ////////////////////////////////////////////////////////////////////////////
