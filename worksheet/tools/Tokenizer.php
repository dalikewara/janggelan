<?php namespace mvc\tools;

/*
|--------------------------------------------------------------------------
| Universal Tokenizer
|--------------------------------------------------------------------------
|
| This class will help you to generating dan processed tokenizer system.
|
| If needed, you can edit or add your own tokenizer script.
|
|
*/
class Tokenizer
{
    /**
    * @author   Dali Kewara   <dalikewara@windowslive.com>
    */

    /**
    ***************************************************************************
    * Generate a new random token.
    *
    * @param    string   $value
    * @return   string
    *
    */
    public function generateToken($value)
    {
        return md5(base64_encode(openssl_random_pseudo_bytes(32) . $value));
    }

    /**
    ***************************************************************************
    * Compare beetwen two tokens to check is it a same tokens or not.
    *
    * @param    string   $token1
    * @param    string   $token2
    * @return   bool
    *
    */
    public function checkToken($token1, $token2)
    {
        return ($token1 === $token2) ? TRUE : FALSE;
    }

    /**
    ***************************************************************************
    * Check and validate token from request ($_POST/$_GET)
    *
    * @param    string   $token
    * @param    string   $index
    * @param    string   $method
    * @return   bool
    *
    */
    public function checkTokenFromRequest($token, $index = 'token', $method = 'POST')
    {
        return (isset($token) && !empty($token)) ? (($method === 'POST') ?
            (isset($_POST[$index]) ? (($_POST[$index] === $token) ? TRUE : FALSE)
            : FALSE) : ((isset($_GET[$index]) ? (($_GET[$index] === $token) ? TRUE
            : FALSE) : FALSE))) : FALSE;
    }

    /**
    ***************************************************************************
    * Get token from Database
    *
    * @param    object        $modelObject
    * @param    string        $columnName
    * @param    bool          $clause
    * @return   string|bool   string if token found   bool(FALSE) if token doesn't exists
    *
    */
    public function getTokenFromDB($modelObject, $columnName, $clause = FALSE)
    {
        return is_object($modelObject) ? (is_string($columnName) ? ($clause ? (
            $modelObject->Select($columnName)->Clause($clause)->Range(1)->Result()[0])
            : ($modelObject->Select($columnName)->Range(1)->Result()[0])) : FALSE)
            : FALSE;
    }
}
