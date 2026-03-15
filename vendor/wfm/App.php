<?php

namespace Wfm;

use Exception;

class App
{
    /**
     * @var Registry
     */
    public static Registry $app;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $query = trim(urldecode($_SERVER['QUERY_STRING']), '/');
        new ErrorHandler();
        session_start();
        self::$app = Registry::getInstance();
        $this->getParams();
        Router::dispatch($query);
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