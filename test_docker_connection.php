<?php
/**
 * Test Database Connection in Docker Environment
 * 
 * This file tests the PDO connection to MySQL in the Docker environment.
 * Run this from the PHP container or access via http://localhost:8080/test_docker_connection.php
 */

echo "<h2>🐳 Docker Database Connection Test</h2>";

try {
    // Database configuration for Docker environment
    $config = [
        'host' => getenv('DB_HOST') ?: 'mysql',
        'port' => getenv('DB_PORT') ?: '3306',
        'db'   => getenv('DB_NAME') ?: 'teatar_zatebe',
        'user' => getenv('DB_USER') ?: 'tzt',
        'pass' => getenv('DB_PASS') ?: 'tztpass',
        'charset' => 'utf8mb4'
    ];

    echo "<p><strong>Connection Details:</strong></p>";
    echo "<ul>";
    echo "<li>Host: " . $config['host'] . "</li>";
    echo "<li>Port: " . $config['port'] . "</li>";
    echo "<li>Database: " . $config['db'] . "</li>";
    echo "<li>User: " . $config['user'] . "</li>";
    echo "</ul>";

    // Create DSN and connect
    $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['db']};charset={$config['charset']}";
    
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    echo "<p style='color: green;'>✅ <strong>Successfully connected to MySQL!</strong></p>";

    // Test basic queries
    $stmt = $pdo->query("SELECT VERSION() as version");
    $result = $stmt->fetch();
    echo "<p><strong>MySQL Version:</strong> " . $result['version'] . "</p>";

    $stmt = $pdo->query("SELECT DATABASE() as current_db");
    $result = $stmt->fetch();
    echo "<p><strong>Current Database:</strong> " . $result['current_db'] . "</p>";

    // Test events table
    echo "<h3>📅 Events in Database:</h3>";
    $stmt = $pdo->query("SELECT id, title, event_date FROM events LIMIT 10");
    $events = $stmt->fetchAll();

    if (count($events) > 0) {
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>ID</th><th>Title</th><th>Event Date</th></tr>";
        
        foreach ($events as $event) {
            echo "<tr>";
            echo "<td>{$event['id']}</td>";
            echo "<td>{$event['title']}</td>";
            echo "<td>{$event['event_date']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No events found in the database.</p>";
    }

    echo "<p style='color: green;'>🎉 <strong>All tests passed successfully!</strong></p>";

} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ <strong>Database Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Error Code:</strong> " . $e->getCode() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ <strong>General Error:</strong> " . $e->getMessage() . "</p>";
}
