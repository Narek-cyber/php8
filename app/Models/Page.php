<?php

namespace App\Models;

use RedBeanPHP\R;

class Page extends AppModel
{
    /**
     * @param $slug
     * @param $lang
     * @return array
     */
    public function get_page($slug, $lang): array
    {
        return R::getRow("SELECT p.*, pd.* FROM page p 
            JOIN page_description pd ON p.id = pd.page_id 
                 WHERE p.slug = ? AND pd.language_id = ?", [$slug, $lang['id']
        ]);
    }
}