<?php

/**
* Janggelan: Hanya Sebuah Framework PHP Yang Tidak Terduga
*******************************************************************************
*
* @package   Janggelan
* @author    Dali Kewara   <dalikewara@windowslive.com>
*/
//
// Mendapatkan konfigurasi "force uri" ----------------------------------------
$force = fopen(__DIR__ . '/force.config', 'r'); $forceUri = preg_replace('/\s/', '',
fgets($force)); fclose($force);
// Penyaringan "FORCE URI"
if($forceUri == 'FORCEURI:NO')
{
    // Menyeleksi URI apakah sebuah folder atau tidak -------------------------
    $uri = ($_SERVER['REQUEST_URI'] !== '/' && file_exists(ltrim(urldecode(
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/'))) ? FALSE : TRUE;
    // Mengaktifkan fitur psr-4 / autoload dari composer jika $uri === TRUE ---
    $uri ? require_once 'vendor/autoload.php' : FALSE;
    // Memulai framework jika $uri === TRUE -----------------------------------
    $uri ? require_once 'framework/janggelan/system/start.php' : FALSE;
}
elseif($forceUri == 'FORCEURI:YES')
{
    // Mengaktifkan fitur psr-4 / autoload dari composer ----------------------
    require_once 'vendor/autoload.php';
    // Memulai framework ------------------------------------------------------
    require_once 'framework/janggelan/system/start.php';
}
// ----------------------------------------------------------------------------
