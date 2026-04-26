<?php

namespace App\widgets\page;


use RedBeanPHP\R;
use Wfm\App;
use Wfm\Cache;

class Page
{
    /**
     * @var mixed
     */
    protected mixed $language;
    /**
     * @var string
     */
    protected string $container = 'ul';
    /**
     * @var string
     */
    protected string $class = 'page-menu';
    /**
     * @var int
     */
    protected int $cache = 3600;
    /**
     * @var string
     */
    protected string $cacheKey = 'ishop_page_menu';
    /**
     * @var string
     */
    protected string $menuPageHtml;
    /**
     * @var string
     */
    protected string $prepend = '';
    protected $data;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->language = App::$app->getProperty('language');
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
        $this->menuPageHtml = $cache->get("{$this->cacheKey}_{$this->language['code']}");

        if (!$this->menuPageHtml) {
            $this->data = R::getAssoc("SELECT p.*, pd.* FROM page p 
                        JOIN page_description pd
                        ON p.id = pd.page_id
                        WHERE pd.language_id = ?", [$this->language['id']]);
            $this->menuPageHtml = $this->getMenuPageHtml();
            if ($this->cache) {
                $cache->set("{$this->cacheKey}_{$this->language['code']}", $this->menuPageHtml, $this->cache);
            }
        }

        $this->output();
    }

    /**
     * @return string
     */
    protected function getMenuPageHtml(): string
    {
        $html = '';
        foreach ($this->data as $k => $v) {
            $html .= "<li><a href='page/{$v['slug']}'>{$v['title']}</a></li>";
        }
        return $html;
    }

    /**
     * @return void
     */
    protected function output(): void
    {
        echo "<{$this->container} class='{$this->class}'>";
        echo $this->prepend;
        echo $this->menuPageHtml;
        echo "</{$this->container}>";
    }
}