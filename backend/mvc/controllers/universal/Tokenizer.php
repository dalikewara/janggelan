<?php namespace mvc\controllers\universal;

/*
|--------------------------------------------------------------------------
| Universal Tokenizer (Optional)
|--------------------------------------------------------------------------
|
| Class ini akan membantu Anda untuk melakukan pembuatan dan pemrosesan Tokenizer.
|
| Jika diperlukan, Anda bisa mengedit atau menambahkan script Tokenizer
| Anda sendiri sesuai dengan kebutuhan.
|
*/
class Tokenizer
{
    /**
    * @author   Dali Kewara   <dalikewara@windowslive.com>
    */

    public function generateToken($value)
    {
        return md5(base64_encode(openssl_random_pseudo_bytes(32) . $value));
    }

    public function checkToken($token1, $token2)
    {
        return ($token1 === $token2) ? TRUE : FALSE;
    }

    public function checkTokenFromRequest($token, $index = 'token', $method = 'POST')
    {
        return (isset($token) && !empty($token)) ? (($method === 'POST') ?
            (isset($_POST[$index]) ? (($_POST[$index] === $token) ? TRUE : FALSE)
            : FALSE) : ((isset($_GET[$index]) ? (($_GET[$index] === $token) ? TRUE
            : FALSE) : FALSE))) : FALSE;
    }

    public function getTokenFromDB($modelObject, $columnName, $clause = FALSE)
    {
        return is_object($modelObject) ? (is_string($columnName) ? ($clause ? (
            $modelObject->Select($columnName)->Clause($clause)->Range(1)->Result()[0])
            : ($modelObject->Select($columnName)->Range(1)->Result()[0])) : FALSE)
            : FALSE;
    }

    public function setTokenSession($session = '_token')
    {

    }

    public function setTokenCookie($cookie = '_cookie')
    {

    }

    public function getTokenSession($session = '_token')
    {

    }

    public function getTokenCookie($cookie = '_cookie')
    {

    }

    public function unsetTokenSession()
    {

    }

    public function unsetTokenCookie()
    {

    }
}
