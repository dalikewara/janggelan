<?php namespace framework\kernel\abstractions\artists;

/*
* The blueprint of 'Database' artist.
*/
abstract class Database
{
    /**
    * @return   mixed
    */
    abstract public function open();

    /**
    * @return   mixed
    */
    abstract public function create();

    /**
    * @param    array   $data
    * @return   mixed
    */
    abstract public function insert(array $data);

    /**
    * @param    array   $data
    * @param    array   $selectors
    * @return   mixed
    */
    abstract public function update(array $data, array $selectors);

    /**
    * @param    array   $selectors
    * @return   mixed
    */
    abstract public function delete(array $selectors);

    /**
    * @param    int     $take
    * @return   mixed
    */
    abstract public function get($take = FALSE);

    /**
    * @return   mixed
    */
    abstract public function close();
}
