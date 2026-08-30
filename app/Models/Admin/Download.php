<?php

namespace App\Models\Admin;

use App\Models\AppModel;
use RedBeanPHP\R;

class Download extends AppModel
{
    /**
     * @param $lang
     * @param $start
     * @param $perpage
     * @return array
     */
    public function get_downloads($lang, $start, $perpage): array
    {
        return R::getAll("SELECT d.*, dd.* FROM download d JOIN download_description dd on d.id = dd.download_id WHERE dd.language_id = ? LIMIT $start, $perpage", [$lang['id']]);
    }
}