<?php


$rootPath = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';
$rootUrl = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/ProjetEvenements';
$rootPath = $rootPath . '/ProjetEvenements';
$GLOBALS['rootPath'] = $_SERVER['DOCUMENT_ROOT'] . '/ProjetEvenements';
$GLOBALS['rootUrl'] = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/ProjetEvenements';
$GLOBALS['currentPath'] = $rootPath . $_SERVER['PHP_SELF'];

$GLOBALS['totalPagesEvents'] = 0;
$GLOBALS['totalPagesActiveEvents'] = 0;
$GLOBALS['totalPagesInactiveEvents'] = 0;

$GLOBALS['totalPagesUsers'] = 0;
global $message;
global $error_message;


if (!defined("SRC")) {
    define("SRC", $GLOBALS['rootPath'] . "/src");
}

if (!defined("TEMPLATES")) {
    define("TEMPLATES", SRC . "/templates");
}

if (!defined("TEMPLATE_PARTS")) {
    define("TEMPLATE_PARTS", $GLOBALS['rootPath'] . "/src/templates/template-parts");
}

if (!defined("PAGES")) {
    define("PAGES", $GLOBALS['rootPath'] . "/src/templates/pages");
}

if (!defined("ASSETS")) {
    define("ASSETS", $GLOBALS['rootPath'] . "/public/assets");
}

if (!defined("FONCTIONS")) {
    define("FONCTIONS", $GLOBALS['rootPath'] . "/src/fonctions");
}

if (!defined("LIB")) {
    define("LIB", $GLOBALS['rootPath'] . "/src/lib");
}

if (!defined("CLASSES")) {
    define("CLASSES", $GLOBALS['rootPath'] . "/src/classes");
}

if (!defined("ROUTES")) {
    define("ROUTES", include SRC . "/config/routes.php");
}

if (!defined("CONFIG")) {
    define("CONFIG", SRC . "/config/config.php");
}

if (!defined("HOMEPAGE")) {
    define("HOMEPAGE", "home");
}

if (!defined("NOT_FOUND_ROUTE")) {
    define("NOT_FOUND_ROUTE", "404");
}
