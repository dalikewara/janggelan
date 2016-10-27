<?php namespace framework\kernel\controllers;

use framework\kernel\abstractions\controllers\DBPropertyController as Blueprint;

/*
* Class to controll Database properties.
*/
class DBPropertyController extends Blueprint
{
    // Using global paths.
    use \glob\paths;

    // The following variables have access for global scope.
    // On the Database Artist they are needed.
    public $conn, $autoConn, $host, $db, $username, $pdoFetch;

    // The following variables have access in this class only.
    private static $data, $env;

    function __construct()
    {
        // Prepared variables.
        self::$env = json_decode(file_get_contents($this->getPaths()['backend'] . '/.secrets/.db'));
        self::$data = require $this->getPaths()['config'] . '/database.php';
        $this->autoConn = self::$data['auto_connect'];
        $this->conn = self::$data['default_connection'];
        $this->pdoFetch = self::$data['pdo_fetch_style'];
        $this->host = self::$data['connections'][$this->conn]['DB_HOST'];
        $this->db = self::$data['connections'][$this->conn]['DB_NAME'];
        $this->username = self::$data['connections'][$this->conn]['DB_USERNAME'];
    }

    /**
    * This function/method usage is to generate PDO connect property.
    *
    * @return   object
    */
    public function connect()
    {
        return new \PDO($this->conn . ':host=' . $this->host . ';dbname=' .
            $this->db, $this->username, self::$data['connections'][$this->conn]['DB_PASSWORD']);
    }

    /**
    * This function/method usage is to get Database property from './secrets/.db'
    *
    * @param    string   $selector
    * @return   string
    */
    protected function db($selector)
    {
        return self::$env->$selector;
    }
}
