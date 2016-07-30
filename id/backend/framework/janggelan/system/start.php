<?php

/**
* Janggelan: Hanya Sebuah Framework PHP Yang Tidak Terduga
*******************************************************************************
*
* @package   Janggelan
* @author    Dali Kewara   <dalikewara@windowslive.com>
*/
//
// Mengatur 'debug' dan 'error reporting' -------------------------------------
$debug=new \system\parents\Debug;
// Meminta 'Request' ----------------------------------------------------------
$request=new \system\parents\Request;$request->get();
// Menghubungkan 'Request' ----------------------------------------------------
$bridge=new \system\parents\Bridge;
// ----------------------------------------------------------------------------
