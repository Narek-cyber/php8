<?php

namespace App\Controllers;

use Wfm\App;

class LanguageController extends AppController
{
    /**
     * @return void
     */
    public function changeAction(): void
    {
        $lang = get('lang', 's');
        if ($lang) {
            if (array_key_exists($lang, App::$app->getProperty('languages'))) {
                // Cut off the base URL
                $url = trim(str_replace(PATH, '', $_SERVER['HTTP_REFERER']), '/');

                // We'll split it into two parts... Part 1 - a possible former language
                $url_parts = explode('/', $url, 2);
                // We are looking for the first part (the former language) in the array of languages
                if (array_key_exists($url_parts[0], App::$app->getProperty('languages'))) {
                    // we assign a new language to the first part if it is not the base one
                    if ($lang != App::$app->getProperty('language')['code']) {
                        $url_parts[0] = $lang;
                    } else {
                        // If this is the base language, remove the language from the URL.
                        array_shift($url_parts);
                    }
                } else {
                    // we assign a new language to the first part if it is not the base one
                    if ($lang != App::$app->getProperty('language')['code']) {
                        array_unshift($url_parts, $lang);
                    }
                }
                $url = PATH . '/' . implode('/', $url_parts);
                redirect($url);
            }
        }
        redirect();
    }
}