<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite6d2fd568a827c02148b852cd150eb46
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'system\\' => 7,
        ),
        'r' => 
        array (
            'register\\' => 9,
        ),
        'm' => 
        array (
            'mvc\\' => 4,
        ),
        'c' => 
        array (
            'config\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'system\\' => 
        array (
            0 => __DIR__ . '/../..' . '/framework/janggelan/system',
        ),
        'register\\' => 
        array (
            0 => __DIR__ . '/../..' . '/register',
        ),
        'mvc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/mvc',
        ),
        'config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/config',
        ),
    );

    public static $classMap = array (
        'config\\namespaces' => __DIR__ . '/../..' . '/config/namespaces.php',
        'config\\paths' => __DIR__ . '/../..' . '/config/paths.php',
        'mvc\\controllers\\Again\\Home' => __DIR__ . '/../..' . '/mvc/controllers/Again/Home.php',
        'mvc\\controllers\\Home' => __DIR__ . '/../..' . '/mvc/controllers/Home.php',
        'system\\Start' => __DIR__ . '/../..' . '/framework/janggelan/system/start.php',
        'system\\config\\Path' => __DIR__ . '/../..' . '/framework/janggelan/system/config/Path.php',
        'system\\core\\Controller' => __DIR__ . '/../..' . '/framework/janggelan/system/core/Controller.php',
        'system\\core\\Namespace' => __DIR__ . '/../..' . '/framework/janggelan/system/core/Namespace.php',
        'system\\core\\Request' => __DIR__ . '/../..' . '/framework/janggelan/system/core/Request.php',
        'system\\dragon_fire\\exception\\DragonHandler' => __DIR__ . '/../..' . '/framework/janggelan/system/dragon_fire/exception/DragonHandler.php',
        'system\\dragon_fire\\register\\NamespaceController' => __DIR__ . '/../..' . '/framework/janggelan/system/dragon_fire/register/NamespaceController.php',
        'system\\dragon_fire\\register\\RequestController' => __DIR__ . '/../..' . '/framework/janggelan/system/dragon_fire/register/RequestController.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite6d2fd568a827c02148b852cd150eb46::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite6d2fd568a827c02148b852cd150eb46::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite6d2fd568a827c02148b852cd150eb46::$classMap;

        }, null, ClassLoader::class);
    }
}