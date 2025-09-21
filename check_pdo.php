<?php
// PDO MySQL Extension Checker
echo "<h2>PHP PDO MySQL Extension Check</h2>";

// Check PHP version
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";

// Check if PDO is loaded
if (extension_loaded('pdo')) {
    echo "<p>✅ <strong>PDO Extension:</strong> Loaded</p>";
} else {
    echo "<p>❌ <strong>PDO Extension:</strong> NOT Loaded</p>";
}

// Check available PDO drivers
$drivers = PDO::getAvailableDrivers();
echo "<p><strong>Available PDO Drivers:</strong> ";
if (empty($drivers)) {
    echo "❌ None available</p>";
} else {
    echo "✅ " . implode(', ', $drivers) . "</p>";
}

// Check specifically for MySQL
if (in_array('mysql', $drivers)) {
    echo "<p>✅ <strong>PDO MySQL Driver:</strong> Available</p>";
} else {
    echo "<p>❌ <strong>PDO MySQL Driver:</strong> NOT Available</p>";
}

// Test connection if possible
if (in_array('mysql', $drivers)) {
    echo "<h3>Database Connection Test</h3>";
    try {
        // Use environment variables or defaults
        $host = getenv('DB_HOST') ?: 'localhost';
        $port = getenv('DB_PORT') ?: '3306';
        $dbname = getenv('DB_NAME') ?: 'test';
        $username = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASS') ?: '';
        
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        
        echo "<p>✅ <strong>Database Connection:</strong> Successful</p>";
        echo "<p><strong>Server Version:</strong> " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "</p>";
        
    } catch (PDOException $e) {
        echo "<p>❌ <strong>Database Connection:</strong> Failed - " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><em>Note: This might be due to incorrect credentials or database not existing yet.</em></p>";
    }
} else {
    echo "<p><em>Cannot test database connection - PDO MySQL driver not available.</em></p>";
}

// Show loaded extensions
echo "<h3>Loaded Extensions</h3>";
$extensions = get_loaded_extensions();
sort($extensions);
echo "<p>" . implode(', ', $extensions) . "</p>";

// Show php.ini location
echo "<h3>Configuration</h3>";
echo "<p><strong>php.ini location:</strong> " . php_ini_loaded_file() . "</p>";
echo "<p><strong>Additional ini files:</strong> " . php_ini_scanned_files() . "</p>";
?>
