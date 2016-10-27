<?php namespace framework\kernel\interfaces\database;

/*
* Showed what's should Database queries available in 'Model'.
*/
interface DBQuery
{
    /**
    * @param    string   $query
    * @return   $this
    */
    public function clause($query);

    /**
    * @param    int     $take
    * @param    int     $skip
    * @return   $this
    */
    public function range($take, $skip);

    /**
    * @param    string   $query
    * @return   mixed
    */
    public function exec($query);

    /**
    * @param    string   $query
    * @param    array    $bindParams
    * @return   mixed
    */
    public function execute($query, $bindParams);

    /**
    * @param    string   $column
    * @return   $this
    */
    public function select($column);

    /**
    * @param    array   $data
    * @return   $this
    */
    public function bindParams(array $data);

    /**
    * @param    array   $data
    * @return   $this
    */
    public function where(array $data);

    /**
    * @param    array   $data
    * @return   string
    */
    public function queryArray(array $data);
}
