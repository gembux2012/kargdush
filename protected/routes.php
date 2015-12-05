<?php

return [

    '/admin/blocks'         => '/Admin/Blocks//',
    '/admin/blocks/<1>'     => '/Admin/Blocks/<1>/',
    '/admin/<1>/<2>/<3>'    => '/Admin//Module(module=<1>,controller=<2>,action=<3>)',
    '/admin/<1>/<2>'        => '/Admin//Module(module=<1>,action=<2>)',
    '/admin/<1>'            => '/Admin//Module(module=<1>)',

    //'/news/<1>' => '/News//One(id=<1>)',
    //'/news/<1>' => '/News//Blog',

    '/index' => '///',
    '/header'=> '/index/header',

   // '/pages/<1>'        => '/Pages/Index/PageByUrl(url=<1>)',
];