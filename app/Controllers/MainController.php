<?php

namespace App\Controllers;

use Wfm\Controller;

class MainController extends Controller
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
//        echo __METHOD__;
//        $this->layout = 'default';
        $names = ['John', 'Dave', 'Katy'];
        $this->setMeta('Home', 'Description...', 'keywords...');
//        $this->set(['test' => 'TEST VAR', 'name' => 'John']);
//        $this->set(['names' => $names]);
        $this->set(compact('names'));
    }
}