<?php

namespace App\Models;

use RedBeanPHP\R;

class Search extends AppModel
{
    /**
     * @param $s
     * @param $lang
     * @return int
     */
    public function get_count_find_products($s, $lang): int
    {
        return R::getCell("SELECT COUNT(*) FROM product p JOIN product_description pd on p.id = pd.product_id WHERE p.status = 1 AND pd.language_id = ? AND pd.title LIKE ?", [$lang['id'], "%{$s}%"]);
    }

    /**
     * @param $s
     * @param $lang
     * @param $start
     * @param $perpage
     * @return array
     */
    public function get_find_products($s, $lang, $start, $perpage): array
    {
        return R::getAll("SELECT p.*, pd.* FROM product p JOIN product_description pd ON p.id = pd.product_id WHERE p.status = 1 AND pd.language_id = ? AND pd.title LIKE ? LIMIT $start, $perpage", [$lang['id'], "%{$s}%"]);
    }
}