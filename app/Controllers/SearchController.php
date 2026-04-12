<?php

namespace App\Controllers;

use App\Models\Search;
use Wfm\App;
use Wfm\Pagination;

/** @property Search $model */
class SearchController extends AppController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        $s = get('s', 's');
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $perpage = App::$app->getProperty('pagination');
        $total = $this->model->get_count_find_products($s, $lang);
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $products = $this->model->get_find_products($s, $lang, $start, $perpage);
        $this->setMeta(___('tpl_search_title'));
        $this->set(compact('s', 'products', 'pagination', 'total'));
    }
}