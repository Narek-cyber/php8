<?php

namespace App\Controllers;

use App\Models\User;
use JetBrains\PhpStorm\NoReturn;
use RedBeanPHP\RedException\SQL;
use Wfm\Pagination;
use Exception;

/** @property User $model */
class UserController extends AppController
{
    /**
     * @return void
     * @throws SQL
     */
    public function signupAction(): void
    {
        if (User::checkAuth()) {
            redirect(base_url());
        }

        if (!empty($_POST)) {
            $data = $_POST;
            $this->model->load($data);
            if (!$this->model->validate($data) || !$this->model->checkUnique()) {
                $this->model->getErrors();
                $_SESSION['form_data'] = $data;
            } else {
                $this->model->attributes['password'] = password_hash($this->model->attributes['password'], PASSWORD_DEFAULT);
                if ($this->model->save('user')) {
                    $_SESSION['success'] = ___('user_signup_success_register');
                } else {
                    $_SESSION['errors'] = ___('user_signup_error_register');
                }
            }
            redirect();
        }
        $this->setMeta(___('tpl_signup'));
    }

    /**
     * @return void
     */
    public function loginAction(): void
    {
        if (User::checkAuth()) {
            redirect(base_url());
        }

        if (!empty($_POST)) {
            if ($this->model->login()) {
                $_SESSION['success'] = ___('user_login_success_login');
                redirect(base_url());
            } else {
                $data = $_POST;
                $_SESSION['form_data'] = $data;
                $_SESSION['errors'] = ___('user_login_error_login');
                redirect();
            }
        }

        $this->setMeta(___('tpl_login'));
    }

    /**
     * @return void
     */
    #[NoReturn]
    public function logoutAction(): void
    {
        if (User::checkAuth()) {
            unset($_SESSION['user']);
        }
        redirect(base_url() . 'user/login');
    }

    /**
     * @return void
     */
    public function cabinetAction(): void
    {
        if (!User::checkAuth()) {
            redirect(base_url() . 'user/login');
        }
        $this->setMeta(___('tpl_cabinet'));
    }

    /**
     * @return void
     */
    public function ordersAction(): void
    {
        if (!User::checkAuth()) {
            redirect(base_url() . 'user/login');
        }

        $page = get('page');
//        $perpage = App::$app->getProperty('pagination');
        $perpage = 5;
        $total = $this->model->get_count_orders($_SESSION['user']['id']);
        $pagination = new Pagination($page, $perpage, $total);
        $start = $pagination->getStart();

        $orders = $this->model->get_user_orders($start, $perpage, $_SESSION['user']['id']);

        $this->setMeta(___('user_orders_title'));
        $this->set(compact('orders', 'pagination', 'total'));
    }

    /**
     * @throws Exception
     */
    public function orderAction(): void
    {
        if (!User::checkAuth()) {
            redirect(base_url() . 'user/login');
        }

        $id = get('id');
        $order = $this->model->get_user_order($id);
        if (!$order) {
            throw new Exception('Not found order', 404);
        }

        $this->setMeta(___('user_order_title'));
        $this->set(compact('order'));
    }
}