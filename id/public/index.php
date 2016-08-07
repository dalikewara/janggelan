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
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

return ($_SERVER['REQUEST_URI'] !== '/' AND file_exists(ltrim($uri, '/'))) ? FALSE :
       require_once('../backend/autoload.php');
// ----------------------------------------------------------------------------
