<?php
/**
 * Populate Users and User Sessions
 * Adds sample users with different roles and active sessions
 */

require_once __DIR__ . '/bootstrap.php';

try {
    $pdo = require __DIR__ . '/bootstrap.php';
    
    echo "<h1>Populating Users</h1>\n";
    echo "<p>Adding sample users and sessions...</p>\n";
    
    // Insert Users
    echo "<h2>Inserting Users...</h2>\n";
    $users = [
        ['admin@teatarzatebe.mk', password_hash('admin123', PASSWORD_DEFAULT), 'Admin User', 'admin', 1],
        ['editor@teatarzatebe.mk', password_hash('editor123', PASSWORD_DEFAULT), 'Content Editor', 'editor', 1],
        ['john.doe@example.com', password_hash('user123', PASSWORD_DEFAULT), 'John Doe', 'user', 1],
        ['jane.smith@example.com', password_hash('user123', PASSWORD_DEFAULT), 'Jane Smith', 'user', 1],
        ['maria.garcia@example.com', password_hash('user123', PASSWORD_DEFAULT), 'Maria Garcia', 'user', 0], // Inactive
        ['david.wilson@example.com', password_hash('user123', PASSWORD_DEFAULT), 'David Wilson', 'user', 1],
        ['sarah.johnson@example.com', password_hash('user123', PASSWORD_DEFAULT), 'Sarah Johnson', 'user', 1],
        ['mike.brown@example.com', password_hash('user123', PASSWORD_DEFAULT), 'Mike Brown', 'user', 1],
        ['lisa.davis@example.com', password_hash('user123', PASSWORD_DEFAULT), 'Lisa Davis', 'user', 1],
        ['peter.miller@example.com', password_hash('user123', PASSWORD_DEFAULT), 'Peter Miller', 'user', 0] // Inactive
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (email, password_hash, name, role, is_active) VALUES (?, ?, ?, ?, ?)");
    foreach ($users as $user) {
        $stmt->execute($user);
        echo "✓ Inserted user: {$user[2]} ({$user[0]}) - Role: {$user[3]}\n";
    }
    
    // Insert User Sessions
    echo "<h2>Inserting User Sessions...</h2>\n";
    $sessions = [
        ['sess_' . uniqid(), 1, '{"login_time": "' . date('Y-m-d H:i:s') . '", "ip": "192.168.1.100", "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36", "last_activity": "' . date('Y-m-d H:i:s') . '"}', date('Y-m-d H:i:s', strtotime('+2 hours'))],
        ['sess_' . uniqid(), 2, '{"login_time": "' . date('Y-m-d H:i:s') . '", "ip": "192.168.1.101", "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36", "last_activity": "' . date('Y-m-d H:i:s') . '"}', date('Y-m-d H:i:s', strtotime('+1 hour'))],
        ['sess_' . uniqid(), 3, '{"login_time": "' . date('Y-m-d H:i:s') . '", "ip": "192.168.1.102", "user_agent": "Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15", "last_activity": "' . date('Y-m-d H:i:s') . '"}', date('Y-m-d H:i:s', strtotime('+30 minutes'))],
        ['sess_' . uniqid(), null, '{"guest": true, "visit_time": "' . date('Y-m-d H:i:s') . '", "ip": "192.168.1.103", "user_agent": "Mozilla/5.0 (Android 11; Mobile; rv:68.0) Gecko/68.0 Firefox/88.0", "pages_visited": ["/", "/about", "/events"]}', date('Y-m-d H:i:s', strtotime('+15 minutes'))],
        ['sess_' . uniqid(), 4, '{"login_time": "' . date('Y-m-d H:i:s', strtotime('-1 hour')) . '", "ip": "192.168.1.104", "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0", "last_activity": "' . date('Y-m-d H:i:s', strtotime('-30 minutes')) . '"}', date('Y-m-d H:i:s', strtotime('+1 hour'))],
        ['sess_' . uniqid(), 6, '{"login_time": "' . date('Y-m-d H:i:s', strtotime('-2 hours')) . '", "ip": "192.168.1.105", "user_agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36", "last_activity": "' . date('Y-m-d H:i:s', strtotime('-1 hour')) . '"}', date('Y-m-d H:i:s', strtotime('+2 hours'))]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO user_sessions (session_id, user_id, user_data, expires_at) VALUES (?, ?, ?, ?)");
    foreach ($sessions as $session) {
        $stmt->execute($session);
        echo "✓ Inserted session: {$session[0]}\n";
    }
    
    echo "<h2>✅ Users Population Complete!</h2>\n";
    echo "<p><strong>Summary:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Users: " . count($users) . "</li>\n";
    echo "<li>User Sessions: " . count($sessions) . "</li>\n";
    echo "<li>Roles: admin, editor, user</li>\n";
    echo "<li>Active Users: " . count(array_filter($users, function($u) { return $u[4] == 1; })) . "</li>\n";
    echo "</ul>\n";
    
    echo "<p><strong>Login Credentials:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Admin: admin@teatarzatebe.mk / admin123</li>\n";
    echo "<li>Editor: editor@teatarzatebe.mk / editor123</li>\n";
    echo "<li>Users: [email] / user123</li>\n";
    echo "</ul>\n";
    
} catch (Exception $e) {
    echo "<h2>❌ Error during users population:</h2>\n";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>\n";
}
?>
