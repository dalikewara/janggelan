<?php namespace framework\parents;

use framework\kernel\artists\Database as Artist;

/*
* Class for base 'Model'.
*/
class Model extends Artist
{
    /* Database Artist variable requirements. */

    // The default for query 'SELECT' is *, with means it will selected all
    // columns from table. The value can be reset on Database Artist's chainable.
    protected $select = '*';

    // $range variable will isset with number, because it will be used for indetify number of range
    // on query result.
    protected $range = '';

    // This variable will contains every query string data.
    protected $clause = '';

    // This variable usage is to set Bind Param data to PDO while user wants to send their data
    // with included bindParam(). Sending data with bindParam() actually have advantages in security.
    protected $params = [];
}
