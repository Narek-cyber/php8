<?php

namespace App\Controllers;

use App\Models\Cart;
use Wfm\App;

/** @property Cart $model */
class CartController extends AppController
{
    /**
     * @return false|void
     */
    public function addAction()
    {
        $lang = App::$app->getProperty('language');
        $id = get('id');
        $qty = get('qty');

        if (!$id) {
            return false;
        }

        $product = $this->model->get_product($id, $lang);
        debug($product, 1);
    }
}