<?php

namespace App\Controllers;

use App\Models\AppModel;
use App\Models\Wishlist;
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

        $categories = R::getAssoc("SELECT c.*, cd.* FROM category c 
                        JOIN category_description cd
                        ON c.id = cd.category_id
                        WHERE cd.language_id = ?", [$lang['id']]);
        App::$app->setProperty("categories_{$lang['code']}", $categories);
        App::$app->setProperty('wishlist', Wishlist::get_wishlist_ids());
    }
}