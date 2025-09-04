<?php
/**
 * Web-based Database Migration Script for Teatar za tebe
 * 
 * Access this via: http://localhost:8080/migrate_web.php
 */

echo "<h1>🚀 Database Migration for Teatar za tebe</h1>";

try {
    // First, connect without specifying database to create it if needed
    $config = [
        'host' => getenv('DB_HOST') ?: 'mysql',
        'port' => getenv('DB_PORT') ?: '3306',
        'user' => getenv('DB_USER') ?: 'tzt',
        'pass' => getenv('DB_PASS') ?: 'tztpass',
        'charset' => 'utf8mb4'
    ];

    $dsn = "mysql:host={$config['host']};port={$config['port']};charset={$config['charset']}";
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    
    echo "<p>✅ Connected to MySQL server</p>";

    // Create database if it doesn't exist
    $dbName = getenv('DB_NAME') ?: 'teatar_zatebe';
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p>✅ Database '$dbName' ready</p>";

    // Connect to the specific database
    $pdo->exec("USE `$dbName`");
    echo "<p>✅ Connected to database '$dbName'</p>";

    // Check if tables already exist
    $stmt = $pdo->query("SHOW TABLES");
    $existingTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (!empty($existingTables)) {
        echo "<p>⚠️ Found existing tables: " . implode(', ', $existingTables) . "</p>";
        echo "<p>🔄 Dropping existing tables to recreate schema...</p>";
        
        // Drop tables in reverse order (respecting foreign keys)
        $dropOrder = [
            'translations', 'event_translations', 'blog_post_translations',
            'transactions', 'blog_posts', 'events', 'user_sessions', 'users', 'languages'
        ];
        
        foreach ($dropOrder as $table) {
            if (in_array($table, $existingTables)) {
                $pdo->exec("DROP TABLE IF EXISTS `$table`");
                echo "<p>🗑️ Dropped table: $table</p>";
            }
        }
    }

    // Read and execute schema
    echo "<h2>📋 Creating database schema...</h2>";
    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    
    // Split schema into individual statements
    $statements = array_filter(array_map('trim', explode(';', $schema)));
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            try {
                $pdo->exec($statement);
            } catch (PDOException $e) {
                // Skip if table already exists (shouldn't happen now, but just in case)
                if (strpos($e->getMessage(), 'already exists') === false) {
                    throw $e;
                }
            }
        }
    }
    echo "<p>✅ Database schema created successfully</p>";

    // Migrate events from JSON
    echo "<h2>📅 Migrating events from JSON...</h2>";
    $eventsData = json_decode(file_get_contents(__DIR__ . '/data/events.json'), true);
    
    if ($eventsData) {
        $eventIds = [];
        
        // Get unique event IDs
        foreach ($eventsData as $lang => $events) {
            foreach ($events as $event) {
                $eventIds[$event['id']] = $event;
            }
        }
        
        // Insert events
        $stmt = $pdo->prepare("
            INSERT INTO events (id, image, book_url, status) 
            VALUES (?, ?, ?, 'published')
            ON DUPLICATE KEY UPDATE 
            image = VALUES(image), 
            book_url = VALUES(book_url)
        ");
        
        foreach ($eventIds as $id => $event) {
            $stmt->execute([$id, $event['image'], $event['book_url']]);
        }
        
        // Insert event translations
        $stmt = $pdo->prepare("
            INSERT INTO event_translations (event_id, language_code, title, description, book_label, image_alt) 
            VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            title = VALUES(title),
            description = VALUES(description),
            book_label = VALUES(book_label),
            image_alt = VALUES(image_alt)
        ");
        
        foreach ($eventsData as $lang => $events) {
            foreach ($events as $event) {
                $stmt->execute([
                    $event['id'],
                    $lang,
                    $event['title'],
                    $event['desc'],
                    $event['book_label'],
                    $event['image_alt']
                ]);
            }
        }
        
        echo "<p>✅ Migrated " . count($eventIds) . " events with translations</p>";
    } else {
        echo "<p>⚠️ No events data found in JSON file</p>";
    }

    // Migrate transactions from JSON
    echo "<h2>💰 Migrating transactions from JSON...</h2>";
    $transactionsData = json_decode(file_get_contents(__DIR__ . '/data/transactions.json'), true);
    
    if ($transactionsData && count($transactionsData) > 0) {
        $stmt = $pdo->prepare("
            INSERT INTO transactions (event_id, user_data, status, amount, payment_method) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        foreach ($transactionsData as $transaction) {
            $stmt->execute([
                $transaction['event_id'] ?? 1,
                json_encode($transaction['user_data'] ?? []),
                $transaction['status'] ?? 'completed',
                $transaction['amount'] ?? null,
                $transaction['payment_method'] ?? null
            ]);
        }
        
        echo "<p>✅ Migrated " . count($transactionsData) . " transactions</p>";
    } else {
        echo "<p>⚠️ No transactions data found in JSON file</p>";
    }

    // Verify migration
    echo "<h2>🔍 Verifying migration...</h2>";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM languages");
    $languages = $stmt->fetch();
    echo "<p>✅ Languages: " . $languages['count'] . " records</p>";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $users = $stmt->fetch();
    echo "<p>✅ Users: " . $users['count'] . " records</p>";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM events");
    $events = $stmt->fetch();
    echo "<p>✅ Events: " . $events['count'] . " records</p>";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM event_translations");
    $eventTranslations = $stmt->fetch();
    echo "<p>✅ Event Translations: " . $eventTranslations['count'] . " records</p>";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM transactions");
    $transactions = $stmt->fetch();
    echo "<p>✅ Transactions: " . $transactions['count'] . " records</p>";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM translations");
    $translations = $stmt->fetch();
    echo "<p>✅ Static Translations: " . $translations['count'] . " records</p>";

    echo "<h1>🎉 Database migration completed successfully!</h1>";
    echo "<h3>📋 Summary:</h3>";
    echo "<ul>";
    echo "<li>Database: $dbName</li>";
    echo "<li>Host: " . (getenv('DB_HOST') ?: 'mysql') . ":" . (getenv('DB_PORT') ?: '3306') . "</li>";
    echo "<li>User: " . (getenv('DB_USER') ?: 'tzt') . "</li>";
    echo "<li>Default admin: admin@teatarzatebe.mk / admin123</li>";
    echo "</ul>";
    
    echo "<h3>🔗 Access URLs:</h3>";
    echo "<ul>";
    echo "<li><a href='http://localhost:8081' target='_blank'>PHPMyAdmin</a></li>";
    echo "<li><a href='http://localhost:8080/test_docker_connection.php' target='_blank'>PHP Test</a></li>";
    echo "</ul>";

} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Database Error: " . $e->getMessage() . "</p>";
    echo "<p>Error Code: " . $e->getCode() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ General Error: " . $e->getMessage() . "</p>";
}
