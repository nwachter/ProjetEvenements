#!/bin/bash

echo "===== PHP Environment Variables Checker ====="
echo "Checking environment variables and configuration..."
echo "Script execution directory: $(pwd)" # Good to know where the script is run from

# Create a temporary PHP script to dump variables
cat > env_check.php << 'EOF'
<?php
echo "===== Environment Variables Check =====\n\n";

// Get the directory where this temporary script is located (project root)
$projectRoot = __DIR__;
echo "-==================================================================================================== Project Root (__DIR__): " . $projectRoot . "\n\n";

// --- File Existence Check ---
echo "File Existence Check:\n";
echo "- src/config/environment.php exists: " . (file_exists($projectRoot.'/src/config/environment.php') ? "YES" : "NO") . "\n";
echo "- .env exists:                     " . (file_exists($projectRoot.'/.env') ? "YES" : "NO") . "\n";
echo "- .env.db exists:                " . (file_exists($projectRoot.'/.env.db') ? "YES" : "NO") . "\n";
echo "- db/password.txt exists:          " . (file_exists($projectRoot . '/db/password.txt') ? "YES" : "NO") . "\n\n";

// --- Autoloader Check ---
$autoloaderPath = $projectRoot . '/vendor/autoload.php';
if (file_exists($autoloaderPath)) {
    echo "Found autoloader: $autoloaderPath. Including it.\n";
    require $autoloaderPath;
} else {
    echo "Warning: Composer autoloader not found at $autoloaderPath. Dotenv might not work if not manually included.\n";
}
echo "\n";

// --- Environment Configuration File (environment.php) ---
$environmentConfigFile = $projectRoot.'/src/config/environment.php';
$environmentVars = null; // Initialize
if (file_exists($environmentConfigFile)) {
    echo "Loading environment.php content:\n";
    // Use try-catch in case the file has syntax errors or doesn't return an array
    try {
        $environmentVars = require($environmentConfigFile);
        if (is_array($environmentVars)) {
            var_export($environmentVars);
            echo "\n";
        } else {
            echo "Warning: environment.php did not return an array.\n";
            $environmentVars = null; // Reset if invalid
        }
    } catch (\Throwable $e) {
        echo "Error loading environment.php: " . $e->getMessage() . "\n";
        $environmentVars = null; // Reset on error
    }
} else {
    echo "environment.php not found.\n";
}
echo "\n";

// --- Dotenv Loading ---
// Check if the Dotenv class exists AFTER attempting to load the autoloader
$dotenvAvailable = class_exists('Dotenv\Dotenv');
echo "Dotenv class available: " . ($dotenvAvailable ? "YES" : "NO") . "\n";

if ($dotenvAvailable) {
    try {
        // Load main .env file if it exists
        if (file_exists($projectRoot.'/.env')) {
            $dotenv = Dotenv\Dotenv::createImmutable($projectRoot);
            $dotenv->load();
            echo ".env variables loaded successfully.\n";
        } else {
            echo ".env file not found, skipping.\n";
        }

        // Load .env.db file if it exists
        if (file_exists($projectRoot.'/.env.db')) {
            // Use createImmutable to load into $_ENV/$_SERVER without overwriting existing system vars
            $dbEnv = Dotenv\Dotenv::createImmutable($projectRoot, '.env.db');
            $dbEnv->load();
            echo ".env.db variables loaded successfully.\n";
        } else {
            echo ".env.db file not found, skipping.\n";
        }
    } catch (\Dotenv\Exception\InvalidPathException $e) {
        echo "Dotenv Error: Invalid path - " . $e->getMessage() . "\n";
    } catch (\Dotenv\Exception\InvalidFileException $e) {
        echo "Dotenv Error: Invalid file format - " . $e->getMessage() . "\n";
    } catch (\Throwable $e) { // Catch any other potential Dotenv errors
        echo "Dotenv Error: An unexpected error occurred - " . $e->getMessage() . "\n";
    }
} else {
    echo "Dotenv class not found, skipping Dotenv loading.\n";
}
echo "\n";


// --- Display All Environment Variables (from $_ENV) ---
echo "Current Environment Variables (\$_ENV):\n";
if (empty($_ENV)) {
    echo "No environment variables found in \$_ENV.\n";
} else {
    // Sort keys for consistent output
    ksort($_ENV);
    foreach ($_ENV as $key => $value) {
        // Hide potentially sensitive values for security
        if (stripos($key, 'password') !== false || stripos($key, 'pass') !== false || stripos($key, 'secret') !== false || stripos($key, 'token') !== false) {
            echo "- $key: [HIDDEN]\n";
        } else {
            // Ensure value is printable, truncate long values if needed
            $displayValue = is_string($value) || is_numeric($value) ? $value : ('[' . gettype($value) . ']');
            if (is_string($displayValue) && strlen($displayValue) > 100) {
                $displayValue = substr($displayValue, 0, 97) . '...';
            }
            echo "- $key: $displayValue\n";
        }
    }
}
echo "\n";

// --- Resolve Final Database Connection Values ---
echo "Resolved Database Connection Values:\n";

// Get environment from APP_ENV, default to 'production'
$env = $_ENV['APP_ENV'] ?? 'production';
echo "Active environment (APP_ENV): $env\n";

// Get config section based on environment
$config = []; // Initialize empty config
$configSource = "NONE"; // Track where config came from
if (isset($environmentVars) && is_array($environmentVars)) {
    if (isset($environmentVars[$env])) {
        $config = $environmentVars[$env];
        $configSource = "environment.php [$env]";
    } elseif (isset($environmentVars['development'])) {
        $config = $environmentVars['development'];
        $configSource = "environment.php [development fallback]";
    } else {
         $configSource = "environment.php (key '$env' or 'development' not found)";
    }
    echo "Using configuration from: $configSource\n";
} else {
    echo "Warning: No valid configuration loaded from environment.php\n";
}

// Determine database parameters with priority: config -> environment -> default

// User
$dbUser = $config['db_user'] ?? $_ENV['MYSQL_USER'] ?? $_ENV['DB_USER'] ?? 'default_user';
$userSource = isset($config['db_user']) ? $configSource :
             (isset($_ENV['MYSQL_USER']) ? '$_ENV[MYSQL_USER]' :
             (isset($_ENV['DB_USER']) ? '$_ENV[DB_USER]' : 'Default'));
echo "- db_user: $dbUser (Source: $userSource)\n";

// Password (Check sources, but don't display password itself)
$passFile = $projectRoot . '/db/password.txt';
$passwordSource = "NONE"; // Default assumption
$actualPassword = null;   // We won't display this, but could use it internally if needed

// Priority: password.txt -> MYSQL_PASSWORD -> DB_PASSWORD -> config[db_password] -> default
if (file_exists($passFile) && is_readable($passFile)) {
    $passwordFromFile = trim(file_get_contents($passFile));
    if (!empty($passwordFromFile)) {
        $passwordSource = "db/password.txt";
        $actualPassword = $passwordFromFile; // We *could* use this value now
    } else {
         $passwordSource = "db/password.txt (but file is empty)";
    }
} elseif (isset($_ENV['MYSQL_PASSWORD'])) {
    $passwordSource = '$_ENV[MYSQL_PASSWORD]';
    $actualPassword = $_ENV['MYSQL_PASSWORD'];
} elseif (isset($_ENV['DB_PASSWORD'])) {
    $passwordSource = '$_ENV[DB_PASSWORD]';
    $actualPassword = $_ENV['DB_PASSWORD'];
} elseif (isset($config['db_password'])) {
    $passwordSource = "$configSource [db_password]";
    $actualPassword = $config['db_password'];
} else {
    $passwordSource = "No password found (checked file, env vars, config)";
}
echo "- db_password: [" . ($actualPassword !== null ? "SET" : "NOT SET") . "] (Source: $passwordSource)\n";


// Host
$dbHost = $config['db_host'] ?? $_ENV['MYSQL_HOST'] ?? $_ENV['DB_HOST'] ?? 'db'; // Common Docker default
$hostSource = isset($config['db_host']) ? $configSource :
             (isset($_ENV['MYSQL_HOST']) ? '$_ENV[MYSQL_HOST]' :
             (isset($_ENV['DB_HOST']) ? '$_ENV[DB_HOST]' : 'Default'));
echo "- db_host: $dbHost (Source: $hostSource)\n";

// Database Name
$dbName = $config['db_name'] ?? $_ENV['MYSQL_DATABASE'] ?? $_ENV['DB_DATABASE'] ?? 'default_db';
$dbNameSource = isset($config['db_name']) ? $configSource :
               (isset($_ENV['MYSQL_DATABASE']) ? '$_ENV[MYSQL_DATABASE]' :
               (isset($_ENV['DB_DATABASE']) ? '$_ENV[DB_DATABASE]' : 'Default'));
echo "- db_name: $dbName (Source: $dbNameSource)\n";


echo "\n===== Check Complete =====\n";
?>
EOF

# Run the temporary PHP script
if command -v php &> /dev/null; then
    echo "Running PHP check script..."
    php env_check.php
    # Check the exit code of the PHP script
    if [ $? -ne 0 ]; then
        echo "Error: PHP script execution failed."
    fi
else
    echo "Error: PHP command not found. Please ensure PHP CLI is installed and in your system's PATH."
    # Optional: Exit the bash script if PHP isn't found
    # exit 1
fi

# Clean up the temporary PHP script
if [ -f env_check.php ]; then
    echo "Cleaning up temporary script..."
    rm env_check.php
fi

echo "===== Script Finished ====="