<?php

/**
* Janggelan: Just an unexpected PHP framework
*******************************************************************************
*
* @package   Janggelan
* @author    Dali Kewara   <dalikewara@windowslive.com>
*/

// Filtering for 'force.uri' config.
// If 'force.uri' is TRUE, then system will not checked for available path folder
// based on the uri. The system will always throws uri through into Janggelan kernel.
if(preg_match('/(TRUE)/', file_get_contents(__DIR__.'/force.uri')))
{
    // Activate Composer autoload/psr-4 feature and starting the framework.
    require_once 'vendor/autoload.php';
    require_once 'framework/janggelan/system/src/start.php';
}
else
{
    // Checking if uri is a folder or not
    $uri = ($_SERVER['REQUEST_URI'] !== '/' && file_exists(ltrim(urldecode(
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/'))) ? TRUE : FALSE;

    // Activate Composer autoload/psr-4 feature and starting the framework
    // if the uri is FALSE(not a folder).
    if(!$uri)
    {
        require_once 'vendor/autoload.php';
        require_once 'framework/janggelan/system/src/start.php';
    }
}
