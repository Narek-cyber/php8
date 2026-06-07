<?php

namespace App\Controllers\Admin;

use App\Models\Admin\User;
use JetBrains\PhpStorm\NoReturn;

/** @property User $model */
class UserController extends AppController
{
    /**
     * @return void
     */
    public function loginAdminAction(): void
    {
        if ($this->model::isAdmin()) {
            redirect(ADMIN);
        }

        $this->layout = 'login';

        if (!empty($_POST)) {
            if ($this->model->login(true)) {
                $_SESSION['success'] = 'Вы успешно авторизованы';
            } else {
                $_SESSION['errors'] = 'Логин/пароль введены неверно';
            }
            if ($this->model::isAdmin()) {
                redirect(ADMIN);
            } else {
                redirect();
            }
        }

    }

    /**
     * @return void
     */
    #[NoReturn]
    public function logoutAction(): void
    {
        if ($this->model::isAdmin()) {
            unset($_SESSION['user']);
        }
        redirect(ADMIN . '/user/login-admin');
    }
}