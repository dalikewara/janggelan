<?php namespace system\parents;

use system\jobs\Load as Load;
use system\jobs\Validate as Validate;

/*
||***************************************************************************||
|| Class ini sebagai basis dari Controller-Controller di MVC(Janggelan).     ||                                                ||
||***************************************************************************||
||
*/
class Controller
{
    // Di sini Controller menambahkan berbagai tugas-tugas yang bisa Anda gunakan.
    use Load, Validate;
}
