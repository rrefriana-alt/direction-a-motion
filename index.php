<?php
/**
 * Subdirectory hosting proxy for Hostinger shared hosting.
 *
 * Root problem: Apache mod_rewrite internally routes requests to public/index.php,
 * but REQUEST_URI stays as /public/direction-a-motion/services while SCRIPT_NAME
 * becomes /public/direction-a-motion/public/index.php.
 * Symfony cannot reconcile these two paths, so it computes the wrong route.
 *
 * Fix: Set SCRIPT_NAME to match the APPARENT location (this file) so Symfony
 * correctly strips /public/direction-a-motion/ from the REQUEST_URI,
 * leaving just the route (e.g. "services", "about", etc.).
 */
$_SERVER['SCRIPT_NAME'] = '/public/direction-a-motion/index.php';
$_SERVER['PHP_SELF']    = '/public/direction-a-motion/index.php';

// --- Bootstrap Laravel (same as public/index.php but with corrected paths) ---
define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use Illuminate\Http\Request;
$app->handleRequest(Request::capture());