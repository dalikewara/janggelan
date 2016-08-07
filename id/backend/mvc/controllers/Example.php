<?php namespace mvc\controllers;

use mvc\models\Example;

/*
|--------------------------------------------------------------------------
| Contoh Controller
|--------------------------------------------------------------------------
|
| Berikut adalah contoh dari Controller yang ada di Janggelan. Anda bisa melakukan
| berbagai hal di Controller ini, seperti mengatur lalu lintas data, meminta tugas,
| mengendalikan View, memproses data, memvalidasi data, atau membuat fungsi-fungsi
| yang memudahkan Anda. Silahkan salin contoh Controller ini jika Anda belum hafal
| susunannya.
|
| Untuk 'extends \system\parents\Controllers' adalah opsional. Anda tentu saja bisa
| membuang atau menghapusnya. Namun, pada '\system\parents\Controller' telah ditambahkan
| tugas-tugas untuk bisa Anda gunakan, seperti memanggil View(Parent::LOAD_VIEW()).
| Jika Anda membuang atau menghapus 'extends \system\parents\Controllers', mungkin
| Anda perlu menyertakan tugas-tugas tersebut langsung di dalam Controller Anda.
|
*/
class Example extends \system\parents\Controller
{
    // Lakukan sesuatu disini

    /**
    *
    * Berikut ini hanya sebuah contoh fungsi yang mengarah ke sebuah View.
    * Silahkan di hapus jika ingin.
    *
    * @return   mixed|View
    *
    */
    public function index()
    {
      
        return Parent::LOAD_VIEW('example');
    }
}
