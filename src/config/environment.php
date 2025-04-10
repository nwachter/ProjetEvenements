<?php
// config/environment.php - Create this new file
// This will be your environment-specific configuration
return [
    'development' => [
        'base_url' => 'http://localhost/ProjetEvenements', // Adjust this for your local setup
        'db_host' => 'localhost',
        'db_name' => 'projetevenements',
        'db_user' => 'nina',
        'db_pass' => 'wachter18',
    ],
    'production' => [
        'base_url' => 'https:/localhost:8080', // Will be set in Docker
        'db_host' => 'db', // Docker service name
        'db_name' => 'projetevenements',
        'db_user' => 'nina',
        'db_pass' => 'wachter18',
    ],
];
