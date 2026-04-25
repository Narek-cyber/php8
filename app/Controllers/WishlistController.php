<?php

namespace App\Controllers;

use App\Models\Wishlist;
use JetBrains\PhpStorm\NoReturn;
use Wfm\App;

/** @property Wishlist $model */
class WishlistController extends AppController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        $lang = App::$app->getProperty('language');
        $products = $this->model->get_wishlist_products($lang);
        $this->setMeta(___('wishlist_index_title'));
        $this->set(compact('products'));
    }

    /**
     * @return void
     */
    #[NoReturn]
    public function addAction(): void
    {
        $id = get('id');
        if (!$id) {
            $answer = ['result' => 'error', 'text' => ___('tpl_wishlist_add_error')];
            exit(json_encode($answer));
        }

        $product = $this->model->get_product($id);

        if ($product) {
            $this->model->add_to_wishlist($id);
            $answer = ['result' => 'success', 'text' => ___('tpl_wishlist_add_success')];
        } else {
            $answer = ['result' => 'error', 'text' => ___('tpl_wishlist_add_error')];
        }

        exit(json_encode($answer));
    }

    /**
     * @return void
     */
    #[NoReturn]
    public function deleteAction(): void
    {
        $id = get('id');

        if ($this->model->delete_from_wishlist($id)) {
            $answer = ['result' => 'success', 'text' => ___('tpl_wishlist_delete_success')];
        } else {
            $answer = ['result' => 'error', 'text' => ___('tpl_wishlist_delete_error')];
        }
        exit(json_encode($answer));
    }
}