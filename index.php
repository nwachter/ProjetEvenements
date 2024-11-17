<?php
require_once './src/lib/variables.php';
// require_once './src/config/config.php';   
require_once LIB . '/functions.php';
require_once CLASSES . '/Kernel.php';
require_once CLASSES . '/Database.php';
require_once realpath(__DIR__ . '/vendor/autoload.php');

if (isset($_GET['deconnexion'])) {
      //deconnexion();								
}

global $db, $loggedIn;
// Cherche le env dans le dossier racine

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Récupération de la variable d'environnement user name
$userName = $_ENV['USER_NAME'];
$echoPrefix =  "index.php";

echo  $echoPrefix . $userName; //jfBiswajit
$loggedIn = (isset($_SESSION['email']) && isset($_SESSION['roles']) && isset($_SESSION['idUtilisateur']) && isset($_SESSION['session_id'])) ? true : false;

if ($loggedIn && !in_array("Administrateur", $_SESSION['roles']))  $isAdmin = false;
elseif ($loggedIn && in_array("Administrateur", $_SESSION['roles'])) $isAdmin = true;
else $isAdmin = null;

$db = Database::getInstance()->getConnection();
$kernel = new Kernel();
$kernel->bootstrap();
