<?php

namespace App\Controllers\Admin;

use App\Models\AppModel;
use App\Models\Admin\User;
use App\widgets\language\Language;
use Wfm\App;
use Wfm\Controller;
use Exception;

class AppController extends Controller
{
    public false|string $layout = 'admin';

    /**
     * @throws Exception
     */
    public function __construct($route)
    {
        parent::__construct($route);

        if (!User::isAdmin() && $route['action'] != 'login-admin') {
            redirect(ADMIN . '/user/login-admin');
        }

        new AppModel();
        App::$app->setProperty('languages', Language::getLanguages());
        App::$app->setProperty('language', Language::getLanguage(App::$app->getProperty('languages')));
    }
}