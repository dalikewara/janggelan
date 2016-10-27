<?php namespace tool;

/**
* A tool to generate token data.
*
* @author   Dali Kewara   <dalikewara@windowslive.com>
*/
class Tokenizer
{
    /**
    * Generate new token.
    *
    * @param    string   $value
    * @return   string
    */
    public function generate($value)
    {
        return md5(base64_encode(openssl_random_pseudo_bytes(32) . $value));
    }

    /**
    * Compare beetwen two tokens.
    *
    * @param    string   $token1
    * @param    string   $token2
    * @return   bool
    */
    public function compare($token1, $token2)
    {
        return ($token1 === $token2) ? TRUE : FALSE;
    }

    /**
    * Check and validate token from request ($_POST/$_GET).
    *
    * @param    string   $token
    * @param    string   $index
    * @param    string   $method
    * @return   bool
    */
    public function checkFromRequest($token, $index = 'token', $method = 'POST')
    {
        return (isset($token) && !empty($token)) ? (($method === 'POST') ?
            (isset($_POST[$index]) ? (($_POST[$index] === $token) ? TRUE : FALSE)
            : FALSE) : ((isset($_GET[$index]) ? (($_GET[$index] === $token) ? TRUE
            : FALSE) : FALSE))) : FALSE;
    }

    /**
    * Get token from Database.
    *
    * @param    object        $model
    * @param    string        $column
    * @param    bool          $clause
    * @return   string|bool
    */
    public function getFromDB($model, $column, $clause = FALSE)
    {
        if(!is_object($model))
        {
            $namespace = 'model\\' . $model;
            $model = new $namespace;
        }

        return is_string($column) ? ($clause ? ($model->select($column)->clause(
            $clause)->get(1)) : ($model->select($column)->get(1))) : FALSE;
    }
}
