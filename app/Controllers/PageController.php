<?php

namespace App\Controllers;

use App\Models\Page;
use Wfm\App;

/** @property Page $model */
class PageController extends AppController
{
    /**
     * @return void
     */
    public function viewAction(): void
    {
        $lang = App::$app->getProperty('language');
        $page = $this->model->get_page($this->route['slug'], $lang);

        if (!$page) {
            $this->error_404();
            return;
        }

        $this->setMeta(
            $page['title'] ?? '',
            $page['description'] ?? '',
            $page['keywords'] ?? ''
        );
        $this->set(compact('page'));
    }
}