<?php

namespace App\Controllers\Admin;

use App\Models\Admin\Slider;

/** @property Slider $model */
class SliderController extends AppController
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->update_slider();
            $_SESSION['success'] = 'Слайдер обновлен';
            redirect();
        }
        $gallery = $this->model->get_slides();
        $title = 'Управление слайдером';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title', 'gallery'));
    }
}