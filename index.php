<?php ini_set("display_errors", 1); ini_set("display_startup_errors", 1); error_reporting(E_ALL); ?>
<?php
// Load composer autoloader if it exists
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
      require_once __DIR__ . '/vendor/autoload.php';
  } //test
//tailwind : npm install -D tailwindcss@3 (v3)
// Load bootstrap file first - it defines all paths and environment
require_once __DIR__ . '/bootstrap.php';

// Load variables.php for backward compatibility
require_once LIB_PATH . '/variables.php';

// Load functions
require_once LIB_PATH . '/functions.php';

// Load kernel 
require_once CLASSES_PATH . '/Kernel.php';

if (isset($_GET['deconnexion'])) {
}
// require_once realpath(__DIR__ . '/vendor/autoload.php');

if (class_exists('Dotenv\Dotenv')) {
      $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
      $dotenv->load();

      // Retrieve environment variable user name if needed
      $userName = $_ENV['USER_NAME'] ?? 'default';
}

//Initialize loggedIn variable
global $db, $loggedIn;
$loggedIn = (isset($_SESSION['email']) && isset($_SESSION['roles']) && isset($_SESSION['idUtilisateur']) && isset($_SESSION['session_id'])) ? true : false;

if ($loggedIn && !in_array("Administrateur", $_SESSION['roles']))  $isAdmin = false;
elseif ($loggedIn && in_array("Administrateur", $_SESSION['roles'])) $isAdmin = true;
else $isAdmin = null;

// Initialize and run the application
$kernel = new Kernel();
$kernel->bootstrap();
