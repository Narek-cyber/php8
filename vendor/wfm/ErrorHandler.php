<?php

namespace wfm;

use JetBrains\PhpStorm\NoReturn;
use Throwable;

class ErrorHandler
{
    public function __construct()
    {
        // https://habr.com/ru/post/161483/
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    /**
     * @param $errNo
     * @param $errStr
     * @param $errFile
     * @param $errLine
     * @return void
     */
    #[NoReturn]
    public function errorHandler($errNo, $errStr, $errFile, $errLine): void
    {
        $this->logError($errStr, $errFile, $errLine);
        $this->displayError($errNo, $errStr, $errFile, $errLine);
    }

    /**
     * @return void
     */
    public function fatalErrorHandler(): void
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            $this->logError($error['message'], $error['file'], $error['line']);
            ob_end_clean();
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }

    /**
     * @param Throwable $e
     * @return void
     */
    #[NoReturn]
    public function exceptionHandler(Throwable $e): void
    {
        $this->logError($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError('Exception', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    /**
     * @param string $message
     * @param string $file
     * @param string $line
     * @return void
     */
    protected function logError(string $message = '', string $file = '', string $line = ''): void
    {
        if (!is_dir(LOGS)) {
            mkdir(LOGS, 0755, true);
        }

        $logFile = LOGS . '/errors.log';
        $logMessage = "[" . date('Y-m-d H:i:s') . "] "
            . "Error message: $message | File: $file | Line: $line\n"
            . "=================\n";

        file_put_contents(
            $logFile,
            $logMessage,
            FILE_APPEND,
        );
    }

    /**
     * @param $errNo
     * @param $errStr
     * @param $errFile
     * @param $errLine
     * @param int $response
     * @return void
     */
    #[NoReturn]
    protected function displayError($errNo, $errStr, $errFile, $errLine, int $response = 500): void
    {
        if ($response == 0) {
            $response = 404;
        }
        http_response_code($response);
        if ($response == 404 && !DEBUG) {
            require WWW . '/errors/404.php';
            die;
        }
        if (DEBUG) {
            require WWW . '/errors/development.php';
        } else {
            require WWW . '/errors/production.php';
        }
        die;
    }
}