<?php
/**
 * SIPKOS - Sistem Informasi Pengelolaan Kos
 * 
 * Entry Point Aplikasi
 * File ini adalah titik awal untuk semua request
 * 
 * @author SIPKOS Team
 * @version 1.0
 */

// ============================================
// SESSION START
// ============================================
session_start();

// ============================================
// DEFINE CONSTANTS
// ============================================

// Get the base URL dynamically so app works inside localhost subfolders
$base_protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$base_domain = $_SERVER['HTTP_HOST'];
$base_path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
if ($base_path === '//') {
    $base_path = '/';
}
define('BASE_URL', $base_protocol . '://' . $base_domain . $base_path);
define('ROUTE_URL', BASE_URL . 'index.php/');

// Define app path
define('APP', __DIR__ . '/app/');
define('CONFIG', __DIR__ . '/config/');
define('PUBLIC_PATH', __DIR__ . '/public/');
define('UPLOADS', PUBLIC_PATH . 'uploads/');

// ============================================
// ERROR HANDLING
// ============================================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================================
// AUTOLOAD CLASSES
// ============================================

// Simple autoloader untuk class-class inti
spl_autoload_register(function ($class) {
    // Check di app/core
    $file = APP . 'core/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }

    // Check di app/models
    $file = APP . 'models/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }

    // Check di config
    $file = CONFIG . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }
});

// ============================================
// LOAD CONFIGURATION
// ============================================
require_once CONFIG . 'database.php';

// ============================================
// CREATE ROUTER INSTANCE
// ============================================
$router = new Router();

// ============================================
// INCLUDE ROUTES
// ============================================
require_once 'routes/web.php';

// ============================================
// DISPATCH REQUEST
// ============================================
$router->dispatch();

?>
