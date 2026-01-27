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
        echo __METHOD__;
    }
}