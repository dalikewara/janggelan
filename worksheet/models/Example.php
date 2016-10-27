<?php namespace model;

/*
* This is the basic 'Model' style.
*/
class Example extends \framework\parents\Model
{
    // This is your table name. It is required by system.
    protected static $table = 'example';

    // This is your table columns. Only needed if you want to create new table into Database.
    protected static $columns = [
        'id'       => 'INT(11) AUTO_INCREMENT PRIMARY KEY',
        'username' => 'VARCHAR(255) NOT NULL',
        'password' => 'VARCHAR(255) NOT NULL'
    ];
}
