<?php
try {
    $environmentVars = require(__DIR__.'/environment.php');

    if (class_exists('Dotenv\Dotenv')) {
        // Load main .env file
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        // Additionally load .env.db file if it exists
        if (file_exists(__DIR__ . '/.env.db')) {
            $dbEnv = Dotenv\Dotenv::createImmutable(__DIR__, '.env.db');
            $dbEnv->load();
        }

        // Retrieve environment variables
        $env = $_ENV['APP_ENV'] ?? 'production';

        // Get environment-specific configuration
        $config = $environmentVars[$env] ?? $environmentVars['development'];

        // Get database username - should be from config or env var
        $user = $config['db_user'] ?? $_ENV['MYSQL_USER'] ?? 'nina';

        // Get the password from file
       # $passFile = __DIR__ . '/../../db/password.txt';
              # $pass = file_exists($passFile) ? trim(file_get_contents($passFile)) : '';

        // If password file can't be read, try environment variable
        if (empty($pass) && isset($_ENV['MYSQL_PASSWORD'])) {
            $pass = $_ENV['MYSQL_PASSWORD'];
        }

        // Get database connection parameters
//        $host = $config['db_host'] ?? 'db';

        //        $host = $config['db_host'] ?? 'db';
      $db_name = $config['db_name'] ?? 'projetevenements';

        $host = 'db';
        $db_name = 'projetevenements';
        $port = '3306';

        //        $port = $config['db_port'] ?? '3306';


        $dsn = "mysql:host=$host;port=$port;dbname=$db_name;charset=utf8";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        global $db;
        $db = new PDO($dsn, $user, $pass, $options);

    }
} catch (Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}

//require_once SRC . '/config/customConfig.php';
