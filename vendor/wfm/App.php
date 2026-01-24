<?php

namespace wfm;

class App
{
    /**
     * @var Registry
     */
    public static Registry $app;

    public function __construct()
    {
        self::$app = Registry::getInstance();
        $this->getParams();
    }

    /**
     * @return void
     */
    protected function getParams(): void
    {
        $params = require_once CONFIG . '/params.php';
        if (!empty($params)) {
            foreach ($params as $k => $v) {
                self::$app->setProperty($k, $v);
            }
        }
    }
}