<?php namespace glob; trait paths { static function getPaths() { return [

    /*
    * Global paths.
    */
    'backend'    => __DIR__ . '/..',
    'root'       => __DIR__ . '/../..',
    'worksheet'  => __DIR__ . '/../../worksheet',
    'config'     => __DIR__ . '/../config',
    'controller' => __DIR__ . '/../../worksheet/controllers',
    'models'     => __DIR__ . '/../../worksheet/models',
    'view'       => __DIR__ . '/../../worksheet/views',
    'public'     => $_SERVER['DOCUMENT_ROOT'],

];}}
