<?php

namespace Wfm;

use Exception;
use JetBrains\PhpStorm\NoReturn;

abstract class Controller
{
    /**
     * @var array
     */
    public array $data = [];

    /**
     * @var array
     */
    public array $meta = ['title' => '', 'keywords' => '', 'description' => ''];

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

    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * @param $view
     * @param array $vars
     * @return void
     */
    #[NoReturn]
    public function loadView($view, array $vars = []): void
    {
        extract($vars);
        $prefix = str_replace('\\', '/', $this->route['admin_prefix']);
        require APP . "/views/$prefix{$this->route['controller']}/{$view}.php";
        die;
    }

    /**
     * @param string $folder
     * @param int $view
     * @param int $response
     * @return void
     */
    public function error_404(string $folder = 'Error', int $view = 404, int $response = 404): void
    {
        http_response_code($response);
        $this->setMeta(___('tpl_error_404'));
        $this->route['controller'] = $folder;
        $this->view = $view;
    }
}