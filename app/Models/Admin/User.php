<?php

namespace App\Models\Admin;

use RedBeanPHP\R;

class User extends \App\Models\User
{
    /**
     * @var array|string[]
     */
    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
        'address' => '',
        'role' => '',
    ];

    /**
     * @var array
     */
    public array $rules = [
        'required' => ['email', 'password', 'name', 'address', 'role',],
        'email' => ['email',],
        'lengthMin' => [
            ['password', 6],
        ],
        'optional' => ['password'],
    ];

    /**
     * @var array|string[]
     */
    public array $labels = [
        'email' => 'E-mail',
        'password' => 'Пароль',
        'name' => 'Имя',
        'address' => 'Адрес',
        'role' => 'Роль',
    ];

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

    /**
     * @param $user_data
     * @return bool
     */
    public function checkEmail($user_data): bool
    {
        if ($user_data['email'] == $this->attributes['email']) {
            return true;
        }
        $user = R::findOne('user', 'email = ?', [$this->attributes['email']]);
        if ($user) {
            $this->errors['unique'][] = 'Этот email уже используется другим пользователем';
            return false;
        }
        return true;
    }
}