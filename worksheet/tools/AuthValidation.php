<?php namespace mvc\tools;

/*
|--------------------------------------------------------------------------
| Universal Auth Validation
|--------------------------------------------------------------------------
|
| This class will help you to validate data from auth processes like
| password validation, email validation, etc.
|
| If needed, you can edit or add your own auth validation script.
|
*/
class AuthValidation
{
    /**
    * @author   Dali Kewara   <dalikewara@windowslive.com>
    */

    /**
    ***************************************************************************
    * Validate "Fullname" data.
    *
    * @param    string        $fullname
    * @return   string|bool   string if (valid)   bool if (invalid)
    *
    */
    public function fullnameValidation($fullname)
    {
        return !$fullname ? FALSE : (preg_match('/[^a-zA-Z ]/', $fullname)
            ? FALSE : $fullname);
    }

    /**
    ***************************************************************************
    * Validate "Username" data.
    *
    * @param    string        $username
    * @return   string|bool   string if (valid)   bool if (invalid)
    *
    */
    public function usernameValidation($username)
    {
        return !$username ? FALSE : (preg_match('/[^a-zA-Z0-9@]/', $username)
            ? FALSE : $username);
    }

    /**
    ***************************************************************************
    * Validate "Email" data.
    *
    * @param    string        $email
    * @return   string|bool   string if (valid)   bool if (invalid)
    *
    */
    public function emailValidation($email)
    {
        return !$email ? FALSE : (preg_match('/[a-zA-Z0-9]+[@][a-z]+[.][a-z]+/',
            $email) ? $email : FALSE);
    }

    /**
    ***************************************************************************
    * Validate "Password" data.
    *
    * @param    string        $password
    * @return   string|bool   string if (valid)   bool if (invalid)
    *
    */
    public function passwordValidation($password)
    {
        return !$password ? FALSE : (preg_match('/[^a-zA-Z0-9@]/i', $password)
            ? FALSE : $password);
    }
}
