<?php

namespace App\Controllers\Admin;

use App\Models\Admin\Download;
use RedBeanPHP\R;
use Wfm\App;
use Wfm\Pagination;

/** @property Download $model */
class DownloadController extends AppController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $perpage = 20;
        $total = R::count('download');
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();
        $downloads = $this->model->get_downloads($lang, $start, $perpage);
        $title = 'Файлы (цифровые товары)';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'downloads', 'pagination', 'total'));
    }
}