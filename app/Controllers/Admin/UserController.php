<?php

namespace App\Controllers\Admin;

use App\Models\Admin\User;
use JetBrains\PhpStorm\NoReturn;
use RedBeanPHP\R;
use Wfm\Pagination;

/** @property User $model */
class UserController extends AppController
{

    /**
     * @return void
     */
    public function indexAction(): void
    {
        $page = get('page');
        $perpage = 20;
        $total = R::count('user');
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $users = $this->model->get_users($start, $perpage);
        $title = 'Список пользователей';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'users', 'pagination', 'total'));
    }

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