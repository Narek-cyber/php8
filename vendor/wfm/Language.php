<?php

namespace Wfm;

class Language
{
    /**
     * array with all the translated phrases of the page
     * @var array
     */
    public static array $lang_data = [];

    /**
     * array with translated template phrases
     * @var array
     */
    public static array $lang_layout = [];

    /**
     * an array of translation phrases of the type
     * @var array
     */
    public static array $lang_view = [];

    /**
     * @param $code
     * @param $view
     * @return void
     */
    public static function load($code, $view): void
    {
        $lang_layout = APP . "/languages/$code.php";
        $lang_view = APP . "/languages/$code/{$view['controller']}/{$view['action']}.php";
        if (file_exists($lang_layout)) {
            self::$lang_layout = require_once $lang_layout;
        }
        if (file_exists($lang_view)) {
            self::$lang_view = require_once $lang_view;
        }
        self::$lang_data = array_merge(self::$lang_layout, self::$lang_view);
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key): mixed
    {
        return self::$lang_data[$key] ?? $key;
    }
}