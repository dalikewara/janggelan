<?php namespace system\parents;

use system\jobs\Auth as Auth;
use system\jobs\Load as Load;
use system\jobs\Validate as Validate;
use system\jobs\Get as Get;

/*
||***************************************************************************||
|| Class ini sebagai basis dari Controller-Controller di MVC(Janggelan).     ||                                                ||
||***************************************************************************||
||
*/
class Controller
{
    // Di sini "Controller" menambahkan berbagai tugas-tugas yang bisa Anda gunakan.
    // Jika Anda menghilangkan "extends" kelas di "Controller" ke base "Controller" ini,
    // maka untuk menggunakan tugas-tugas di bawah ini, Anda perlu menambahkan secara
    // manual di "Controller" Anda.
    use Auth, Load, Validate, Get;
}
