<?php

namespace App\Models;

use RedBeanPHP\R;

class User extends AppModel
{
    /**
     * @var array|string[]
     */
    public array $attributes = [
        'email' => '',
        'password' => '',
        'name' => '',
        'address' => '',
    ];

    /**
     * @var array
     */
    public array $rules = [
        'required' => ['email', 'password', 'name', 'address',],
        'email' => ['email',],
        'lengthMin' => [
            ['password', 6],
        ],
    ];


    /**
     * @var array|string[]
     */
    public array $labels = [
        'email' => 'tpl_signup_email_input',
        'password' => 'tpl_signup_password_input',
        'name' => 'tpl_signup_name_input',
        'address' => 'tpl_signup_address_input',
    ];

    /**
     * @return bool
     */
    public static function checkAuth(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * @param string $text_error
     * @return bool
     */
    public function checkUnique(string $text_error = ''): bool
    {
        $user = R::findOne('user', 'email = ?', [$this->attributes['email']]);

        if ($user) {
            $this->errors['unique'][] = $text_error ?: ___('user_signup_error_email_unique');
            return false;
        }

        return true;
    }

    /**
     * @param bool $is_admin
     * @return bool
     */
    public function login(bool $is_admin = false): bool
    {
        $email = post('email');
        $password = post('password');
        if ($email && $password) {
            if ($is_admin) {
                $user = R::findOne('user', "email = ? AND role = 'admin'", [$email]);
            } else {
                $user = R::findOne('user', "email = ?", [$email]);
            }

            if ($user) {
                if (password_verify($password, $user->password)) {
                    foreach ($user as $k => $v) {
                        if (!$k != 'password') {
                            $_SESSION['user'][$k] = $v;
                        }
                    }
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $user_id
     * @return int
     */
    public function get_count_orders($user_id): int
    {
        return R::count('orders', 'user_id = ?', [$user_id]);
    }

    /**
     * @param $start
     * @param $perpage
     * @param $user_id
     * @return array
     */
    public function get_user_orders($start, $perpage, $user_id): array
    {
        return R::getAll("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC LIMIT $start, $perpage", [$user_id]);
    }

    /**
     * @param $id
     * @return array
     */
    public function get_user_order($id): array
    {
        return R::getAll("SELECT o.*, op.* FROM orders o JOIN order_product op on o.id = op.order_id WHERE o.id = ?", [$id]);
    }
}