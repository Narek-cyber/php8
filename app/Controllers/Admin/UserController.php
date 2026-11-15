<?php

namespace App\Controllers\Admin;

use App\Models\Admin\User;
use JetBrains\PhpStorm\NoReturn;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use Wfm\Pagination;
use Exception;

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
     * @throws Exception
     */
    public function viewAction(): void
    {
        $id = get('id');
        $user = $this->model->get_user($id);
        if (!$user) {
            throw new \Exception('User not found Not', 404);
        }

        $page = get('page');
        $perpage = 1;
        $total = $this->model->get_count_orders($id);
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $orders = $this->model->get_user_orders($start, $perpage, $id);
        $title = 'Профиль пользователя';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'user', 'pagination', 'total', 'orders'));
    }

    public function addAction(): void
    {
        if (!empty($_POST)) {
            $this->model->load();
            if (
                !$this->model->validate($this->model->attributes) ||
                !$this->model->checkUnique('Этот E-mail уже занят')
            ) {
                $this->model->getErrors();
                $_SESSION['form_data'] = $_POST;
            } else {
                $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                if ($this->model->save('user')) {
                    $_SESSION['success'] = 'Пользователь добавлен';
                } else {
                    $_SESSION['errors'] = 'Ошибка добавления пользователя';
                }
            }
            redirect();
        }
        $title = 'Новый пользователь';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title'));
    }

    /**
     * @throws SQL
     * @throws Exception
     */
    public function editAction(): void
    {
        $id = get('id');
        $user = $this->model->get_user($id);
        if (!$user) {
            throw new Exception('User not found', 404);
        }

        if (!empty($_POST)) {
            $this->model->load();
            if (empty($this->model->attributes['password'])) {
                unset($this->model->attributes['password']);
            }

            if (!$this->model->validate($this->model->attributes) || !$this->model->checkEmail($user)) {
                $this->model->getErrors();
            } else {
                if (!empty($this->model->attributes['password'])) {
                    $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                }
                if ($this->model->update('user', $id)) {
                    $_SESSION['success'] = 'Данные пользователя обновлены. Перезайдите, если вы обновляли свои данные';
                } else {
                    $_SESSION['errors'] = 'Ошибка обновления профиля пользователя';
                }
            }
            redirect();
        }

        $title = 'Редактирование пользователя';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'user'));
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