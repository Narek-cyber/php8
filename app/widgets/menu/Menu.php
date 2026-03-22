<?php

namespace App\widgets\menu;

use RedBeanPHP\R;
use Wfm\App;
use Wfm\Cache;

class Menu
{
    // https://www.youtube.com/watch?v=fOMaYSmsiQU
    // https://www.youtube.com/watch?v=Qble3-723bs
    /**
     * @var array
     */
    protected array $data = [];
    /**
     * @var array
     */
    protected array $tree = [];
    /**
     * @var string
     */
    protected string $menuHtml = '';
    /**
     * @var string
     */
    protected string $tpl;
    /**
     * @var string
     */
    protected string $container = 'ul';
    /**
     * @var string
     */
    protected string $class = 'menu';
    /**
     * @var int
     */
    protected int $cache = 3600;
    /**
     * @var string
     */
    protected string $cacheKey = 'ishop_menu';
    /**
     * @var array
     */
    protected array $attrs = [];
    /**
     * @var string
     */
    protected string $prepend = '';
    /**
     * @var array|mixed
     */
    protected array $language;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->language = App::$app->getProperty('language');
        $this->tpl = __DIR__ . '/menu_tpl.php';
        $this->getOptions($options);
        $this->run();
    }

    /**
     * @param $options
     * @return void
     */
    protected function getOptions($options): void
    {
        foreach ($options as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    /**
     * @return void
     */
    protected function run(): void
    {
        $cache = Cache::getInstance();
        $this->menuHtml = $cache->get("{$this->cacheKey}_{$this->language['code']}");

        if (!$this->menuHtml) {
//            $this->data = R::getAssoc("SELECT c.*, cd.* FROM category c
//                        JOIN category_description cd
//                        ON c.id = cd.category_id
//                        WHERE cd.language_id = ?", [$this->language['id']]);
            $this->data = App::$app->getProperty("categories_{$this->language['code']}");
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
            if ($this->cache) {
                $cache->set("{$this->cacheKey}_{$this->language['code']}", $this->menuHtml, $this->cache);
            }
        }

        $this->output();
    }

    /**
     * @return void
     */
    protected function output(): void
    {
        $attrs = '';
        if (!empty($this->attrs)) {
            foreach ($this->attrs as $k => $v) {
                $attrs .= " $k='$v' ";
            }
        }
        echo "<$this->container class='$this->class' $attrs>";
        echo $this->prepend;
        echo $this->menuHtml;
        echo "</$this->container>";
    }

    /**
     * @return array
     */
    protected function getTree(): array
    {
        $tree = [];
        $data = $this->data;
        foreach ($data as $id => &$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent_id']]['children'][$id] = &$node;
            }
        }
        return $tree;
    }

    /**
     * @param $tree
     * @param string $tab
     * @return string
     */
    protected function getMenuHtml($tree, string $tab = ''): string
    {
        $str = '';
        foreach ($tree as $id => $category) {
            $str .= $this->catToTemplate($category, $tab, $id);
        }
        return $str;
    }

    /**
     * @param $category
     * @param $tab
     * @param $id
     * @return bool|string
     */
    protected function catToTemplate($category, $tab, $id): bool|string
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
}