<?php

namespace App\Models;

use RedBeanPHP\R;
use Wfm\App;

class Category extends AppModel
{
    /**
     * @param $slug
     * @param $lang
     * @return array
     */
    public function get_category($slug, $lang): array
    {
        return R::getRow("SELECT c.*, cd.* FROM category c JOIN category_description cd on c.id = cd.category_id WHERE c.slug = ? AND cd.language_id = ?", [$slug, $lang['id']]);
    }

    /**
     * @param $id
     * @return string
     */
    public function getIds($id): string
    {
        $lang = App::$app->getProperty('language')['code'];
        $categories = App::$app->getProperty("categories_{$lang}");
        $ids = '';
        foreach ($categories as $k => $v) {
            if ($v['parent_id'] == $id) {
                $ids .= $k . ',';
                $ids .= $this->getIds($k);
            }
        }
        return $ids;
    }

    /**
     * @param $ids
     * @param $lang
     * @param $start
     * @param $perpage
     * @return array
     */
    public function get_products($ids, $lang, $start, $perpage): array
    {
        $sort_values = [
            'title_asc' => 'ORDER BY title ASC',
            'title_desc' => 'ORDER BY title DESC',
            'price_asc' => 'ORDER BY price ASC',
            'price_desc' => 'ORDER BY price DESC',
        ];

        $order_by = '';

        if (isset($_GET['sort']) && array_key_exists($_GET['sort'], $sort_values)) {
            $order_by = $sort_values[$_GET['sort']];
        }

        return R::getAll("SELECT p.*, pd.* FROM product p JOIN product_description pd on p.id = pd.product_id WHERE p.status = 1 AND p.category_id IN ($ids) AND pd.language_id = ? $order_by LIMIT $start, $perpage", [$lang['id']]);
    }


    /**
     * @param $ids
     * @return int
     */
    public function get_count_products($ids): int
    {
        return R::count('product', "category_id IN ($ids) AND status = 1");
    }
}