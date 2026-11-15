<?php

namespace App\Controllers\Admin;

use JetBrains\PhpStorm\NoReturn;
use Wfm\App;
use Wfm\Cache;

class CacheController extends AppController
{

    /**
     * @return void
     */
    public function indexAction(): void
    {
        $title = 'Управление кэшем';
        $this->setMeta("Админка :: {$title}");
        $this->set(compact('title'));
    }

    /**
     * @return void
     */
    #[NoReturn]
    public function deleteAction(): void
    {
        $langs = App::$app->getProperty('languages');
        $cache_key = get('cache', 's');
        $cache = Cache::getInstance();
        if ($cache_key == 'category') {
            foreach ($langs as $lang => $item) {
                $cache->delete("ishop_menu_{$lang}");
            }
        }
        if ($cache_key == 'page') {
            foreach ($langs as $lang => $item) {
                $cache->delete("ishop_page_menu_{$lang}");
            }
        }
        $_SESSION['success'] = 'Выбранный кэш удален';
        redirect();
    }
}