<?php

namespace App\Models\Admin;

class User extends \App\Models\User
{
    /**
     * @return bool
     */
    public static function isAdmin(): bool
    {
        return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
    }
}