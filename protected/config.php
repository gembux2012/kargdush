<?php

return [
    'db' => [
        'default' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'dbname' => 'dush',
            'user' => 'root',
            'password' => '',
        ]
    ],
    'auth' => [
        'expire' => 31536000 // 1 year
    ],
    'mail' => [
        'method' => 'smtp',
        'host' => 'smtp.gmail.com',
        'auth' => [
            'username' => 'phpsendertesting@gmail.com',
            'password' => 'vera1234567'
        ],
        'sender' => 'Sender',
        'port' => '587',
        'secure' => 'tls',
    ],
    'extensions' => [
        'jquery' => [
        ],

        'bootstrap' => [
            'location' => 'local',
            'theme' => '',
        ],
        'moderna' => [
        ],

        'ckeditor' => [
            'location' => 'local',
        ],
        'ckfinder' => [
            'autoload' => false,
        ],
        'jstree' => [
            'autoload' => false,
        ],
        'sxgeo' => [
        ],
        'captcha' => [
            'register' => false,
            'message' => true,
        ],

    ],
    'errors' => [
        404 => '///404',
    ],
];