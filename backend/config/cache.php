<?php return [

    /*
    |
    | Available configurations for some cache drivers. If you want to use cache systems
    | bellow, make sure you already setup and have the driver installation.
    |
    */
    'Memcache' => [
        // Format: host, port
        // To add multiple servers, create new array.
        // Example: server 1 = ['127.0.0.1', '11211'],
        //          server 2 = ['127.0.0.1', '11212']
        ['127.0.0.1', '11211'],
    ],
    'Memcached' => [
        // Format: host, port
        // To add multiple servers, create new array.
        // Example: server 1 = ['127.0.0.1', '11211'],
        //          server 2 = ['127.0.0.1', '11212']
        ['127.0.0.1', '11211'],
    ],
];
