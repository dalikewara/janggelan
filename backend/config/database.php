<?php return [

    /*
    | Setting for Database auto connection.
    | Default is TRUE.
    | If you don't want system opening Database connection automatically when
    | you use a Model to communicate with Database, set it to FALSE. Then, you
    | have to open the connection manually when you want to connect to Database.
    | You can do it with this method: $model->open() or $model->close() to
    | close the connection.
    */
    'auto_connect' => TRUE,

    /*
    | Setting for default Database connection that will be used by system.
    | Default is 'mysql'.
    | You can change the value with other (supported) database connections.
    */
    'default_connection' => 'mysql',

    /*
    | Setting for default PDO fetch style that will be used by system.
    | Default is PDO::FETCH_CLASS.
    | You can change the value according to style that you want.
    */
    'pdo_fetch_style' => PDO::FETCH_CLASS,

    /*
    | List of supported Database connections that worked in Janggelan.
    */
    'connections' => [
        // The following properties bellow are configured automatically.
        // You should don't change anything.

        'mysql' => [
            'DB_HOST'     => $this->db('DB_HOST'),
            'DB_NAME'     => $this->db('DB_NAME'),
            'DB_USERNAME' => $this->db('DB_USERNAME'),
            'DB_PASSWORD' => $this->db('DB_PASSWORD')
        ],
    ],

];
