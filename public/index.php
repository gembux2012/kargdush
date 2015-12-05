<?php

//require realpath(__DIR__.'/../t4/framework/boot.php');
require realpath(__DIR__ . '/../t4/framework/boot.php');
require realpath(\T4\ROOT_PATH . DS . '..' . DS . 'vendor' . DS . 'autoload.php');

\T4\Mvc\Application::getInstance()->run();