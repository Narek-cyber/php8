<?php

namespace App\Controllers\Admin;

use App\Models\AppModel;
use App\Models\Admin\User;
use App\widgets\language\Language;
use RedBeanPHP\R;
use Wfm\App;
use Wfm\Controller;
use Exception;

class AppController extends Controller
{
    /**
     * @throws Exception
     */
    public false|string $layout = 'admin';

    /**
     * @param $route
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

        $lang = App::$app->getProperty('language');
        $categories = R::getAssoc("SELECT c.*, cd.* FROM category c 
                        JOIN category_description cd
                        ON c.id = cd.category_id
                        WHERE cd.language_id = ?", [$lang['id']]);
        App::$app->setProperty("categories_{$lang['code']}", $categories);
    }
}