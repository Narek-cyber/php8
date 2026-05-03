<?php

use JetBrains\PhpStorm\NoReturn;

/**
 * @param $data
 * @param bool $die
 * @return void
 */
function debug($data, bool $die = false): void
{
    echo '<pre>' . print_r($data, 1) . '</pre>';
    if ($die) {
        die;
    }
}

/**
 * @param $str
 * @return string
 */
function h($str): string
{
    return htmlspecialchars($str);
}

/**
 * @param bool $http
 * @return void
 */
#[NoReturn]
function redirect(bool $http = false): void
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = $_SERVER['HTTP_REFERER'] ?? PATH;
    }
    header("Location: $redirect");
    die;
}

/**
 * @return string
 */
function base_url(): string
{
    return
        PATH . '/' . (\wfm\App::$app->getProperty('lang')
            ? \wfm\App::$app->getProperty('lang') . '/'
            : '');
}

/**
 * @param string $key Key of GET array
 * @param string $type Values 'i', 'f', 's'
 * @return float|int|string
 */
function get(string $key, string $type = 'i'): float|int|string
{
    $param = $key;
    $$param = $_GET[$param] ?? '';
    if ($type == 'i') {
        return (int)$$param;
    } elseif ($type == 'f') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

/**
 * @param string $key Key of POST array
 * @param string $type Values 'i', 'f', 's'
 * @return float|int|string
 */
function post(string $key, string $type = 's'): float|int|string
{
    $param = $key;
    $$param = $_POST[$param] ?? '';
    if ($type == 'i') {
        return (int)$$param;
    } elseif ($type == 'f') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

function __($key)
{
    echo \Wfm\Language::get($key);
}

function ___($key)
{
    return \Wfm\Language::get($key);
}

/**
 * @param $id
 * @return string
 */
function get_cart_icon($id): string
{
    if (!empty($_SESSION['cart']) && array_key_exists($id, $_SESSION['cart'])) {
        $icon = '<i class="fas fa-luggage-cart"></i>';
    } else {
        $icon = '<i class="fas fa-shopping-cart"></i>';
    }
    return $icon;
}

/**
 * @param $name
 * @return string
 */
function get_field_value($name): string
{
    return isset($_SESSION['form_data'][$name]) ? h($_SESSION['form_data'][$name]) : '';
}

