<?php namespace tool;

/**
* A tool to validate form data such as 'username', 'password', etc.
*
* @author   Dali Kewara   <dalikewara@windowslive.com>
*/
class Validation
{
    /**
    * Full name validation.
    *
    * @param    string              $fullname
    * @return   string|bool(false)
    */
    public function fullName($fullName)
    {
        return preg_match('/[^a-zA-Z ]/', $fullName) ? FALSE : $fullName;
    }

    /**
    * Username validation.
    *
    * @param    string              $username
    * @return   string|bool(false)
    */
    public function username($username)
    {
        return preg_match('/[^a-zA-Z0-9@]/', $username) ? FALSE : $username;
    }

    /**
    * Email validation.
    *
    * @param    string              $email
    * @return   string|bool(false)
    */
    public function email($email)
    {
        return preg_match('/[a-zA-Z0-9]+[@][a-z]+[.][a-z]+/', $email) ? $email : FALSE;
    }

    /**
    * Password validation.
    *
    * @param    string              $password
    * @return   string|bool(false)
    */
    public function password($password)
    {
        return preg_match('/[^a-zA-Z0-9@]/i', $password) ? FALSE : $password;
    }

    /**
    * Title validation.
    *
    * @param    string              $title
    * @return   string|bool(false)
    */
    public function title($title)
    {
        return preg_match('/[^a-zA-Z0-9\!\s\.\,\(\)\[\]\*\&\%\$\#\@]+/i', $title) ? FALSE : $title;
    }
}
