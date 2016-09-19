<?php

/**
* Janggelan: Just An Unexpected PHP Framework
*******************************************************************************
*
* @package   Janggelan
* @author    Dali Kewara   <dalikewara@windowslive.com>
*/

// Getting "FORCE URI" configuration
$forceUri = preg_replace('/\s/', '', file_get_contents(__DIR__.'/force.config'));

// Filtering "FORCE URI"
if($forceUri == 'FORCEURI:NO')
{
    // Checking URI is it a folder or not
    $uri = ($_SERVER['REQUEST_URI'] !== '/' && file_exists(ltrim(urldecode(
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/'))) ? FALSE : TRUE;

    // Activate Composer autoload/psr-4 feature and starting the framework
    // if the $uri is TRUE
    if($uri)
    {
        require_once 'vendor/autoload.php';
        require_once 'framework/janggelan/system/start.php';
    }
}
elseif($forceUri == 'FORCEURI:YES')
{
    require_once 'vendor/autoload.php';
    require_once 'framework/janggelan/system/start.php';
}
