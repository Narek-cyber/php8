<?php

namespace App\Controllers\Admin;

class CategoryController extends AppController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        $title = 'Категории';
        $this->setMeta("Админка :: $title");
        $this->set(compact('title'));
    }
}