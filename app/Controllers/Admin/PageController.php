<?php

namespace App\Controllers\Admin;

use App\Models\Admin\Page;
use JetBrains\PhpStorm\NoReturn;
use RedBeanPHP\R;
use Wfm\App;
use Wfm\Pagination;
use Exception;

/** @property Page $model */
class PageController extends AppController
{
    public function indexAction(): void
    {
        $lang = App::$app->getProperty('language');
        $page = get('page');
        $perpage = 20;
        $total = R::count('page');
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $pages = $this->model->get_pages($lang, $start, $perpage);
        $title = 'Список страниц';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'pages', 'pagination', 'total'));
    }

    /**
     * @return void
     */
    #[NoReturn]
    public function deleteAction(): void
    {
        $id = get('id');
        if ($this->model->deletePage($id)) {
            $_SESSION['success'] = 'Страница удалена';
        } else {
            $_SESSION['errors'] = 'Ошибка удаления страницы';
        }
        redirect(ADMIN . '/page');
    }

    /**
     * @return void
     */
    public function addAction(): void
    {
        if (!empty($_POST)) {
            if ($this->model->page_validate()) {
                if ($this->model->save_page()) {
                    $_SESSION['success'] = 'Страница добавлена';
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления страницы';
                }
            }
            redirect(ADMIN . '/page');
        }

        $title = 'Новая страница';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title'));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function editAction(): void
    {
        $id = get('id');

        if (!empty($_POST)) {
            if ($this->model->page_validate()) {
                if ($this->model->update_page($id)) {
                    $_SESSION['success'] = 'Страница сохранена';
                } else {
                    $_SESSION['errors'] = 'Ошибка обновления страницы';
                }
            }
            redirect(ADMIN . '/page');
        }

        $page = $this->model->get_page($id);
        if (!$page) {
            throw new Exception('Not found page', 404);
        }
        $title = 'Редактирование страницы';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'page'));
    }
}