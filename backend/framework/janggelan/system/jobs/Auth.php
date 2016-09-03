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
        $rule     = md5(base64_encode($ruleName));

        if(in_array($ruleName, $ruleKeys))
        {
            if($cookie === FALSE)
            {
                isset($_COOKIE[md5(base64_encode('_dateAndTime'))]) ? (isset($_COOKIE[md5(
                    $_COOKIE[md5(base64_encode('_dateAndTime'))] . $rule)]) ?
                    setcookie(md5($_COOKIE[md5(base64_encode('_dateAndTime'))] . $rule), '',
                    time() - 3600) : FALSE) : FALSE;
                $_SESSION[md5(base64_encode('_dateAndTime'))] = md5(base64_encode(date(
                    'Y-m-d' . ' __@__ ' . date('H:i:s'))));
                $_SESSION[md5($_SESSION[md5(base64_encode('_dateAndTime'))] . $rule)] = $value;
            }
            else
            {
                isset($_SESSION[md5(base64_encode('_dateAndTime'))]) ? (isset($_SESSION[md5(
                    $_SESSION[md5(base64_encode('_dateAndTime'))] . $rule)]) ?
                    session_unset(md5($_SESSION[md5(base64_encode('_dateAndTime'))] . $rule))
                    : FALSE) : FALSE;
                setcookie(md5(base64_encode('_dateAndTime')), md5(base64_encode(date(
                    'Y-m-d' . ' __@__ ' . date('H:i:s')))), time() + (86400 * 30), '/');
                setcookie(md5($_COOKIE[md5(base64_encode('_dateAndTime'))] . $rule),
                    $value, time() + (86400 * 30), '/');
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
        isset($_SESSION[md5(base64_encode('_dateAndTime'))]) ? ($indexSession =
            $_SESSION[md5(base64_encode('_dateAndTime'))]) : ($indexSession = FALSE);
        isset($_SESSION[md5(base64_encode('_dateAndTime'))]) ? (session_unset(
            md5(base64_encode('_dateAndTime')))) : FALSE;
        isset($_COOKIE[md5(base64_encode('_dateAndTime'))]) ? ($indexCookie =
            $_COOKIE[md5(base64_encode('_dateAndTime'))]) : ($indexCookie = FALSE);
        isset($_COOKIE[md5(base64_encode('_dateAndTime'))]) ? (setcookie(md5(
            base64_encode('_dateAndTime')), '', time() - 3600)) : FALSE;

        return $indexSession ? ((isset($_SESSION[md5($indexSession . md5(
            base64_encode($ruleName)))])) ? (session_unset(md5($indexSession .
            md5(base64_encode($ruleName))))) : FALSE) : ($indexCookie ? (isset(
            $_COOKIE[md5($indexCookie . md5(base64_encode($ruleName)))])
            ? setcookie(md5($indexCookie . md5( base64_encode($ruleName))), '',
            time() - 3600) : FALSE) : FALSE);
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

        return isset($_SESSION[md5(base64_encode('_dateAndTime'))]) ? ((isset(
            $_SESSION[md5($_SESSION[md5(base64_encode('_dateAndTime'))] .
            md5(base64_encode($ruleName)))])) ? ($_SESSION[md5($_SESSION[
            md5(base64_encode('_dateAndTime'))] . md5(base64_encode($ruleName)))])
            : FALSE) : (isset($_COOKIE[md5(base64_encode('_dateAndTime'))]) ?
            (isset($_COOKIE[md5($_COOKIE[md5(base64_encode('_dateAndTime'))] .
            md5(base64_encode($ruleName)))]) ? $_COOKIE[md5($_COOKIE[
            md5(base64_encode('_dateAndTime'))] . md5(base64_encode($ruleName)))]
            : FALSE) : FALSE);
    }
}
