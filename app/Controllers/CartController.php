<?php

namespace App\Controllers;

use App\Models\Cart;
use JetBrains\PhpStorm\NoReturn;
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

    /**
     * @return void
     */
    #[NoReturn]
    public function showAction(): void
    {
        $this->loadView('cart_modal');
    }

    /**
     * @return void
     */
    public function deleteAction(): void
    {
        $id = get('id');
        if (isset($_SESSION['cart'][$id])) {
            $this->model->delete_item($id);
        }
        if ($this->isAjax()) {
            $this->loadView('cart_modal');
        }
        redirect();
    }

    public function clearAction()
    {
        if (empty($_SESSION['cart'])) {
            return false;
        }
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        $this->loadView('cart_modal');
        return true;
    }
}