<?php

if (PHP_MAJOR_VERSION < 8) {
    die('Required version PHP >= 8');
}

require_once dirname(__DIR__) . '/config/init.php';
require_once HELPERS . '/functions.php';
require_once CONFIG . '/routes.php';

new \Wfm\App();

//debug(\Wfm\Router::getRoutes());