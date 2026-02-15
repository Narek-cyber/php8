<?php

namespace App\Controllers;

use App\Models\Main;
use RedBeanPHP\R;
use Wfm\App;


/** @property Main $model */
class MainController extends AppController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        $lang = App::$app->getProperty('language');
        $slides = R::findAll('slider');

        $products = $this->model->get_hits($lang, 6);

        $this->set(compact('slides', 'products'));
        $this->setMeta(
            ___('main_index_meta_title'),
            ___('main_index_meta_description'),
            ___('main_index_meta_keywords')
        );
    }
}