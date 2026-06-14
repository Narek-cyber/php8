<?php

namespace App\Models\Admin;

use RedBeanPHP\R;
use Wfm\Model;

class Category extends Model
{
    /**
     * @param $id
     * @return int
     */
    public function get_count_products($id): int
    {
        return R::count('product', 'category_id = ?', [$id]);
    }

    /**
     * @param $id
     * @return int
     */
    public function get_count_children($id): int
    {
        return R::count('category', 'parent_id = ?', [$id]);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete_category($id): void
    {
        R::exec("DELETE FROM category WHERE id = ?", [$id]);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete_category_description($id): void
    {
        R::exec("DELETE FROM category_description WHERE category_id = ?", [$id]);
    }
}