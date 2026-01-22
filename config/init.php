<?php

const DEBUG = 1;
define("ROOT", dirname(__DIR__));
const WWW = ROOT . '/public';
const APP = ROOT . '/app';
const CORE = ROOT . '/vendor/wfm';
const HELPERS = ROOT . '/vendor/wfm/helpers';
const CACHE = ROOT . '/tmp/cache';
const LOGS = ROOT . '/tmp/logs';
const CONFIG = ROOT . '/config';
const LAYOUT = 'ishop';
const PATH = 'https://php-8.com';
const ADMIN = 'https://php-8.com/admin';
const NO_IMAGE = 'uploads/no_image.jpg';

require_once ROOT . '/vendor/autoload.php';
