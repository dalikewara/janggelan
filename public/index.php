<?php

/**
* Janggelan: Hanya Sebuah Framework PHP Yang Tidak Terduga
*******************************************************************************
*
* @package   Janggelan
* @author    Dali Kewara   <dalikewara@windowslive.com>
*/
//
// Memanggil autoload jika url bukan sebuah path folder -----------------------
if($_SERVER['REQUEST_URI'] !== '/' && file_exists(ltrim(urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/')))
{
    return FALSE;
}

require_once '../backend/autoload.php';
// ----------------------------------------------------------------------------
