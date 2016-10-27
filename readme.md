[![license](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](https://github.com/dalikewara/janggelan/license.txt)

# Introduction

Janggelan is an unexpected PHP framework that gives you ease. It's simple, yet powerful, and pleasurable to use. Just like other frameworks, you won't get difficulty when trying to understanding Janggelan.

Janggelan is designed and focus based on MVC concept. So, we attempt to avoid merging MVC system with other tools that may help you in development, because it can reduce the performance. We keep enclose it of course, to help your development, but it will come with different covers.

Please read the documentation for more information.

*We know we cannot finish this framework perfectly, and maybe didn't correspond with what you want. But, we always trying to finish it better and make it unexpected for you. You can contributing with us.*


### Log notes (0.0.2 Z Rev 6)

- Added some new tools.

- Rewritten all Janggelan's scripts for new better performance.

- Reduce some server loads.

- Added some new `Model` methods: `where()`, `exec()`, `execute()`.

- Added documentation.

- Used caching and compression `gZip` on `.htaccess`.


### System requirements

- PHP 7

- PDO PHP Extension


### How To Install

- Download Janggelan's file, extract it to your application's directory.

- If you want to publish or install Janggelan for shared hosting, the safest way to do is placed Janggelan's files and directories inside of `server root`, and moved all contents of the `public` folder into `public_html` or `www`.

- You will run your application from `public` / `public_html` / `www` directory.

- If you found problems after installation, please check the file permissions.


### Documentation

    __ backend/
          |__ .secrets/
          |__ config/
          |__ framework/
          |__ global/
          |__ register/
          |__ vendor/
          |__ autoload.php
          |__ composer.json
          |__ force.uri
    __ public/
          |__ assets/
          |__ .htaccess
          |__ index.php
    __ worksheet/
          |__ controllers/
          |__ model/
          |__ providers/
          |__ tools/
          |__ views/
          |__ requests.php

- #### Getting started.
  At the first time, lets run Janggelan in your server. Make sure your system has done with the `System Requirements` and the `installation` above.

  Go to your application directory that Janggelan files placed. Enter to `public` folder. As example, in Linux, you can done with this:

    ```bash
    cd /var/www/html/your_application/public
    ```

  Open a localhost server:

    ```bash
    php -S localhost:8000
    ```

  Or you can do above directly with this command:

    ```bash
    php -S localhost:8000 -t /var/www/html/your_application/public
    ```

  Now, open your browser, and visit localhost:8000.


- #### Creating new request.
  In Janggelan you'll call this as `requests`. In other PHP frameworks such as Laravel, this called as `routes`.
  Every requests in Janggelan handled on file `worksheet/requests.php`. To create a new request, go to that file. There you'll see a `request` example like this:

    ```php
    $this->request('GET / @Hello::world');
    ```

  The example above has mean: "Request uri `/` with request method `GET`. If user visiting `/` and the uri is valid, it will be redirected and proceed to Controller `Hello` with method/function `world`". Based on the example, now you can create your custom requests with these options: (argument or parameter 1 is separated by `space`):

    ```php
    // Redirected to Controller.
    // Request method can be 'GET' or 'POST'
    $this->request('GET /home @Hello::world');

    // Redirected to View.
    $this->request('GET /home (viewName)');

    // Redirected to Controller with Protected Rule 'login'.
    $this->request('GET /home @Hello::world !!login');

    // Redirected to View with Protected Rule 'login'.
    $this->request('GET /home (viewName) !!login');

    // Will proceed the Closure or Callback directly.
    $this->request('GET /home', function()
    {
        // Do some stuff...
    });

    // Will proceed the Closure or Callback directly with Protected Rule 'login'.
    $this->request('GET /home !!login', function()
    {
        // Do some stuff...
    });
    ```

  You will learn more about `Protected Rule` later. Note, use `Closure` or `Callback` only when you are in testing. We always recommended to use `View` or `Controller` as a redirecting.


- #### Creating controller.
  `Controller`s are placed in `worksheet/controllers`. Try to create a new `Controller` with creating a new file, assume the file name is `MyController.php`. Then, in the `MyController.php`, write this basic `Controller` style:

    ```php
    <?php namespace controller;

    class MyController extends \framework\parents\Controller
    {
        public function welcome()
        {
            echo 'Welcome to my Controller.';
        }
    }
    ```

  On the `worksheet/requests.php`, add new request that will proceed the `Controller`.

    ```php
    $this->request('GET /test @MyController::welcome');
    ```

  Now, visit `/test` on your browser. If everything is ok, you'll see output: `Welcome to my Controller.`.
  The `Controller` file name must be same and matched with the `Controller` class name. Also, you have to take care about `Namespace`. If you create controller inside new directory like this:

      __ controllers/
            |__ my_new_folder/
                   |__ MyController.php

  Then, the `Namespace` of your `Controller` should be like this: (this also applies for all namespaces system)

    ```php
    <?php namespace controllers\my_new_folder;

    class MyController extends \framework\parents\Controller
    {
        //
    }
    ```

  You can avoid to extend `\framework\parents\Controller` if your `Controller` doesn't needed to uses some built in functions such as `$this->LOAD_VIEW()`, `$this->GET_RULE()`, etc.


- #### Creating model.
  `Model`s are placed in `worksheet/models`. `Model` is used to communicating with Database. So, when you create a `Model`, make sure it is corresponding with you data in Database. To can using `Model` you must set up your Database configuration in `backend/.secrets/.db` or see the documentation about `Configuring Database`.

  After above is done, lets try to creating a `Model`. First, create a new file in `worksheet/models`. Assume the file name is `User.php`. Then, write the file's content with this basic `Model` style:

    ```php
    <?php namespace model;

    class User extends \framework\parents\Model
    {
        // This is your table name. It is required by system.
        protected static $table = 'user';

        // This is your table columns. Only required if you want to create new
        // table into Database.
        protected static $columns = [
            'id'       => 'INT(11) AUTO_INCREMENT PRIMARY KEY',
            'username' => 'VARCHAR(255) NOT NULL',
            'password' => 'VARCHAR(255) NOT NULL'
        ];
    }
    ```

  In your `Controller`, call the `Model` class:

    ```php
    <?php namespace controller;

    use model\User;

    class MyController extends \framework\parents\Controller
    {
        public function workingWithModel()
        {
            // Initialize object of Model 'User'.
            // Now you can use your Model.
            $user = new User;
        }
    }
    ```

  If you don't have a table with name `user` before, just use `create()` method to create the table automatically when you run the `Controller` method `workingWithModel()`.

    ```php
    $user = new User;

    // this will create new table into Database with columns and properties that
    // already defined on 'protected static $columns'.
    $user->create();
    ```

  Almost done, now you just needed to use the `Model` with some built in functions or methods.

    ```php
    $user = new User;

    // Open Database connection manually. Only needed if 'auto_connect' config is FALSE.
    $user->open();

    // Close Database connection manually. Only needed if 'auto_connect' config is FALSE.
    $user->close();

    // Delete all data in Model 'User' | table 'user'.
    $user->delete();

    // Delete all data in Model 'User' | table 'user' | where id = 1 and username = name.
    $user->delete(['id' => 1, 'username' => 'name']);

    // Insert new data to Model 'User' | table 'user' | to column username with value
    // 'Linus Torvald'.
    $user->insert(['username' => 'Linus Torvald']);

    // Update data in Model 'User' | table 'user' | where id = 1. Update username
    // to value 'Linus Torvald'.
    $user->update(['username' => 'Linus Torvald'], ['id' => 1]);

    // Get all data from Model 'User' | table 'user'.
    $user->get();

    // Get 5 data results from Model 'User' | table 'user'.
    $user->get(5);

    // Select all data from column 'username' of Model 'User' | table 'user'.
    $user->select('username')->get();

    // Get data from column 'username' of Model 'User' | table 'user' | take 4 data results
    // start from data number 2.
    $user->range(4, 2)->get();

    // Get data from Model 'User' | table 'user' | based on the clause 'WHERE id = 1'.
    // You can do anything inside of 'clause()'.
    $user->clause('WHERE id = 1')->get();

    // Select data from column 'username' of Model 'User' | table 'user' |
    // where id = 1 AND username = 'Linus Torvald'.
    $user->where(['id' => 1, 'username' => 'Linus Torvald'])->get();

    // Exec query.
    // 'query' is anything sql queries such as 'DELETE * FROM' or 'SELECT *'.
    $user->exec(query);

    // Execute query with bind params (PDO prepare statement).
    $user->execute(query, bindParams);

    // You can custom you queries with chaining functions or methods like this:
    $user->select('username')->range(4, 2)->get();

    // Using prepare statement
    $user->clause('WHERE id=:id')->bindParams(['id' => 1])->get();
    ```


- #### Creating view.
  `View`s are placed in `worksheet/views`. Basically, `View` is a template, it can be HTML or PHP code. Nothing special rules for `View`. But, in Janggelan the `View` extension is always `.php`. You can write anything code inside of `View`. To using a `View`, you just need to call it. Example:

    ```php
    // Calling View 'example.php' on requests.php
    // Note that you cannot calling View with Closure or Callback.
    $this->request('GET / (example)');

    // Calling View 'example.php' inside folder 'new_folder' on requests.php
    $this->request('GET / (new_folder/example)');

    // Calling View 'example.php' on Controller
    $this->LOAD_VIEW('example');

    // Calling View 'example.php' inside folder 'new_folder' on Controller
    $this->LOAD_VIEW('new_folder/example');
    ```

  If you want to placed `View` outside `worksheet/views` to everywhere inside `public` or `public_html` or `www` directory, you just have to add `/`:

    ```php
    $this->request('GET / (/example)');

    $this->LOAD_VIEW('/example');
    ```

  That will tell the system to find the `View` on `public/example.php` or `public_html/example.php` or `www/example.php`.

  Now, how to passing data in `View`. Actually, you can do it simple. Just `compact()` the data: Note that passing data only possible when calling `View` by `Controller`.

    ```php
    $data = 'This is data';

    $this->LOAD_VIEW('example', compact('data'));
    ```

  Then, on the `View` file `example.php`, just call the variable:

    ```php
    <p><?php echo $data; ?></p>
    ```


- #### Using tools.
  Janggelan provides some tools that you can use, and maybe useful for your development cases. They are placed in `worksheet/tools`. To use them, just have to call their class name. Example:

    ```php
    <?php namespace controller;

    use tool\Validation;

    class Example extends \framework\parents\Controller
    {
        private $validation;

        function __construct()
        {
            $this->validation = new Validation;
        }
    }
    ```


- #### About protected rule.
  `Protected Rule` is a system in Janggelan to protect your `page`, `View`, or `Uri`, just like login system. `Protected Rule` stored anonymous data that always be checked when `request` used this system. If user that visiting doesn't have the valid anonymous data, user will be redirected automatically into `target` that has been defined before. This will easy you to protecting pages that you want to make it private or only for certain users.

  To make new `Protected Rule`, go to config file on `backend/config/protected.php`. You can make more than one `Protected Rule`. Example:

    ```php
    <?php return [

        // FALSE means, system will uses SESSION to store protected_rule data. Set it TRUE
        // if you want to store the data in COOKIE.
        'use_cookie' => FALSE,

        'protected_rule' => [

            // Creating 'Protected Rule' with name 'login'.
            // If the data is not valid, then redirect to Controller 'Example'
            // method 'protected.'
            'login' => [
                'on_false' => [
                    'controller' => 'Example',
                    'method' => 'protected'
                ],
            ],

            // Creating 'Protected Rule' with name 'protect'.
            // If the data is not valid, then redirect to View 'example'.
            'protect' => [
                'on_false' => [
                    'view' => 'example',
                ],
            ],

            // Creating 'Protected Rule' with name 'myRule'.
            // If the data is not valid, then redirect to uri '/wrong'.
            'myRule' => [
                'on_false' => '/wrong'
            ],

        ]
    ];
    ```

  Then, to applying that `Protected Rule`, go to `worksheet/requests.php`, and add new `Request`: (the syntax is `!!`):

    ```php
    // Applying Protected Rule 'login'.
    $this->request('GET / @Example::example !!login');

    $this->request('GET / (viewName) !!login');

    $this->request('GET / !!login', function()
    {
        echo 'If you see this, then you are an Admin.';
    });
    ```

  How to set a valid data for user or `Protected Rule`? Just use this built it functions or methods.

    ```php
    $this->SET_RULE($name);
    ```

  You can also passing values into `Protected Rule` data:

    ```php
    $this->SET_RULE($name, $values);
    ```

  Here is complete functions or methods for `Protected Rule`:

    ```php
    // Check valid data for user or 'Protected Rule';
    $this->CHECK_RULE($name);

    // Set new valid data for user or 'Protected Rule'.
    $this->SET_RULE($name, $data = '');

    // Get 'Protected Rule' data.
    $this->GET_RULE($name);

    // Delete valid 'Protected Rule' data.
    $this->DESTROY_RULE($name);
    ```


- #### Configuring database.
  To configure your Database, please go to `backend/.secrets/.db`. There contains an object to configure your Database:

    ```json
    {"DB_HOST": "", "DB_NAME": "", "DB_USERNAME": "", "DB_PASSWORD": ""}
    ```

  Set on every key values with your Database configurations.


- #### Force uri.
  By default, Janggelan is validated uri for directory exist. If the uri referring to a isset folder or directory, Janggelan system will not be started, because it through redirected to that folder or directory.
  If you don't want this to happend, open file `backend/force.uri`, and rewrite old value to `TRUE`.


### Author

[Dali Kewara](http://dalikewara.com) | [<dalikewara@windowslive.com>](mailto:dalikewara@windowslice.com)

### License

[Janggelan](http://dalikewara.com/project/janggelan) is an open-sourced PHP framework licensed under the [MIT license](http://opensource.org/licenses/MIT).
