<?php

namespace App\Controllers\admin;

use Wfm\Controller;

class MainController extends Controller
{
    /**
     * @return void
     */
    public function indexAction(): void
    {
        echo '<h1>ADMIN AREA</h1>';
    }
}