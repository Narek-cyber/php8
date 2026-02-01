<?php

namespace App\Controllers;

use App\Models\Main;
use Wfm\Controller;
use RedBeanPHP\R;

class MainController extends Controller
{
    /**
     * @return void
     * @property Main $model
     */
    public function indexAction(): void
    {
        $slides = R::findAll('slider');
        $products = $this->model->get_hits(1, 6);
        $this->set(compact('slides', 'products'));
    }
}