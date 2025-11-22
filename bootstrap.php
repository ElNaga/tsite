<?php
/**
 * Bootstrap file for database connection
 * Returns a PDO instance for database operations
 * 
 * Uses environment variables for configuration:
 * - DB_HOST (default: 'mysql' in Docker, '127.0.0.1' locally)
 * - DB_PORT (default: '3306')
 * - DB_NAME (default: 'teatar_zatebe')
 * - DB_USER (default: 'tzt')
 * - DB_PASS (default: 'tztpass')
 */

// Get database configuration from environment variables
$host = getenv('DB_HOST') ?: (getenv('MYSQL_HOST') ?: '127.0.0.1');
$port = getenv('DB_PORT') ?: (getenv('MYSQL_PORT') ?: '3306');
$dbname = getenv('DB_NAME') ?: (getenv('MYSQL_DATABASE') ?: 'teatarzatebe');
$username = getenv('DB_USER') ?: (getenv('MYSQL_USER') ?: 'teatarzatebe');
$password = getenv('DB_PASS') ?: (getenv('MYSQL_PASSWORD') ?: 'nEM424bTMiGi7L3');
$charset = 'utf8mb4';

// In Docker, if DB_HOST is not set, default to 'mysql' (container name)
if ($host === '127.0.0.1' && getenv('DB_HOST') === false && getenv('MYSQL_HOST') === false) {
    // Check if we're likely in Docker (common Docker indicators)
    if (file_exists('/.dockerenv') || getenv('HOSTNAME') !== false) {
        $host = 'mysql';
    }
}

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";
    
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    
    // Ensure UTF-8 is set on the connection
    $pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("SET CHARACTER SET utf8mb4");
    
    return $pdo;
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    error_log("Connection details: host={$host}, port={$port}, db={$dbname}, user={$username}");
    throw new Exception("Database connection failed: " . $e->getMessage());
}
