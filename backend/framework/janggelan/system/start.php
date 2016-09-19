<?php session_start();

/**
* Janggelan: Just An Unexpected PHP Framework
*******************************************************************************
*
* @package   Janggelan
* @author    Dali Kewara   <dalikewara@windowslive.com>
*/

// Setting up debug and error reporting
$debug = new \system\parents\Debug;
// Getting requests
$request = new \system\parents\Request;
$request->cacheRequest ? (file_exists($request->uri) ? FALSE :
    $request->get()) : $request->get();
// Connecting requests
$bridge = new \system\parents\Bridge;
