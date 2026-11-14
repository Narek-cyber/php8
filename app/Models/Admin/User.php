<?php

namespace App\Models\Admin;

use RedBeanPHP\R;

class User extends \App\Models\User
{
    /**
     * @return bool
     */
    public static function isAdmin(): bool
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
    }

    /**
     * @param $start
     * @param $perpage
     * @return array
     */
    public function get_users($start, $perpage): array
    {
        return R::findAll("user", "LIMIT $start, $perpage");
    }

    public function get_user($id): array
    {
        return R::getRow("SELECT * FROM user WHERE id = ?", [$id]);
    }
}