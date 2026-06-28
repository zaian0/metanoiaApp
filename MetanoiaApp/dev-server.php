<?php

// Dev-only router for PHP's built-in server, used when previewing under a
// sandbox that blocks chdir/getcwd (so Laravel's default server.php can't run).
// Launch:  php -S 127.0.0.1:8090 -t public dev-server.php
// Not used in production.

$publicPath = __DIR__.'/public';

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '');

// Serve existing static files (built assets, images, brand) directly.
if ($uri !== '/' && file_exists($publicPath.$uri)) {
    return false;
}

require_once $publicPath.'/index.php';
