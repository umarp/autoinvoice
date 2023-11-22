<?php

// Database connection parameters
$host = 'localhost';
$db   = 'autoinvoice';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Create a Data Source Name (DSN) for the PDO connection
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// PDO connection options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Set the error mode to throw exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // Set the default fetch mode to associative array
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Disable emulated prepared statements
];

// Try to establish a PDO connection
try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);

    // If the connection is successful, print a success message
    echo "Connected successfully";
} catch (\PDOException $e) {
    // If an exception occurs during the connection attempt, throw a PDOException
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>
