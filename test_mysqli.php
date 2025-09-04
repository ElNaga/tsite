<?php
try {
    require __DIR__.'/bootstrap.php';
    echo "✅ Connected to MySQL container successfully!<br>";
    
    // Test basic connection
    $stmt = $pdo->query("SELECT VERSION() as version");
    $result = $stmt->fetch();
    echo "✅ MySQL Version: " . $result['version'] . "<br>";
    
    // Test database access
    $stmt = $pdo->query("SELECT DATABASE() as current_db");
    $result = $stmt->fetch();
    echo "✅ Current Database: " . $result['current_db'] . "<br><br>";
    
    // Query events table
    echo "📅 Events in database:<br>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>ID</th><th>Title</th><th>Event Date</th></tr>";
    
    foreach ($pdo->query("SELECT id, title, event_date FROM events") as $r) {
        echo "<tr>";
        echo "<td>{$r['id']}</td>";
        echo "<td>{$r['title']}</td>";
        echo "<td>{$r['event_date']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<br>🎉 Database connection and query test completed successfully!";
    
} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "❌ General Error: " . $e->getMessage();
}