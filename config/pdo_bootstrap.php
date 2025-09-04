<?php
/**
 * Minimal PDO Bootstrap Configuration
 * 
 * This file provides a simple PDO connection setup that can be included
 * in any part of the application that needs database access.
 */

// Database configuration with environment variable support
$config = [
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'port' => getenv('DB_PORT') ?: '3307',
    'db'   => getenv('DB_NAME') ?: 'teatar_zatebe',
    'user' => getenv('DB_USER') ?: 'tzt',
    'pass' => getenv('DB_PASS') ?: 'tztpass',
    'charset' => 'utf8mb4'
];

// PDO connection options
$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Create DSN string
$dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['db']};charset={$config['charset']}";

// Initialize PDO connection
try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], $pdoOptions);
    
    // Optional: Set timezone if needed
    // $pdo->exec("SET time_zone = '+00:00'");
    
} catch (PDOException $e) {
    // Log the error and throw a user-friendly exception
    error_log("Database connection failed: " . $e->getMessage());
    throw new Exception("Database connection failed. Please check your configuration.");
}

// Return the PDO instance for use in other files
return $pdo;
