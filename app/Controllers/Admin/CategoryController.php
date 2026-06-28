<?php

namespace App\Controllers\Admin;

use App\Models\Admin\Category;
use JetBrains\PhpStorm\NoReturn;
use Wfm\App;
use Exception;

/** @property Category $model */
class CategoryController extends AppController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        $title = 'Категории';
        $this->setMeta("Админка :: $title");
        $this->set(compact('title'));
    }

    /**
     * @return void
     */
    #[NoReturn]
    public function deleteAction(): void
    {
        $id = get('id');
        $errors = '';
        $children = $this->model->get_count_children($id);
        $products = $this->model->get_count_products($id);

        if ($children) {
            $errors .= 'Ошибка! В категории есть вложенные категории<br>';
        }

        if ($products) {
            $errors .= 'Ошибка! В категории есть товары<br>';
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
        } else {
            $this->model->delete_category($id);
            $this->model->delete_category_description($id);
            $_SESSION['success'] = 'Категория удалена';
        }

        redirect();
    }

    /**
     * @return void
     */
    public function addAction(): void
    {
        if (!empty($_POST)) {
            if ($this->model->category_validate()) {
                if ($this->model->save_category()) {
                    $_SESSION['success'] = 'Категория сохранена';
                } else {
                    $_SESSION['errors'] = 'Ошибка!';
                }
            }
            redirect();
        }
        $title = 'Добавление категории';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title'));
    }

    /**
     * @throws Exception
     */
    public function editAction(): void
    {
        $id = get('id');
        if (!empty($_POST)) {
            if ($this->model->category_validate()) {
                if ($this->model->update_category($id)) {
                    $_SESSION['success'] = 'Категория обновлена';
                } else {
                    $_SESSION['errors'] = 'Ошибка!';
                }
            }
            redirect();
        }
        $category = $this->model->get_category($id);
        if (!$category) {
            throw new \Exception('Not found category', 404);
        }
        $lang = App::$app->getProperty('language')['id'];
        App::$app->setProperty('parent_id', $category[$lang]['parent_id']);
        $title = 'Редактирование категории';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'category'));
    }
}