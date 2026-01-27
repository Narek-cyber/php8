<?php

namespace Wfm;

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

    public function __construct(public $route = [])
    {

    }

    /**
     * @return void
     */
    public function getModel(): void
    {
        $model = 'app\Models\\' . $this->route['admin_prefix'] . $this->route['controller'];
        if (class_exists($model)) {
            $this->model = new $model();
        }
    }

    /**
     * @return void
     */
    public function getView(): void
    {
        $this->view = $this->view ?: $this->route['action'];

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