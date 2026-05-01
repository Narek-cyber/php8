<?php

namespace App\Controllers;

use App\Models\User;

/** @property User $model */
class UserController extends AppController
{
    /**
     * @return void
     */
    public function signupAction(): void
    {
        if (User::checkAuth()) {
            redirect(base_url());
        }

        if (!empty($_POST)) {
            $data = $_POST;
            $this->model->load($data);

            if (!$this->model->validate($data)) {
                $this->model->getErrors();
            } else {
                $_SESSION['success'] = ___('user_signup_success_register');
            }

            redirect();
        }
        $this->setMeta(___('tpl_signup'));
    }
}