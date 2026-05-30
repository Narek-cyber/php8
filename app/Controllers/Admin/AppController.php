<?php

namespace App\Controllers\Admin;

use App\Models\AppModel;
use App\widgets\language\Language;
use Wfm\App;
use Wfm\Controller;

class AppController extends Controller
{
    public false|string $layout = 'admin';

    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();
        App::$app->setProperty('languages', Language::getLanguages());
        App::$app->setProperty('language', Language::getLanguage(App::$app->getProperty('languages')));
    }
}