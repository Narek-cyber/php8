<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\widgets\language\Language;
use Wfm\App;
use Wfm\Controller;
use Exception;

class AppController extends Controller
{
    /**
     * @throws Exception
     */
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        App::$app->setProperty('languages', Language::getLanguages());
        App::$app->setProperty(
            'language',
                Language::getLanguage(App::$app->getProperty('languages')
            )
        );
        $lang = App::$app->getProperty('language');
        \Wfm\Language::load($lang['code'], $this->route);
    }
}