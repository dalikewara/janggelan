<?php namespace framework\kernel\jobs\traits\support;

/*
* The built in 'Protected Rule' class.
*/
trait ProtectedRule
{
    // Use global paths.
    use \glob\paths;

    /**
    * This method/function used to check 'Protected Rule' data.
    *
    * @param    string   $name
    * @return   bool
    */
    public function CHECK_RULE($name)
    {
        // Initialize Protected Controller object.
        $protected = new \framework\kernel\controllers\ProtectedController;

        // Call the handler.
        return $protected->handler($name, TRUE);
    }

    /**
    * This method/function used to set new 'Protected Rule' data.
    *
    * @param    string   $name
    * @param    string   $value
    * @var      array    $data
    * @return   bool
    */
    public function SET_RULE($name, $value = '')
    {
        // Prepared variables.
        $data = require $this->getPaths()['config'] . '/protected.php';
        $keys = array_keys($data['protected_rule']);

        try
        {
            // Check for valid 'Protected Rule' name.
            if(!in_array($name, $keys))
            {
                Throw new \framework\kernel\exceptions\KernelHandler(
                    \framework\parents\Message::protectedDoesntExist($name));
            }

            // Generate rule name.
            $rule = md5(base64_encode($name));

            // Process to generate new 'Protected Rule' data.
            if($data['use_cookie'] === FALSE)
            {
                // If using SESSION.
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
                // If using COOKIE.
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
        catch(\framework\kernel\exceptions\KernelHandler $e)
        {
            // Die program on unwanted condition.
            die($e->err());
        }
    }

    /**
    * This method/function used to delete 'Protected Rule' data.
    *
    * @param    string   $name
    * @return   mixed
    */
    public function DESTROY_RULE($name)
    {
        // Check for valid 'Protected Rule' data.
        isset($_SESSION[md5(base64_encode('_dateAndTime'))]) ? ($indexSession =
            $_SESSION[md5(base64_encode('_dateAndTime'))]) : ($indexSession = FALSE);
        isset($_SESSION[md5(base64_encode('_dateAndTime'))]) ? (session_unset(
            md5(base64_encode('_dateAndTime')))) : FALSE;
        isset($_COOKIE[md5(base64_encode('_dateAndTime'))]) ? ($indexCookie =
            $_COOKIE[md5(base64_encode('_dateAndTime'))]) : ($indexCookie = FALSE);
        isset($_COOKIE[md5(base64_encode('_dateAndTime'))]) ? (setcookie(md5(
            base64_encode('_dateAndTime')), '', time() - 3600)) : FALSE;

        // Process to delete the data.
        return $indexSession ? ((isset($_SESSION[md5($indexSession . md5(
            base64_encode($name)))])) ? (session_unset(md5($indexSession .
            md5(base64_encode($name))))) : FALSE) : ($indexCookie ? (isset(
            $_COOKIE[md5($indexCookie . md5(base64_encode($name)))])
            ? setcookie(md5($indexCookie . md5( base64_encode($name))), '',
            time() - 3600) : FALSE) : FALSE);
    }

    /**
    * This method/function used to get 'Protected Rule' data.
    *
    * @param    string   $name
    * @return   mixed
    */
    public function GET_RULE($name)
    {
        // Process to get 'Protected Rule' data.
        return isset($_SESSION[md5(base64_encode('_dateAndTime'))]) ? ((isset(
            $_SESSION[md5($_SESSION[md5(base64_encode('_dateAndTime'))] .
            md5(base64_encode($name)))])) ? ($_SESSION[md5($_SESSION[
            md5(base64_encode('_dateAndTime'))] . md5(base64_encode($name)))])
            : FALSE) : (isset($_COOKIE[md5(base64_encode('_dateAndTime'))]) ?
            (isset($_COOKIE[md5($_COOKIE[md5(base64_encode('_dateAndTime'))] .
            md5(base64_encode($name)))]) ? $_COOKIE[md5($_COOKIE[
            md5(base64_encode('_dateAndTime'))] . md5(base64_encode($name)))]
            : FALSE) : FALSE);
    }
}
