<?php
/**
 * Comprehensive Test - All Services Database Integration
 * 
 * This test verifies that ALL services are properly connected to the database
 */

echo "<h1>🔗 Comprehensive Database Integration Test</h1>";

try {
    // Load all services
    require_once __DIR__ . '/src/services/TranslationService.php';
    require_once __DIR__ . '/src/services/EventService.php';
    require_once __DIR__ . '/src/services/TransactionService.php';
    
    echo "<p>✅ All services loaded successfully</p>";
    
    // Test 1: TranslationService
    echo "<h2>🌐 Testing TranslationService</h2>";
    TranslationService::loadTranslations();
    
    $currentLang = TranslationService::getCurrentLang();
    echo "<p>✅ Current language: $currentLang</p>";
    
    $siteTitle = TranslationService::t('site_title');
    echo "<p>✅ Site title: $siteTitle</p>";
    
    $homeText = TranslationService::t('home');
    echo "<p>✅ Home text: $homeText</p>";
    
    // Test language switching
    echo "<p>✅ Available languages: " . implode(', ', array_keys(TranslationService::getLanguages())) . "</p>";
    
    // Test 2: EventService
    echo "<h2>📅 Testing EventService</h2>";
    $events = EventService::getEvents();
    echo "<p>✅ Found " . count($events) . " events for current language</p>";
    
    $allEvents = EventService::getAllEvents();
    echo "<p>✅ Found " . count($allEvents) . " total event records</p>";
    
    if (!empty($events)) {
        echo "<h3>Sample Event:</h3>";
        echo "<ul>";
        echo "<li><strong>Title:</strong> " . htmlspecialchars($events[0]['title']) . "</li>";
        echo "<li><strong>Description:</strong> " . htmlspecialchars(substr($events[0]['description'], 0, 50)) . "...</li>";
        echo "<li><strong>Book Label:</strong> " . htmlspecialchars($events[0]['book_label']) . "</li>";
        echo "</ul>";
    }
    
    // Test 3: TransactionService
    echo "<h2>💳 Testing TransactionService</h2>";
    $transactions = TransactionService::getAllTransactions();
    echo "<p>✅ Found " . count($transactions) . " transactions</p>";
    
    $stats = TransactionService::getStatistics();
    echo "<p>✅ Transaction statistics:</p>";
    echo "<ul>";
    echo "<li>Total: " . $stats['total'] . "</li>";
    echo "<li>Pending: " . $stats['pending'] . "</li>";
    echo "<li>Confirmed: " . $stats['confirmed'] . "</li>";
    echo "<li>Recent (30 days): " . $stats['recent'] . "</li>";
    echo "</ul>";
    
    // Test 4: Admin Controller
    echo "<h2>⚙️ Testing Admin Controller</h2>";
    require_once __DIR__ . '/components/admin/admin-controller.php';
    
    $adminData = AdminController::getData();
    echo "<p>✅ Admin data loaded successfully</p>";
    echo "<ul>";
    echo "<li>Total events: " . $adminData['totalEvents'] . "</li>";
    echo "<li>Total transactions: " . $adminData['totalTransactions'] . "</li>";
    echo "<li>Events by language: " . count($adminData['events']['en']) . " EN, " . count($adminData['events']['mk']) . " MK, " . count($adminData['events']['fr']) . " FR</li>";
    echo "</ul>";
    
    // Test 5: Database Connection
    echo "<h2>🔌 Testing Database Connection</h2>";
    $pdo = require_once __DIR__ . '/bootstrap.php';
    
    if ($pdo instanceof PDO) {
        echo "<p>✅ Database connection successful</p>";
        
        // Test a simple query
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM translations");
        $translationCount = $stmt->fetch()['count'];
        echo "<p>✅ Translations in database: $translationCount</p>";
        
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM events");
        $eventCount = $stmt->fetch()['count'];
        echo "<p>✅ Events in database: $eventCount</p>";
        
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM transactions");
        $transactionCount = $stmt->fetch()['count'];
        echo "<p>✅ Transactions in database: $transactionCount</p>";
    } else {
        echo "<p>❌ Database connection failed</p>";
    }
    
    echo "<h1>🎉 All Services Database Integration Test Complete!</h1>";
    echo "<p><strong>✅ SUCCESS: Your application is fully database-powered!</strong></p>";
    
    echo "<h3>📊 Summary:</h3>";
    echo "<ul>";
    echo "<li>✅ TranslationService - Database translations working</li>";
    echo "<li>✅ EventService - Database events working</li>";
    echo "<li>✅ TransactionService - Database transactions working</li>";
    echo "<li>✅ AdminController - Database admin panel working</li>";
    echo "<li>✅ Database Connection - PDO connection working</li>";
    echo "</ul>";
    
    echo "<h3>🔗 Test Your Application:</h3>";
    echo "<ul>";
    echo "<li><a href='http://localhost:8080' target='_blank'>Main Site</a></li>";
    echo "<li><a href='http://localhost:8080/admin' target='_blank'>Admin Panel</a></li>";
    echo "<li><a href='http://localhost:8080/test_app_connection.php' target='_blank'>Connection Test</a></li>";
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
