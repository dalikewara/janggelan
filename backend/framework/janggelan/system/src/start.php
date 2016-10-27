<?php session_start();

/**
* Janggelan: Just an unexpected PHP framework
*******************************************************************************
*
* @package   Janggelan
* @author    Dali Kewara   <dalikewara@windowslive.com>
*/

// Generating and processing requests.
$request = new \framework\parents\Request;
$request->init();
