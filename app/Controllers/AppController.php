<?php

namespace App\Controllers;

use Wfm\Controller;

class AppController extends Controller
{
    /**
     * @param $route
     */
    public function __construct($route)
    {
        parent::__construct($route);
    }
}