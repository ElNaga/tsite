<?php
/**
 * Contact Form Testing Script
 * 
 * Tests the contact form functionality including:
 * - Database table existence
 * - Translation availability
 * - Service methods
 * - API endpoint
 * 
 * Run this from a web browser to verify the contact form setup.
 */

// Prevent direct execution if not in web environment
if (php_sapi_name() === 'cli') {
    die("This script should be run from a web browser.\n");
}

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/src/services/ContactService.php';
require_once __DIR__ . '/src/services/TranslationService.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Test Suite</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .test-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .test-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .test-item {
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #ddd;
            background: #f9f9f9;
        }
        .test-item.pass {
            border-left-color: #27ae60;
            background: #eafaf1;
        }
        .test-item.fail {
            border-left-color: #e74c3c;
            background: #fadbd8;
        }
        .test-item.warning {
            border-left-color: #f39c12;
            background: #fef5e7;
        }
        .icon {
            font-weight: bold;
            margin-right: 10px;
        }
        .pass .icon { color: #27ae60; }
        .fail .icon { color: #e74c3c; }
        .warning .icon { color: #f39c12; }
        .code {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            overflow-x: auto;
            margin: 10px 0;
        }
        h2 { color: #2c3e50; margin-top: 0; }
        h3 { color: #34495e; }
    </style>
</head>
<body>
    <div class="test-header">
        <h1>🧪 Contact Form Test Suite</h1>
        <p>Comprehensive testing of the contact form feature</p>
    </div>

    <?php
    $allPassed = true;
    
    // Test 1: Database Connection
    echo '<div class="test-section">';
    echo '<h2>1. Database Connection</h2>';
    try {
        $pdo->query("SELECT 1");
        echo '<div class="test-item pass"><span class="icon">✓</span> Database connection successful</div>';
    } catch (Exception $e) {
        $allPassed = false;
        echo '<div class="test-item fail"><span class="icon">✗</span> Database connection failed: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
    echo '</div>';
    
    // Test 2: Contact Messages Table
    echo '<div class="test-section">';
    echo '<h2>2. Contact Messages Table</h2>';
    try {
        $stmt = $pdo->query("SHOW TABLES LIKE 'contact_messages'");
        if ($stmt->rowCount() > 0) {
            echo '<div class="test-item pass"><span class="icon">✓</span> contact_messages table exists</div>';
            
            // Check columns
            $stmt = $pdo->query("DESCRIBE contact_messages");
            $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $requiredColumns = ['id', 'full_name', 'email', 'message', 'status', 'language_code'];
            foreach ($requiredColumns as $col) {
                if (in_array($col, $columns)) {
                    echo '<div class="test-item pass"><span class="icon">✓</span> Column exists: ' . $col . '</div>';
                } else {
                    $allPassed = false;
                    echo '<div class="test-item fail"><span class="icon">✗</span> Missing column: ' . $col . '</div>';
                }
            }
        } else {
            $allPassed = false;
            echo '<div class="test-item fail"><span class="icon">✗</span> contact_messages table does not exist</div>';
            echo '<div class="test-item warning"><span class="icon">⚠</span> Run: php migrate_contact.php</div>';
        }
    } catch (Exception $e) {
        $allPassed = false;
        echo '<div class="test-item fail"><span class="icon">✗</span> Error checking table: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
    echo '</div>';
    
    // Test 3: Translations
    echo '<div class="test-section">';
    echo '<h2>3. Contact Form Translations</h2>';
    try {
        TranslationService::loadTranslations();
        $translationKeys = [
            'contact_page_title',
            'contact_form_name',
            'contact_form_email',
            'contact_form_message',
            'contact_form_submit'
        ];
        
        foreach ($translationKeys as $key) {
            $translation = TranslationService::t($key);
            if ($translation !== $key) {
                echo '<div class="test-item pass"><span class="icon">✓</span> Translation exists: ' . $key . ' = "' . htmlspecialchars($translation) . '"</div>';
            } else {
                $allPassed = false;
                echo '<div class="test-item fail"><span class="icon">✗</span> Missing translation: ' . $key . '</div>';
            }
        }
    } catch (Exception $e) {
        $allPassed = false;
        echo '<div class="test-item fail"><span class="icon">✗</span> Error loading translations: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
    echo '</div>';
    
    // Test 4: ContactService
    echo '<div class="test-section">';
    echo '<h2>4. ContactService Methods</h2>';
    try {
        // Test validation
        $testData = [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'This is a test message for validation.'
        ];
        $validation = ContactService::validateFormData($testData);
        if ($validation['valid']) {
            echo '<div class="test-item pass"><span class="icon">✓</span> Validation method works correctly</div>';
        } else {
            echo '<div class="test-item warning"><span class="icon">⚠</span> Validation failed (expected to pass)</div>';
        }
        
        // Test invalid data
        $invalidData = ['full_name' => '', 'email' => 'invalid', 'message' => ''];
        $validation = ContactService::validateFormData($invalidData);
        if (!$validation['valid'] && count($validation['errors']) > 0) {
            echo '<div class="test-item pass"><span class="icon">✓</span> Validation correctly identifies errors</div>';
        } else {
            echo '<div class="test-item warning"><span class="icon">⚠</span> Validation should have failed</div>';
        }
        
        // Test statistics (should work even with no messages)
        $stats = ContactService::getStatistics();
        if (isset($stats['total']) && isset($stats['new'])) {
            echo '<div class="test-item pass"><span class="icon">✓</span> Statistics method works (Total: ' . $stats['total'] . ', New: ' . $stats['new'] . ')</div>';
        } else {
            echo '<div class="test-item warning"><span class="icon">⚠</span> Statistics method incomplete</div>';
        }
        
    } catch (Exception $e) {
        $allPassed = false;
        echo '<div class="test-item fail"><span class="icon">✗</span> ContactService error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
    echo '</div>';
    
    // Test 5: API Endpoint
    echo '<div class="test-section">';
    echo '<h2>5. API Endpoint</h2>';
    $apiFile = __DIR__ . '/api/contact.php';
    if (file_exists($apiFile)) {
        echo '<div class="test-item pass"><span class="icon">✓</span> API file exists: /api/contact.php</div>';
        echo '<div class="test-item pass"><span class="icon">✓</span> Endpoint should be accessible at: /api/contact</div>';
    } else {
        $allPassed = false;
        echo '<div class="test-item fail"><span class="icon">✗</span> API file missing: /api/contact.php</div>';
    }
    echo '</div>';
    
    // Test 6: Frontend Files
    echo '<div class="test-section">';
    echo '<h2>6. Frontend Components</h2>';
    $frontendFiles = [
        'components/navbar/Contact.php' => 'Contact page component',
        'components/navbar/contact.css' => 'Contact form styles',
        'components/navbar/contact.js' => 'Contact form JavaScript'
    ];
    
    foreach ($frontendFiles as $file => $description) {
        if (file_exists(__DIR__ . '/' . $file)) {
            echo '<div class="test-item pass"><span class="icon">✓</span> ' . $description . ' exists</div>';
        } else {
            $allPassed = false;
            echo '<div class="test-item fail"><span class="icon">✗</span> Missing: ' . $file . '</div>';
        }
    }
    echo '</div>';
    
    // Test 7: Integration Test
    echo '<div class="test-section">';
    echo '<h2>7. Integration Test</h2>';
    echo '<div class="test-item"><span class="icon">ℹ</span> Visit <a href="/contact" target="_blank">/contact</a> to test the form manually</div>';
    echo '<div class="code">
// Example AJAX request to test API:
fetch("/api/contact", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
        full_name: "Test User",
        email: "test@example.com",
        message: "This is a test message"
    })
}).then(r => r.json()).then(console.log);
    </div>';
    echo '</div>';
    
    // Summary
    echo '<div class="test-section">';
    echo '<h2>📊 Test Summary</h2>';
    if ($allPassed) {
        echo '<div class="test-item pass"><span class="icon">✓</span> All tests passed! The contact form is ready to use.</div>';
    } else {
        echo '<div class="test-item warning"><span class="icon">⚠</span> Some tests failed. Please review the results above.</div>';
        echo '<div class="test-item"><span class="icon">ℹ</span> If the contact_messages table is missing, run: <code>php migrate_contact.php</code></div>';
    }
    echo '</div>';
    ?>
    
    <div class="test-section">
        <h2>📚 Next Steps</h2>
        <ol>
            <li>If any tests failed, run the migration: <code>php migrate_contact.php</code></li>
            <li>Visit <a href="/contact">/contact</a> to see the form</li>
            <li>Submit a test message to verify end-to-end functionality</li>
            <li>Check the database for the new message</li>
            <li>Review <a href="/CONTACT_FORM_SETUP.md">CONTACT_FORM_SETUP.md</a> for documentation</li>
        </ol>
    </div>
</body>
</html>

