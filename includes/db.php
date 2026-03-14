<?php
// db.php

// Function to load environment variables from .env file
function loadEnv($path) {
    if (!file_exists($path)) {
        die("Configuration file .env not found at: $path");
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments and empty lines
        if (strpos(trim($line), '#') === 0) continue;
        // Parse key=value
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        // Set as environment variable
        putenv("$name=$value");
    }
}

// Adjust the path to your .env file as needed (here it's assumed to be in the project root)
$envPath = __DIR__ . '/../.env';
loadEnv($envPath);

// Retrieve database credentials from environment variables
$host    = getenv('DB_HOST') ?: 'localhost';
$dbname  = getenv('DB_NAME') ?: 'your_database';
$username = getenv('DB_USER') ?: 'your_username';
$password = getenv('DB_PASS') ?: 'your_password';
$charset = 'utf8mb4';

// Build the DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch associative arrays by default
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Use native prepared statements if possible
];

// Create PDO instance
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Display an error message without exposing sensitive details in production.
    die("Database Connection Failed: " . $e->getMessage());
}
?>
