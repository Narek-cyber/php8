<?php

namespace App\Controllers;

use App\Models\Main;
use Wfm\Controller;

class MainController extends Controller
{
    /**
     * @return void
     * @property Main $model
     */
    public function indexAction(): void
    {
//        echo __METHOD__;
//        $this->layout = 'default';
//        $names = ['John', 'Dave', 'Katy'];
//        $this->setMeta('Home', 'Description...', 'keywords...');
//        $this->set(['test' => 'TEST VAR', 'name' => 'John']);
//        $this->set(['names' => $names]);
//        $this->set(compact('names'));
        $names = $this->model->get_names();
        $this->setMeta('Home', 'Description...', 'keywords...');
        $this->set(compact('names'));
    }
}