<?php

namespace Wfm;

use Exception;

abstract class Controller
{
    /**
     * @var array
     */
    public array $data = [];
    /**
     * @var array
     */
    public array $meta = [];
    /**
     * @var false|string
     */
    public false|string $layout = '';
    /**
     * @var string
     */
    public string $view = '';
    /**
     * @var object
     */
    public object $model;

    /**
     * @param array $route
     */
    public function __construct(public array $route = [])
    {

    }

    /**
     * @return void
     */
    public function getModel(): void
    {
        $model = 'App\Models\\' . $this->route['admin_prefix'] . $this->route['controller'];
        if (class_exists($model)) {
            $this->model = new $model();
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function getView(): void
    {
        $this->view = $this->view ?: $this->route['action'];
        (new View($this->route, $this->layout, $this->view, $this->meta))->render($this->data);
    }

    /**
     * @param $data
     * @return void
     */
    public function set($data): void
    {
        $this->data = $data;
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $keywords
     * @return void
     */
    public function setMeta(
        string $title = '',
        string $description = '',
        string $keywords = ''
    ): void
    {
        $this->meta = [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
        ];
    }
}