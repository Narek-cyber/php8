<?php


namespace App\Controllers\Admin;

use App\Models\Admin\Product;
use RedBeanPHP\R;
use Wfm\App;
use Wfm\Pagination;

/** @property Product $model */
class ProductController extends AppController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $perpage = 3;
        $total = R::count('product');
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $products = $this->model->get_products($lang, $start, $perpage);
        $title = 'Список товаров';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'products', 'pagination', 'total'));
    }
}