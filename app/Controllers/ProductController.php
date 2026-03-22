<?php

namespace App\Controllers;

use App\Models\Product;
use Wfm\App;
use Exception;

class ProductController extends AppController
{
    /**
     * @throws Exception
     * @property Product $model
     */
    public function viewAction(): void
    {
        $lang = App::$app->getProperty('language');
        $product = $this->model->get_product($this->route['slug'], $lang);

        if (!$product) {
            throw new Exception("Товар по запросу {$this->route['slug']} не найден", 404);
        }

        $gallery = $this->model->get_gallery($product['id']);
        $this->setMeta($product['title'] ?? '', $product['description'] ?? '', $product['keywords'] ?? '');
        $this->set(compact('product', 'gallery'));
    }
}