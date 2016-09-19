<?php namespace system\dragon_fire\controllers;

use system\dragon_fire\abstractions\request\Request;
use system\dragon_fire\interfaces\checker\Url as UrlChecker;
use system\dragon_fire\interfaces\checker\Controller as ControllerChecker;
use system\dragon_fire\interfaces\checker\Method as MethodChecker;
use system\dragon_fire\interfaces\support\Caller;
use system\dragon_fire\exceptions\DragonHandler;
use system\dragon_fire\artists\Message;

/*
||***************************************************************************||
|| Class untuk mengontrol dan mengendalikan setiap permintaan(Request)       ||
|| yang masuk.                                                               ||
||***************************************************************************||
||
*/
class RequestController extends Request implements Caller, UrlChecker, ControllerChecker, MethodChecker
{
    use \register\paths, \register\namespaces;

    private $messages;

    public function __construct()
    {
        $this->messages = new Message;
    }

    /**
    ***************************************************************************
    * Melakukan pemanggilan
    *
    * @param    array   $data
    * @return   $this
    *
    * @throws   \system\dragon_fire\exceptions\DragonHandler
    *
    */
    public function caller(array $data)
    {
        if(!is_array($data))
        {
            Throw new DragonHandler($this->messages->dataMustArray('Caller'));
        }

        extract($data);

        // Janggelan selalu melakukan pengecekan apakah sistem menggunakan
        // "protected_rule" atau tidak. Jika Anda menggunakan itu, Pengguna akan
        // otomatis dialihkan dari halaman tujuan apabila pengguna tidak memiliki
        // nilai atau data tokennya.
        if(is_string($protected) AND !is_bool($protected))
        {
            $check = new \system\parents\Auth;

            $check->protected($protected);
        }

        // Untuk pengguna yang lolos dari "protected_rule" akan diarahkan kembali
        // ke halaman tujuan. Mungkin beberapa "Request" dari pengguna akan mengirimkan
        // data-data. Data tersebut bisa ditangkap dengan index parameter di fungsi
        // pada "Controller"nya.
        if(!empty($dataArgs))
        {
            return call_user_func_array([$object, $method], $dataArgs);
        }
        else
        {
            return $object->$method([]);
        }
    }

    /**
    ***************************************************************************
    * Menangani proses data dan pemanggilan fungsi 'Caller'
    *
    * @param    string|array   $request
    * @param    array          $data
    * @return   mixed
    *
    */
    public function controller($request, array $data)
    {
        try
        {
            $url = explode('?', $_SERVER['REQUEST_URI'])[0];
            // Mengecek url
            $returnUrl = $this->urlChecker($url, $_SERVER['REQUEST_METHOD'], $data);
            $validUrl = $returnUrl[0];
            $dataArgs = $returnUrl[1];
            // Mengecek "protected_rule"
            $protected = end($data[$validUrl]);
            // Args
            $args = explode('|', $data[$validUrl][1]);

            if(preg_match('/view:/', reset($args)))
            {
                // Mengecek 'View'
                $view = explode(':', reset($args));
                $view = preg_replace('/[\n]/', '', end($view));

                new \system\parents\View($view, []);
            }
            else
            {
                // Mengecek 'Controller'
                $controller = explode(':', reset($args));
                $controller = end($controller);
                $object = $this->controllerChecker($this->getPath()['controller'],
                    $controller, $this->getNamespace()['controller']);
                // Mengecek 'Controller Method'
                $controllerMethod = explode(':', end($args));
                $controllerMethod = preg_replace('/[\n]/', '', end($controllerMethod));

                $this->methodChecker($object, $controllerMethod, $controller);

                // Memanggil Controller
                $callerData = [
                    'object' => $object, 'method' => $controllerMethod, 'dataArgs' => $dataArgs,
                    'protected' => $protected
                ];

                $this->caller($callerData);
            }
        }
        catch(DragonHandler $e)
        {
            die($e->getError());
        }
    }

    /**
    ***************************************************************************
    * Penanganan Pengecekan Url.
    * Fungsi ini akan mengecek apakah url yang diminta valid atau tidak.
    *
    * @param    string   $url
    * @param    string   $method
    * @param    array    $array
    * @return   array
    *
    * @throws   \system\dragon_fire\exceptions\DragonHandler
    *
    */
    public function urlChecker($url, $method, array $array)
    {
        // Cek nilai dari $array 'register/request.php'
        if(!is_array($array))
        {
            Throw new DragonHandler('Data permintaan (register/requests.php) harus berupa array!');
        }

        // Filter url
        if($url != '/')
        {
            $url = filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL);
        }

        // Deklarasi variabel pengecekan
        $x = 0;
        $finalUrl = '';
        $dataArgs = NULL;
        $urlData = array_values(array_filter(explode('/', $url)));
        $requestData = array_keys($array);

        // Proses pengecekan url dan data
        foreach($requestData as $data)
        {
            $totalRequest = $requestExplode = array_values(array_filter(explode('/', $data)));
            $requestCount = count($totalRequest);

            for($i = 0; $i < count($requestExplode); $i++)
            {
                if(preg_match('/[{][a-zA-Z0-9]*[}]/', $requestExplode[$i]))
                {
                    if(isset($urlData[$i]))
                    {
                        $getName[$x][$i] = rtrim(ltrim($requestExplode[$i], '{'), '}');
                        $getData[$x][$i] = $urlData[$i];
                    }

                    $requestExplode[$i] = NULL;
                }
            }

            $requestExplode = array_filter($requestExplode);
            $requestIndexesCompare = array_diff_assoc($requestExplode, $urlData);

            if((count($requestIndexesCompare) == 0) AND (count($urlData) == $requestCount))
            {
                for($i = 0; $i < count($totalRequest); $i++)
                {
                    if(isset($getName[$x][$i]))
                    {
                        $dataArgs[$i] = $getData[$x][$i];
                    }
                }

                $finalUrl = $data;
            }

            $x++;
        }

        // Pengecekan url tahap akhir
        !isset($array[$finalUrl]) ? ($this->generateRedirect('route',
            $this->messages->uriNotRegistered($url))) : TRUE;
        // Pengecekan Method dari Request
        ($method != $array[$finalUrl][0]) ? ($this->generateRedirect('requestMethod',
            $this->messages->methodRequestNotAllowed())) : TRUE;

        // Mengembalikan url yang valid dalam bentuk string
        return [$finalUrl, $dataArgs];
    }

    /**
    ***************************************************************************
    * Penanganan Pengecekan Controller/Class.
    * Fungsi ini akan mengecek apakah 'Controller/Class' yang diminta tersedia
    * atau tidak.
    *
    * @param    string             $path
    * @param    string             $name
    * @param    string             $namespace
    * @param    string             $protected
    * @return   string|namespace
    *
    * @throws   \system\dragon_fire\exceptions\DragonHandler
    *
    */
    public function controllerChecker($path, $name, $namespace, $protected = '')
    {
        !file_exists($path.'/'.str_replace('\\', '/', $name).'.php') ? (
            $this->generateRedirect('controller',
            $this->messages->controllerDoesntExists($protected, $name))) : TRUE;

        // Deklarasi variabel untuk pembuatan objek
        $object = $namespace.'\\'.$name;

        !class_exists($object) ? ($this->generateRedirect('controller',
            $this->messages->wrongController($protected, $namespace, $name))) : TRUE;

        // Mengembalikan nilai berupa objek dari Controller yang valid
        return new $object;
    }

    /**
    ***************************************************************************
    * Penanganan Pengecekan Controller/Class Method.
    * Fungsi ini akan mengecek apakah 'Controller/Class' yang diminta memiliki
    * method yang sesuai atau tidak.
    *
    * @param    object   $objectClass   Namespace\To\Class
    * @param    string   $method
    * @param    string   $className
    * @param    string   $protected
    * @return   mixed
    *
    * @throws   \system\dragon_fire\exceptions\DragonHandler
    *
    */
    public function methodChecker($objectClass, $method, $className, $protected = '')
    {
        !method_exists($objectClass, $method) ? ($this->generateRedirect('controller',
            $this->messages->methodDoesntExists($protected, $method, $className))) : TRUE;
    }

    /**
    ***************************************************************************
    * Penanganan Pengecekan Pengalihan.
    * Fungsi ini akan mengatur pengalihan jika terjadi data yang tidak valid.
    *
    * @param    string   $index
    * @param    string   $message
    * @return   mixed
    *
    * @throws   \system\dragon_fire\exceptions\DragonHandler
    *
    */
    public function generateRedirect($index, $message = '')
    {
        $config = require($this->getPath()['config'].'/request.php');
        $config = isset($config['redirect_on_false'][$index]) ?
            $config['redirect_on_false'][$index] : 'default';
        $throw = function() use($message)
        {
            Throw new DragonHandler($message);
        };

        ($config === 'default') ? $throw() : (header('location: '.$config));
        die;
    }
}
