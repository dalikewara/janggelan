<?php namespace mvc\controllers\universal;

/*
|--------------------------------------------------------------------------
| Universal Auth Validation (Optional)
|--------------------------------------------------------------------------
|
| Class ini akan membantu Anda untuk melakukan validasi data dari proses Auth,
| misalnya memvalidasi sandi, email, username, dan lain-lain.
|
| Jika diperlukan, Anda bisa mengedit atau menambahkan script Auth Validation
| Anda sendiri sesuai kebutuhan.
|
*/
class AuthValidation
{
    /**
    * @author   Dali Kewara   <dalikewara@windowslive.com>
    */

    public function fullnameValidation($fullname)
    {
        return !$fullname ? FALSE : (preg_match('/[^a-zA-Z ]/', $fullname)
            ? FALSE : $fullname);
    }

    public function usernameValidation($username)
    {
        return !$username ? FALSE : (preg_match('/[^a-zA-Z0-9@]/', $username)
            ? FALSE : $username);
    }

    public function emailValidation($email)
    {
        return !$email ? FALSE : (preg_match('/[a-zA-Z0-9]+[@][a-z]+[.][a-z]+/',
            $email) ? $email : FALSE);
    }

    public function passwordValidation($password)
    {
        return !$password ? FALSE : (preg_match('/[^a-zA-Z0-9@]/i', $password)
            ? FALSE : $password);
    }
}
