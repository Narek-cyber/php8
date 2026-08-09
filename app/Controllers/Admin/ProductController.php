<?php


namespace App\Controllers\Admin;

use App\Models\Admin\Product;
use JetBrains\PhpStorm\NoReturn;
use RedBeanPHP\R;
use Wfm\App;
use Wfm\Pagination;
use Exception;

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

    /**
     * @return void
     */
    public function addAction(): void
    {
        if (!empty($_POST)) {
            if ($this->model->product_validate()) {
                if ($this->model->save_product()) {
                    $_SESSION['success'] = 'Товар добавлен';
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления товара';
                }
            }
            redirect();
        }

        $title = 'Новый товар';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title'));
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function editAction(): void
    {
        $id = get('id');

        if (!empty($_POST)) {
            if ($this->model->product_validate()) {
                if ($this->model->update_product($id)) {
                    $_SESSION['success'] = 'Товар сохранен';
                } else {
                    $_SESSION['errors'] = 'Ошибка обновления товара';
                }
            }
            redirect();
        }

        $product = $this->model->get_product($id);
        if (!$product) {
            throw new Exception('Not found product', 404);
        }

        $gallery = $this->model->get_gallery($id);

        $lang = App::$app->getProperty('language')['id'];
        App::$app->setProperty('parent_id', $product[$lang]['category_id']);
        $title = 'Редактирование товара';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'product', 'gallery'));
    }


    /**
     * @return void
     */
    #[NoReturn]
    public function getDownloadAction(): void
    {
        /*$data = [
            'items' => [
                [
                    'id' => 1,
                    'text' => 'Файл 1',
                ],
                [
                    'id' => 2,
                    'text' => 'Файл 2',
                ],
                [
                    'id' => 3,
                    'text' => 'File 1',
                ],
                [
                    'id' => 4,
                    'text' => 'File 2',
                ],
            ]
        ];*/
        $q = get('q', 's');
        $downloads = $this->model->get_downloads($q);
        echo json_encode($downloads);
        die;
    }
}