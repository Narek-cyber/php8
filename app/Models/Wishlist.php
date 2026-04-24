<?php

namespace App\Models;

use RedBeanPHP\R;

class Wishlist extends AppModel
{
    /**
     * @param $id
     * @return array|string|null
     */
    public function get_product($id): array|null|string
    {
        return R::getCell("SELECT id FROM product WHERE status = 1 AND id = ?", [$id]);
    }

    /**
     * @param $id
     * @return void
     */
    public function add_to_wishlist($id): void
    {
        $wishlist = self::get_wishlist_ids();
        if (!$wishlist) {
            setcookie('wishlist', $id, time() + 3600 * 24 * 7 * 30, '/');
        } else {
            if (!in_array($id, $wishlist)) {
                if (count($wishlist) > 5) {
                    array_shift($wishlist);
                }
                $wishlist[] = $id;
                $wishlist = implode(',', $wishlist);
                setcookie('wishlist', $wishlist, time() + 3600 * 24 * 7 * 30, '/');
            }
        }
    }

    /**
     * @return array
     */
    public static function get_wishlist_ids(): array
    {
        $wishlist = $_COOKIE['wishlist'] ?? '';
        if ($wishlist) {
            $wishlist = explode(',', $wishlist);
        }

        if (is_array($wishlist)) {
            $wishlist = array_slice($wishlist, 0, 6);
            return array_map('intval', $wishlist);
        }

        return [];
    }
}