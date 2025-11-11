<?php
// Enable error display
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Connection Debug</h2>";

// Test environment variables
echo "<h3>Environment Variables:</h3>";
echo "DB_HOST: " . (getenv('DB_HOST') ?: 'NOT SET') . "<br>";
echo "DB_PORT: " . (getenv('DB_PORT') ?: 'NOT SET') . "<br>";
echo "DB_NAME: " . (getenv('DB_NAME') ?: 'NOT SET') . "<br>";
echo "DB_USER: " . (getenv('DB_USER') ?: 'NOT SET') . "<br>";
echo "DB_PASS: " . (getenv('DB_PASS') ?: 'NOT SET (empty)') . "<br>";

echo "<h3>Trying to connect...</h3>";

$config = [
  'host' => getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? 'localhost',
  'port' => getenv('DB_PORT') ?: $_ENV['DB_PORT'] ?? '3306',
  'db'   => getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? 'teatar_zatebe',
  'user' => getenv('DB_USER') ?: $_ENV['DB_USER'] ?? 'root',
  'pass' => getenv('DB_PASS') ?: $_ENV['DB_PASS'] ?? '',
  'charset' => 'utf8mb4'
];

echo "Using config:<br>";
echo "Host: {$config['host']}<br>";
echo "Port: {$config['port']}<br>";
echo "Database: {$config['db']}<br>";
echo "User: {$config['user']}<br>";
echo "Password: " . (empty($config['pass']) ? '(empty)' : '***') . "<br>";

$dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['db']};charset={$config['charset']}";

echo "<h3>Connection String:</h3>";
echo $dsn . "<br><br>";

try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    
    echo "<h3 style='color: green;'>✅ Connection Successful!</h3>";
    echo "PDO version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "<br>";
    
    // Try a simple query
    $stmt = $pdo->query("SELECT DATABASE() as db");
    $result = $stmt->fetch();
    echo "Current database: " . $result['db'] . "<br>";
    
} catch (PDOException $e) {
    echo "<h3 style='color: red;'>❌ Connection Failed!</h3>";
    echo "Error Code: " . $e->getCode() . "<br>";
    echo "Error Message: " . $e->getMessage() . "<br>";
    echo "<br><strong>Possible fixes:</strong><br>";
    echo "1. Check if MySQL is running<br>";
    echo "2. Check if database '{$config['db']}' exists<br>";
    echo "3. Check username/password<br>";
    echo "4. Check if port {$config['port']} is correct<br>";
} catch (Exception $e) {
    echo "<h3 style='color: red;'>❌ Error!</h3>";
    echo "Error: " . $e->getMessage() . "<br>";
}
?>


