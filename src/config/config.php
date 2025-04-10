<?php
try {
    $environmentVars = require('./config/environment.php');
    
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
        $userName = $_ENV['APP_USER'] ?? 'default';
        $env = $_ENV['APP_ENV'] ?? 'development';
        
        // Get environment-specific configuration
        $config = $environmentVars[$env] ?? $environmentVars['development'];
        
        // Get the password from file
        $passFile = __DIR__ . '/../db/password.txt';
        $pass = file_exists($passFile) ? trim(file_get_contents($passFile)) : '';
        
      
    // If password file can't be read, try environment variable
    if (empty($pass) && isset($_ENV['MYSQL_PASSWORD'])) {
        $pass = $_ENV['MYSQL_PASSWORD'];
    }
    
    $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8";
    
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

require_once SRC . '/config/customConfig.php';