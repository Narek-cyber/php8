<?php

namespace Wfm;

use Exception;

class View
{
    /**
     * @var string
     */
    public string $content = '';

    /**
     * @param $route
     * @param string $layout
     * @param string $view
     * @param array $meta
     */
    public function __construct(
        public        $route,
        public string $layout = '',
        public string $view = '',
        public array  $meta = [],
    )
    {
        if (false !== $this->layout) {
            $this->layout = $this->layout ?: LAYOUT;
        }
    }

    /**
     * @param $data
     * @return void
     * @throws Exception
     */
    public function render($data): void
    {
        if (is_array($data)) {
            extract($data);
        }

        $prefix = str_replace('\\', '/', $this->route['admin_prefix']);
        $view_file = APP . "/views/$prefix{$this->route['controller']}/$this->view.php";

        if (is_file($view_file)) {
            ob_start();
            require_once $view_file;
            $this->content = ob_get_clean();
        } else {
            throw new Exception("View not found $view_file", 500);
        }

        if (false !== $this->layout) {
            $layout_file = APP . "/views/layouts/$this->layout.php";
            if (is_file($layout_file)) {
                require_once $layout_file;
            } else {
                throw new Exception("Template not found $layout_file", 500);
            }
        }
    }
}