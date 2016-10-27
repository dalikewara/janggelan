<?php return [

    /*
    | Setting for cookie usage.
    | Default is FALSE.
    | FALSE means, system will uses SESSION to store protected_rule data. Set it TRUE
    | if you want to store the data in COOKIE.
    */
    'use_cookie' => FALSE,

    /*
    | Setting for Protected Rule.
    | By using protected_rule, you can simple protecting your page. This system stored
    | anonymous data that always checked when user visiting the page that used it, just
    | like login system. There are some methods that you can use to work with protected_rule:
    |
    | $this->setRule(), $this->getRule(), $this->destroyRule(), and $this->checkRule()
    |
    | You can set more than one protected_rule.
    */
    'protected_rule' => [

        'login' => [
            'on_false' => [
                'controller' => 'Example',
                'method' => 'protected'
            ],
        ],
        // Example:
        // 'login' => [
        //     // Will be redirected back to home.
        //     'on_false' => '/',
        // ],
        // 'login' => [
        //     // Will be redirected to controller (Wrong).
        //     'on_false' => [
        //         'controller' => 'Example',
        //         'method' => 'test3',
        //     ],
        // ],
        // 'login' => [
        //     'on_false' => [
        //         // Will be redirected to view (viewName).
        //         'view' => 'viewName'
        //     ],
        // ],
    ],

];
