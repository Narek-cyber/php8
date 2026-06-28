<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use RedBeanPHP\R;
use Exception;
use Wfm\App;

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
        $lang = App::$app->getProperty('language')['id'];
        R::begin();
        try {
            $category = R::dispense('category');
            $category->parent_id = post('parent_id', 'i');
            $category_id = R::store($category);
            $category->slug = AppModel::create_slug('category',
                'slug',
                $_POST['category_description'][$lang]['title'],
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

    /**
     * @param $id
     * @return bool
     */
    public function update_category($id): bool
    {
        R::begin();
        try {
            $category = R::load('category', $id);
            if (!$category) {
                return false;
            }
            $category->parent_id = post('parent_id', 'i');
            R::store($category);

            foreach ($_POST['category_description'] as $lang_id => $item) {
                R::exec("UPDATE category_description SET title = ?, description = ?, keywords = ?, content = ? WHERE category_id = ? AND language_id = ?", [
                    $item['title'],
                    $item['description'],
                    $item['keywords'],
                    $item['content'],
                    $id,
                    $lang_id,
                ]);
            }
            R::commit();
            return true;
        } catch (Exception $e) {
            R::rollback();
            return false;
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function get_category($id): array
    {
        return R::getAssoc("SELECT cd.language_id, cd.*, c.* FROM category_description cd JOIN category c on c.id = cd.category_id WHERE cd.category_id = ?", [$id]);
    }
}