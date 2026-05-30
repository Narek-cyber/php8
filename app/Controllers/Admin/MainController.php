<?php

namespace App\Controllers\Admin;

class MainController extends AppController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        $title = 'Главная страница';
        $this->setMeta('Админка :: Главная страница');
        $this->set(compact('title'));
    }
}