<?php return [

    /*
    |
    |
    |
    */
    'build_in_auth' => [
        'active_this'   => FALSE,
        'properties' => [
            'model'         => $this->auth('MODEL'),
            'table'         => $this->auth('TABLE'),
            'indexes'       => $this->auth('INDEXES'),
            'index_columns' => $this->auth('INDEX_COLUMNS'),
        ],
    ],

    /*
    |
    | Ini adalah pengaturan untuk penyimpanan "SESSION". Jika Anda ingin "SESSION"
    | untuk sistem "AUTH" disimpan di dalam "COOKIE", maka ubah nilainya ke "TRUE".
    | Menyimpan data di "COOKIE" mungkin akan menyangkut masalah privasi, pastikan
    | Anda menulis tentang penggunaan "COOKIE" di aplikasi Anda untuk memberitahu
    | pengguna tentang masalah ini.
    |
    | Nilai "FALSE" berarti data akan disimpan dengan menggunakan "SESSION" bawaan.
    |
    */
    'use_cookie' => FALSE,

    /*
    |
    | Ini adalah sebuah index untuk proteksi. Index ini akan membantu Anda memproteksi
    | halaman dari website atau aplikasi yang Anda buat. Anda bisa merubah atau
    | menambahkan index sesuai kebutuhan. Nantinya, index-index tersebut akan menyimpan
    | nilai data token ke dalam "SESSION" atau "COOKIE" (sesuai konfigurasi di "use_cookie").
    | Jika pengguna tidak mempunyai nilai data/index token tersebut, maka pengguna akan
    | otomatis dialihkan ke Controller/View di "on_false". Sangat bermanfaat untuk "Auth".
    |
    | Untuk menambahkan index:
    |
    | 'index_name' => [
    |
    |      // Ke Controller
    |     'on_false' => 'controllerName::controllerMethod'
    |
    |     // Ke View
    |     'on_false' => '(viewName)'
    |
    | ]
    |
    */
    'protected_rule' => [
        'rule_name' => [
            'on_false' => 'rule_destination'
        ],
    ],
    
];
