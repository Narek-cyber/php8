<?php

namespace App\Models;

use RedBeanPHP\R;

class Main extends \Wfm\Model
{
    /**
     * @return array
     */
    public function get_names(): array
    {
        return R::findAll('name');
    }
}