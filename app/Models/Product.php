<?php

namespace App\Models;

use RedBeanPHP\R;

class Product extends AppModel
{
    /**
     * @param $slug
     * @param $lang
     * @return array
     */
    public function get_product($slug, $lang): array
    {
        return R::getRow("SELECT p.*, pd.* FROM product p 
                JOIN product_description pd 
                    on p.id = pd.product_id 
                 WHERE p.status = 1 AND p.slug = ? AND pd.language_id = ?", [$slug, $lang['id']]);
    }

    /**
     * @param $product_id
     * @return array
     */
    public function get_gallery($product_id): array
    {
        return R::getAll("SELECT * FROM product_gallery WHERE product_id = ?", [$product_id]);
    }
}