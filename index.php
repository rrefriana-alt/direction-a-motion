<?php
// Proxy untuk Shared Hosting
$_SERVER['SCRIPT_NAME'] = '/public/direction-a-motion/index.php';
$_SERVER['PHP_SELF']    = '/public/direction-a-motion/index.php';

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use Illuminate\Http\Request;
$app->handleRequest(Request::capture());