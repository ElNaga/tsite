<?php
/**
 * Direct Bootstrap Test
 * This tests bootstrap.php from the same context as the services
 */

echo "<h1>🔍 Direct Bootstrap Test</h1>";

try {
    echo "<h2>1. Testing bootstrap.php from services context</h2>";
    
    // Test the exact path that services use
    $bootstrapPath = __DIR__ . '/bootstrap.php';
    echo "<p>Bootstrap path: $bootstrapPath</p>";
    echo "<p>File exists: " . (file_exists($bootstrapPath) ? 'YES' : 'NO') . "</p>";
    
    // Test require_once from services context
    $result = require_once $bootstrapPath;
    
    echo "<p>Bootstrap result type: " . gettype($result) . "</p>";
    
    if ($result instanceof PDO) {
        echo "<p>✅ SUCCESS: Got valid PDO object</p>";
        
        // Test a simple query
        $stmt = $result->query("SELECT VERSION() as version");
        $version = $stmt->fetch();
        echo "<p>✅ Database version: " . $version['version'] . "</p>";
        
    } else {
        echo "<p>❌ FAILED: Got " . gettype($result) . " instead of PDO object</p>";
        var_dump($result);
    }
    
    echo "<h2>2. Testing from different directory</h2>";
    
    // Change to services directory and test
    $originalDir = getcwd();
    chdir(__DIR__ . '/src/services');
    
    $result2 = require_once '../../bootstrap.php';
    
    echo "<p>Bootstrap result from services dir type: " . gettype($result2) . "</p>";
    
    if ($result2 instanceof PDO) {
        echo "<p>✅ SUCCESS: Got valid PDO object from services dir</p>";
    } else {
        echo "<p>❌ FAILED: Got " . gettype($result2) . " from services dir</p>";
        var_dump($result2);
    }
    
    chdir($originalDir);
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ ERROR: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
