<?php namespace mvc\tools;

/*
|--------------------------------------------------------------------------
| Universal SQL Generator
|--------------------------------------------------------------------------
|
| This class will help you to get a string of the query functions from different
| Databases.
|
| If needed, you can edit or add your own SQL generator script.
|
*/
class SQLGenerator extends \system\parents\Controller
{
    /**
    * @author   Dali Kewara   <dalikewara@windowslive.com>
    */

    // This variable is indicated what kind of Database connection
    // you are using now.
    private $connection;

    public function __construct()
    {
        // Get connection name
        $this->connection = Parent::GET_CONNECTION();
    }

    /**
    ***************************************************************************
    * WHERE
    *
    * $user->where('username', '=', 'linus');
    * output mysql: WHERE username='linus'
    *
    * @param    string           $column
    * @param    string           $operator
    * @param    string|integer   $value
    * @param    string           $type
    * @return   string
    */
    public function where($column, $value, $operator = '=', $type = 'WHERE')
    {
        $value = is_string($value) ? ((preg_match('/^[:]/', $value)) ? $value :
            "'" . $value . "'") : $value ;

        switch($this->connection)
        {
            // Default is 'mysql'
            default:
                return "{$type} {$column}{$operator}{$value} ";
                break;
        }
    }

    /**
    ***************************************************************************
    * SINGLE WHERE
    *
    * $user->singleWhere("username='linus' || city='surabaya' && status=1");
    * output mysql: WHERE username='linus' OR city='surabaya' AND status=1
    *
    * @param    string   $clause
    * @return   string
    */
    public function singleWhere($clause)
    {
        $clause = str_replace('&&', 'AND', str_replace('||', 'OR', $clause));

        switch($this->connection)
        {
            // Default is 'mysql'
            default:
                return "WHERE {$clause} ";
                break;
        }
    }

    /**
    ***************************************************************************
    * WHERE IN
    *
    * $user->whereIn('username', ['linus', 'stallman', 'gosling']);
    * output mysql: WHERE username IN ('linus', 'stallman', 'gosling')
    *
    * @param    string   $column
    * @param    array    $value
    * @return   string
    */
    public function whereIn($column, array $value)
    {
        if(empty($value))
        {
            return FALSE;
        }

        $value = implode(', ', array_map(function($a)
            {return is_string($a) ? ("'" . $a . "'") : (is_int($a) ?
            $a : FALSE);}, $value));

        switch($this->connection)
        {
            // Default is 'mysql'
            default:
                return "WHERE {$column} IN ({$value}) ";
                break;
        }
    }

    /**
    ***************************************************************************
    * ORDER BY
    *
    * $user->orderBy('id', 'DESC');
    * output mysql: ORDER BY id DESC
    *
    * @param    string   $order
    * @param    string   $by
    * @return   string
    */
    public function orderBy($by = 'id', $order = 'ASC')
    {
        switch($this->connection)
        {
            // Default is 'mysql'
            default:
                return "ORDER BY $by $order ";
                break;
        }
    }
}
