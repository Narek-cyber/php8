<?php
use Wfm\ErrorHandler;
/**
 * @var $errNo ErrorHandler
 * @var $errStr ErrorHandler
 * @var $errFile ErrorHandler
 * @var $errLine ErrorHandler
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
</head>
<body>
<h1>An error occurred</h1>
<p><b>Error code:</b> <?= $errNo ?></p>
<p><b>Error text:</b> <?= $errStr ?></p>
<p><b>The file in which the error occurred:</b> <?= $errFile ?></p>
<p><b>The line where the error occurred:</b> <?= $errLine ?></p>
</body>
</html>
