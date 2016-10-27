<?php namespace framework\kernel\artists;

use framework\kernel\abstractions\artists\Database as Blueprint;
use framework\kernel\interfaces\database\DBQuery;
use framework\kernel\controllers\DBPropertyController as DBProperty;

/*
* Class to handle 'Model' artist.
*/
class Database extends Blueprint implements DBQuery
{
    // This indicate global Database active connection that runs in the runtime.
    protected static $open;

    // This indicate global private Database properties that runs in the runtime.
    public static $property;

    // The following variables have access in this class only.
    private $keys, $query, $num = 0;

    function __construct()
    {
        // Prepared variables.
        self::$property = new DBProperty;
        $this->keys = array_keys(static::$columns);
    }

    /**
    * Auto close Database connection at the end of file.
    *
    * @return   mixed
    */
    function __destruct()
    {
        static::$open = null;
    }

    /**
    * This is for set all global requirements variable to their default value.
    *
    * @return   mixed
    */
    private function clean()
    {
        $this->query = '';
        $this->num = 0;
        $this->params = [];
        $this->clause = '';
        $this->range = '';
        $this->select = '*';
    }

    /**
    * Initialize Database connection.
    *
    * @param    function   $handler
    * @param    bool       $return
    * @return   mixed
    */
    private function init($handler, $return = FALSE)
    {
        // Open connection. This will works if auto_connect is TRUE.
        $this->open(FALSE);

        // Run the handler.
        if($return)
        {
            // Generating data.
            $data = $handler();

            // Close connection. This will works if auto_connect is TRUE.
            $this->close(FALSE);
            // Clean global variable.
            $this->clean();

            // Return the data.
            return $data;
        }

        // Process the handler.
        $handler();
        // Close connection. This will works if auto_connect is TRUE.
        $this->close(FALSE);
        // Clean global variable.
        $this->clean();
    }

    /* Blueprint */

    /**
    * This method is used by system to opens Database connection.
    * User must calls this method manually to connect to Database if the user
    * set auto_connect to FALSE.
    *
    * @return   mixed
    */
    public function open($manual = TRUE)
    {
        // If global Database active connection is null or unset before, it will set here.
        // Because system using static property, so this checker will not runs once again,
        // except if that global varible has been destroyed.
        if(is_null(static::$open))
        {
            // Initialize connection.
            $connect = function()
            {
                try
                {
                    // Open connection.
                    static::$open = self::$property->connect();

                    // Auto set PDO Exception attributes.
                    static::$open->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                }
                catch(\PDOException $e)
                {
                    die('Connection failed! '.$e->getMessage().'<br>'.$e->getLine());
                }
            };

            // Checking for auto_connect config.
            if(self::$property->autoConn)
            {
                // Run connection.
                $connect();
            }
            else
            {
                // If user open the connection as manual.
                if($manual)
                {
                    // Run connection.
                    $connect();
                }
            }
        }
    }

    /**
    * The usage of this method is to creates new table into Database.
    *
    * @return   mixed
    */
    public function create()
    {
        // Run the process inside init() for efficiency.
        $this->init(function()
        {
            // Generating query data.
            foreach(static::$columns as $value)
            {
                $this->query .= ' ' . $this->keys[$this->num] . ' ' . $value . ',';

                $this->num++;
            }

            // Execute the query.
            static::$open->exec('CREATE TABLE IF NOT EXISTS ' . static::$table .
                ' (' . rtrim($this->query, ',') . ')');
        });
    }

    /**
    * The usage of this method is to inserts new data into Database.
    *
    * @param    array   $data
    * @return   mixed
    */
    public function insert(array $data)
    {
        // Run the process inside init() for efficiency.
        $this->init(function() use ($data)
        {
            // Generating query data.
            $columns = implode(', ', array_keys($data));
            $values = implode(', ', array_keys(array_combine(array_map(
                function($a){ return ':' . $a; },array_keys($data)), array_values($data))));
            $init = static::$open->prepare('INSERT INTO ' . static::$table . ' (' .
                $columns . ') VALUES (' . $values . ')');

            // Execute the query.
            $init->execute($data);
        });
    }

    /**
    * The usage of this method is to updates data in Database.
    *
    * @param    array   $data
    * @param    array   $selectors
    * @return   mixed
    */
    public function update(array $data, array $selectors)
    {
        // Run the process inside init() for efficiency.
        $this->init(function() use ($data, $selectors)
        {
            // Generating query data.
            $paramValue = array_combine(array_map(function($a){ return $a . 'data'; },
                array_keys($data)), array_values($data));
            $paramClause = array_combine(array_map(function($a){ return $a . 'selector'; },
                array_keys($selectors)), array_values($selectors));
            $data = array_combine(array_map(function($a){ return $a . '=:' . $a . 'data'; },
                array_keys($data)), array_values($data));
            $selectors = array_combine(array_map(function($a){ return $a . '=:' . $a . 'selector'; },
                array_keys($selectors)), array_values($selectors));
            $prepareData = implode(', ', array_keys($data));
            $prepareSelectors = implode(' AND ', array_keys($selectors));
            $bindParams = array_merge($paramValue, $paramClause);
            $init = static::$open->prepare('UPDATE ' . static::$table . ' SET ' .
                $prepareData . ' WHERE ' . $prepareSelectors);

            // Execute the query.
            $init->execute($bindParams);
        });
    }

    /**
    * The usage of this method is to deletes data in Database.
    *
    * @param    array   $selectors
    * @return   mixed
    */
    public function delete(array $selectors = [])
    {
        // Run the process inside init() for efficiency.
        $this->init(function() use ($selectors)
        {
            if(!empty($selectors))
            {
                // Prepared query data.
                $init = static::$open->prepare('DELETE FROM '. static::$table . ' WHERE ' .
                    $this->queryArray($selectors));

                // Execute the query.
                $init->execute($selectors);
            }
            else
            {
                // Execute the query.
                static::$open->exec('DELETE FROM ' . static::$table);
            }
        });
    }

    /**
    * This function/method usage is to get all data of Model.
    *
    * @param    int     $take
    * @return   mixed
    */
    public function get($take = FALSE)
    {
        // Check if this method has a limit to showed the data.
        if($take AND is_numeric($take))
        {
            $this->range($take, 0);
        }

        // Run the process inside init() for efficiency.
        return $this->init(function()
        {
            // Prepared variables.
            $data = null;
            // Set database query.
            $query = 'SELECT ' . $this->select . ' FROM ' . static::$table . ' ' .
                $this->clause . ' ' . $this->range;

            // Cheking for prepared statement.
            // If the query 'CLAUSE' contains character ':', then system will assume it
            // uses PDO prepare statement. So, user must chaining bindParam() method to
            // set that Bind Param data.
            if(preg_match('/[:][a-zA-Z0-9]*/', $this->clause))
            {
                $init = static::$open->prepare($query);

                $init->execute($this->params);
            }
            else
            {
                $init = static::$open->query($query);
            }

            // Checking for PDO fetch style.
            // Default style in Janggelan is PDO::FETCH_CLASS.
            if(self::$property->pdoFetch === \PDO::FETCH_CLASS)
            {
                $data = $init->fetchAll(self::$property->pdoFetch, 'framework\parents\Foo');
            }
            else
            {
                $data = $init->fetchAll(self::$property->pdoFetch);
            }

            return ($init->rowCount() > 0) ? $data : array();
        }, TRUE);
    }

    /**
    * This function/method usage is to close Database connection. Only needed
    * if 'auto_connect' config is 'FALSE'.
    *
    * @return   mixed
    */
    public function close($manual = TRUE)
    {
        if(!$manual)
        {
            if(self::$property->autoConn)
            {
                static::$open = null;
            }
        }
        else
        {
            static::$open = null;
        }
    }

    /* DBQuery */

    /**
    * @param    string   $query
    * @return   $this
    */
    public function clause($query)
    {
        // Set new data of query 'CLAUSE'.
        $this->clause .= is_string($query) ? $query : '';

        return $this;
    }

    /**
    * @param    int     $take
    * @param    int     $skip
    * @return   $this
    */
    public function range($take, $skip)
    {
        // Set new data of query 'RANGE'.
        $take = is_numeric($take) ? $take : 0;
        $skip = is_numeric($skip) ? $skip : 0;
        $this->range = 'LIMIT ' . $take . ' OFFSET ' . $skip;

        return $this;
    }

    /**
    * @param    string   $query
    * @return   mixed
    */
    public function exec($query)
    {
        // Run the process inside init() for efficiency.
        $this->init(function() use ($query)
        {
            // Exec the query.
            static::$open->exec($query);
        });
    }

    /**
    * @param    string   $query
    * @param    array    $bindParams
    * @return   mixed
    */
    public function execute($query, $bindParams)
    {
        // Run the process inside init() for efficiency.
        $this->init(function() use ($query, $bindParams)
        {
            // prepared query data.
            $this->query = static::$open->prepare($query);
            // Execute the query.
            $this->query->execute($bindParams);
        });
    }

    /**
    * @param    string   $column
    * @return   $this
    */
    public function select($column)
    {
        // Set new data of query 'SELECT'.
        $this->select = is_string($column) ? $column : '*';

        return $this;
    }

    /**
    * @param    array   $data
    * @return   $this
    */
    public function bindParams(array $data)
    {
        // Set new Bind Param data.
        $this->params = $data;

        return $this;
    }

    /**
    * @param    array   $data
    * @return   $this
    */
    public function where(array $data)
    {
        // Set new data of query clause 'WHERE'.
        $this->clause .= ' WHERE ' . $this->queryArray($data);

        return $this;
    }

    /**
    * @param    array   $data
    * @return   string
    */
    public function queryArray(array $data)
    {
        $this->query = implode(' AND ', array_keys(array_combine(array_map(
            function($a){ return $a . '=:' . $a; }, array_keys($data)),
            array_values($data))));
        $this->params = $data;

        return $this->query;
    }
}
