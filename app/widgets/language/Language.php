<?php

namespace App\widgets\language;

use RedBeanPHP\R;
use Wfm\App;
use Exception;

class Language
{
    protected string $tpl;
    protected $languages;
    protected $language;

    public function __construct()
    {
        $this->tpl = __DIR__ . '/lang_tpl.php';
        $this->run();
    }

    /**
     * @return void
     */
    protected function run(): void
    {
        $this->languages = App::$app->getProperty('languages');
        $this->language = App::$app->getProperty('language');
        echo $this->getHtml();
    }

    /**
     * @return array
     */
    public static function getLanguages(): array
    {
        return R::getAssoc("SELECT code, title, base, id FROM language ORDER BY base DESC");
    }

    /**
     * @param $languages
     * @return mixed
     * @throws Exception
     */
    public static function getLanguage($languages): mixed
    {
        $lang = App::$app->getProperty('lang');
        if ($lang && array_key_exists($lang, $languages)) {
            $key = $lang;
        } elseif (!$lang) {
            $key = key($languages);
        } else {
            $lang = h($lang);
            throw new Exception("Not found language $lang", 404);
        }

        $lang_info = $languages[$key];
        $lang_info['code'] = $key;
        return $lang_info;
    }

    /**
     * @return string
     */
    protected function getHtml(): string
    {
        ob_start();
        require_once $this->tpl;
        return ob_get_clean();
    }
}