<?php
$config = [
  'host' => getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? 'localhost',
  'port' => getenv('DB_PORT') ?: $_ENV['DB_PORT'] ?? '3306',
  'db'   => getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? 'teatar_zatebe',
  'user' => getenv('DB_USER') ?: $_ENV['DB_USER'] ?? 'root',
  'pass' => getenv('DB_PASS') ?: $_ENV['DB_PASS'] ?? '',
  'charset' => 'utf8mb4'
];

$dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['db']};charset={$config['charset']}";

try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    
    // Verify we have a valid PDO object
    if (!$pdo || !($pdo instanceof PDO)) {
        throw new Exception("PDO connection failed - invalid object returned");
    }
    
    return $pdo;
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    throw new Exception("Failed to connect to database: " . $e->getMessage());
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    throw $e;
}