<?php

if (PHP_MAJOR_VERSION < 8) {
    die('Required PHP version >= 8');
}

require_once dirname(__DIR__) . '/config/init.php';

new \wfm\App();

throw new Exception('An error has occurred!', 404);
echo 'Hello!';
echo $test;
