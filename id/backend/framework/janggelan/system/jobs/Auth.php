<?php namespace system\jobs;

trait Auth
{
    /**
    ***************************************************************************
    * Mengecek nilai atau data "Rule"
    *
    * @param    string   $ruleName
    * @return   mixed
    *
    */
    public function CHECK_RULE($ruleName)
    {
        $auth = new \system\parents\Auth;

        return $auth->protected($ruleName, FALSE);
    }

    /**
    ***************************************************************************
    * Mengatur nilai "Rule"
    *
    * @param    string   $ruleName
    * @param    string   $value
    * @var      array    $data
    * @return   bool
    *
    */
    public function SET_RULE($ruleName, $value = '')
    {
        $auth     = new \system\parents\Auth;
        $data     = $auth->authConfig();
        $cookie   = $data['use_cookie'];
        $ruleKeys = array_keys($data['protected_rule']);
        $rule     = md5($ruleName);

        if(in_array($ruleName, $ruleKeys))
        {
            if($cookie === FALSE)
            {
                isset($_COOKIE[$rule]) ? setcookie($rule, '', time() - 3600) : FALSE;
                $_SESSION[$rule] = $value;
            }
            else
            {
                isset($_SESSION[$rule]) ? session_unset($rule) : FALSE;
                setcookie($rule, $value, time() + (86400 * 30), '/');
            }

            return TRUE;
        }

        return FALSE;
    }

    /**
    ***************************************************************************
    * Menghapus nilai atau data dari "Rule"
    *
    * @param    string   $ruleName
    * @return   mixed
    *
    */
    public function UNSET_RULE($ruleName)
    {
        $rule = md5($ruleName);

        return isset($_SESSION[$rule]) ?
               session_unset($rule) : (isset($_COOKIE[$rule]) ?
               setcookie($rule, '', time() - 3600) : FALSE);
    }

    /**
    ***************************************************************************
    * Mendapatkan nilai "Rule"
    *
    * @param    string   $ruleName
    * @return   mixed
    *
    */
    public function GET_RULE($ruleName)
    {
        $rule = md5($ruleName);

        return isset($_SESSION[$rule]) ?
               $_SESSION[$rule] : (isset($_COOKIE[$rule]) ?
               $_COOKIE[$rule] : FALSE);
    }
}
