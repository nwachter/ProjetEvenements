<?php


// $rootPath = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';
// $rootUrl = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/ProjetEvenements';
// $rootPath = $rootPath . '/ProjetEvenements';
// $GLOBALS['rootPath'] = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';
// $GLOBALS['rootUrl'] = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/ProjetEvenements';
// $GLOBALS['currentPath'] = $rootPath . $_SERVER['PHP_SELF'];

// $GLOBALS['totalPagesEvents'] = 0;
// $GLOBALS['totalPagesActiveEvents'] = 0;
// $GLOBALS['totalPagesInactiveEvents'] = 0;

// $GLOBALS['totalPagesUsers'] = 0;
global $message;
global $error_message;


// Compatibility constants - these will use the definitions from bootstrap.php
if (!defined("SRC")) {
    define("SRC", SRC_PATH);
}

if (!defined("TEMPLATES")) {
    define("TEMPLATES", TEMPLATES_PATH);
}

if (!defined("TEMPLATE_PARTS")) {
    define("TEMPLATE_PARTS", TEMPLATE_PARTS_PATH);
}

if (!defined("PAGES")) {
    define("PAGES", PAGES_PATH);
}

if (!defined("ASSETS")) {
    define("ASSETS", ASSETS_PATH);
}

if (!defined("FONCTIONS")) {
    define("FONCTIONS", FONCTIONS_PATH);
}

if (!defined("LIB")) {
    define("LIB", LIB_PATH);
}

if (!defined("CLASSES")) {
    define("CLASSES", CLASSES_PATH);
}

// Load routes from config file - fix the path issue
if (!defined("ROUTES")) {
    if (file_exists(CONFIG_PATH . '/routes.php')) {
        define("ROUTES", include CONFIG_PATH . '/routes.php');
    } else {
        die('Required file not found: ' . CONFIG_PATH . '/routes.php');
    }
}

if (!defined("CONFIG")) {
    define("CONFIG", CONFIG_PATH . '/config.php');
}

// These were already defined in bootstrap.php but adding here for completeness
if (!defined("HOMEPAGE")) {
    define("HOMEPAGE", "home");
}

if (!defined("NOT_FOUND_ROUTE")) {
    define("NOT_FOUND_ROUTE", "404");
}
