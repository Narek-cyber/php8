<?php

namespace App\Models\Admin;

use app\models\AppModel;
use RedBeanPHP\R;

class Product extends AppModel
{
    /**
     * @param $lang
     * @param $start
     * @param $perpage
     * @return array
     */
    public function get_products($lang, $start, $perpage): array
    {
        return R::getAll("SELECT p.*, pd.title FROM product p JOIN product_description pd on p.id = pd.product_id WHERE pd.language_id = ? LIMIT $start, $perpage", [$lang['id']]);
    }
}