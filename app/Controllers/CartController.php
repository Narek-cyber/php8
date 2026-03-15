<?php

namespace App\Controllers;

use App\Models\Cart;
use Wfm\App;

/** @property Cart $model */
class CartController extends AppController
{
    /**
     * @return bool
     */
    public function addAction(): bool
    {
        $lang = App::$app->getProperty('language');
        $id = get('id');
        $qty = get('qty');

        if (!$id) {
            return false;
        }

        $product = $this->model->get_product($id, $lang);
        if (!$product) {
            return false;
        }

        $this->model->add_to_cart($product, $qty);

        if ($this->isAjax()) {
//            debug($_SESSION['cart'], 1);
            $this->loadView('cart_modal');
        }

        redirect();
        return true;
    }
}