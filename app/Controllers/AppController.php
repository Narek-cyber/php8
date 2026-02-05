<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\widgets\language\Language;
use Wfm\App;
use Wfm\Controller;

class AppController extends Controller
{
    /**
     * @param $route
     */
    public function __construct($route)
    {
        parent::__construct($route);
        new AppModel();

        App::$app->setProperty('languages', Language::getLanguages());
        debug(App::$app->getProperty('languages'));
    }
}