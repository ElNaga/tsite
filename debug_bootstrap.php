<?php
/**
 * Debug Bootstrap Connection
 * This will help us see exactly what's happening with the database connection
 */

echo "<h1>🔍 Debugging Bootstrap Connection</h1>";

try {
    echo "<h2>1. Environment Variables</h2>";
    echo "<p>DB_HOST: " . (getenv('DB_HOST') ?: 'NOT SET') . "</p>";
    echo "<p>DB_PORT: " . (getenv('DB_PORT') ?: 'NOT SET') . "</p>";
    echo "<p>DB_NAME: " . (getenv('DB_NAME') ?: 'NOT SET') . "</p>";
    echo "<p>DB_USER: " . (getenv('DB_USER') ?: 'NOT SET') . "</p>";
    echo "<p>DB_PASS: " . (getenv('DB_PASS') ?: 'NOT SET') . "</p>";
    
    echo "<h2>2. PHP Extensions</h2>";
    echo "<p>PDO available: " . (extension_loaded('pdo') ? 'YES' : 'NO') . "</p>";
    echo "<p>PDO MySQL available: " . (extension_loaded('pdo_mysql') ? 'YES' : 'NO') . "</p>";
    
    echo "<h2>3. Testing Bootstrap.php</h2>";
    
    // Test the bootstrap file directly
    $result = require_once __DIR__ . '/bootstrap.php';
    
    echo "<p>Bootstrap result type: " . gettype($result) . "</p>";
    
    if ($result instanceof PDO) {
        echo "<p>✅ SUCCESS: Got valid PDO object</p>";
        
        // Test a simple query
        $stmt = $result->query("SELECT VERSION() as version");
        $version = $stmt->fetch();
        echo "<p>✅ Database version: " . $version['version'] . "</p>";
        
        // Test translations table
        $stmt = $result->query("SELECT COUNT(*) as count FROM translations");
        $count = $stmt->fetch();
        echo "<p>✅ Translations count: " . $count['count'] . "</p>";
        
    } else {
        echo "<p>❌ FAILED: Got " . gettype($result) . " instead of PDO object</p>";
        var_dump($result);
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ ERROR: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
