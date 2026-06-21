<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use RedBeanPHP\R;
use Exception;

class Category extends AppModel
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

    /**
     * @return bool
     */
    public function category_validate(): bool
    {
        $errors = '';
        foreach ($_POST['category_description'] as $lang_id => $item) {
            $item['title'] = trim($item['title']);
            if (empty($item['title'])) {
                $errors .= "Не заполнено Наименование во вкладке {$lang_id}<br>";
            }
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function save_category(): bool
    {
        R::begin();
        try {
            $category = R::dispense('category');
            $category->parent_id = post('parent_id', 'i');
            $category_id = R::store($category);
            $category->slug = AppModel::create_slug('category',
                'slug',
                $_POST['category_description'][1]['title'],
                $category_id
            );

            R::store($category);

            foreach ($_POST['category_description'] as $lang_id => $item) {
                R::exec("INSERT INTO category_description (category_id, language_id, title, description, keywords, content) VALUES (?,?,?,?,?,?)", [
                    $category_id,
                    $lang_id,
                    $item['title'],
                    $item['description'],
                    $item['keywords'],
                    $item['content'],
                ]);
            }
            R::commit();
            return true;
        } catch (Exception $e) {
            R::rollback();
            return false;
        }
    }
}