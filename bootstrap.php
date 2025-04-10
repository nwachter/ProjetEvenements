<?php
// bootstrap.php - Place this at the project root

// 1. Define the project root path (absolute)
define('PROJECT_ROOT', __DIR__);

// 2. Determine environment
// In production with Docker, set this environment variable in your Dockerfile/docker-compose
$env = getenv('APP_ENV') ?: 'development';

// 3. Set up path constants
define('SRC_PATH', PROJECT_ROOT . '/src');
define('CONFIG_PATH', SRC_PATH . '/config');
define('LIB_PATH', SRC_PATH . '/lib');
define('TEMPLATES_PATH', SRC_PATH . '/templates');
define('TEMPLATE_PARTS_PATH', SRC_PATH . '/templates/template-parts');
define('PAGES_PATH', SRC_PATH . '/templates/pages');
define('CLASSES_PATH', SRC_PATH . '/classes');
define('ASSETS_PATH', PROJECT_ROOT . '/public/assets');
define('FONCTIONS_PATH', SRC_PATH . '/fonctions');
define('MODELS_PATH', SRC_PATH . '/models');

// 4. Set up URL and global paths
$rootUrl = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$basePath = dirname($_SERVER['SCRIPT_NAME']);
if ($basePath === '\\' || $basePath === '/') {
    $basePath = '';
}
define('BASE_URL', $rootUrl . $basePath);

// 5. Define global variables for backward compatibility
$GLOBALS['rootPath'] = PROJECT_ROOT;
$GLOBALS['rootUrl'] = BASE_URL;
$GLOBALS['currentPath'] = $_SERVER['SCRIPT_FILENAME'] ?? '';
$GLOBALS['totalPagesEvents'] = 0;
$GLOBALS['totalPagesActiveEvents'] = 0;
$GLOBALS['totalPagesInactiveEvents'] = 0;
$GLOBALS['totalPagesUsers'] = 0;

// 6. Start session
// session_cache_expire(120);
// ini_set('session.gc_maxlifetime', 120 * 60);
// session_set_cookie_params(120 * 60);
// session_start();

// 7. Define page routes
if (!defined("HOMEPAGE")) {
    define("HOMEPAGE", "accueil");
}

if (!defined("NOT_FOUND_ROUTE")) {
    define("NOT_FOUND_ROUTE", "notFound");
}

// Optional: Error reporting setup
if ($env === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Load composer autoloader if it exists
if (file_exists(PROJECT_ROOT . '/vendor/autoload.php')) {
    require_once PROJECT_ROOT . '/vendor/autoload.php';
}

// Define global login status
$GLOBALS['loggedIn'] = (isset($_SESSION['email']) && isset($_SESSION['roles']) && isset($_SESSION['idUtilisateur']) && isset($_SESSION['session_id'])) ? true : false;
$GLOBALS['message'] = "";
$GLOBALS['error_message'] = "";

// Check if user is admin
if ($GLOBALS['loggedIn'] && !in_array("Administrateur", $_SESSION['roles'])) {
    $GLOBALS['isAdmin'] = false;
} elseif ($GLOBALS['loggedIn'] && in_array("Administrateur", $_SESSION['roles'])) {
    $GLOBALS['isAdmin'] = true;
} else {
    $GLOBALS['isAdmin'] = null;
}

// Initialize database connection
require_once CLASSES_PATH . '/Database.php';
$GLOBALS['db'] = Database::getInstance()->getConnection();
