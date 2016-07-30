<?php namespace mvc\models;

/*
|--------------------------------------------------------------------------
| Contoh Model
|--------------------------------------------------------------------------
|
| Berikut adalah contoh dari Model yang ada di Janggelan. Anda bisa melakukan
| berbagai hal di Model ini, seperti membuat relasi atau membuat fungsi-fungsi
| yang memudahkan Anda. Silahkan salin contoh Model ini jika Anda belum hafal
| susunannya. Untuk mendeklarasikan sebuah Model di Controller, Anda hanya
| perlu membuat objeknya:  '$model = new ModelName;' (jangan lupa untuk memanggil
| namespace dari Modelnya) 'use namespace\to\ModelName'.
|
| Anda harus selalu menyertakan 'extends \system\parents\Model'
|
*/
class Example extends \system\parents\Model
{
    // Lakukan sesuatu di sini

    /**
    *
    * Sebuah Model harus memiliki fungsi 'tableInformation()' dengan format yang benar
    * agar Model bisa berjalan. Ini digunakan oleh sistem untuk mengumpulkan data
    * seperti nama tabel, nama kolom, dll. Anda juga perlu mendeklarasikan data/properti dari
    * setiap kolom tabel agar bisa digunakan untuk membuat tabel di Database. Gunakan fungsi
    * 'Create()' untuk membuat tabel. Contoh: '$model = new Model; $model->Create();'
    *
    * *Nama tabel dan kolom di fungsi ini harus sesuai dengan yang ada di Database.
    *
    * @return   array
    *
    */
    public function tableInformation()
    {
        return [
            'example_table_name' => [
                'id'       => 'INT(11) AUTO_INCREMENT PRIMARY KEY',
                'username' => 'VARCHAR(255) NOT NULL',
                'password' => 'VARCHAR(255) NOT NULL'
            ]
        ];
    }
}
