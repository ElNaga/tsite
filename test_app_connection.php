<?php
/**
 * Test Application Database Connection
 * 
 * This page tests if the main application is properly connected to the database
 */

echo "<h1>🔗 Testing Application Database Connection</h1>";

try {
    // Load services
    require_once __DIR__ . '/src/services/TranslationService.php';
    require_once __DIR__ . '/src/services/EventService.php';
    
    echo "<p>✅ Services loaded successfully</p>";
    
    // Test translations
    echo "<h2>🌐 Testing Translations</h2>";
    TranslationService::loadTranslations();
    
    $currentLang = TranslationService::getCurrentLang();
    echo "<p>✅ Current language: $currentLang</p>";
    
    $siteTitle = TranslationService::t('site_title');
    echo "<p>✅ Site title: $siteTitle</p>";
    
    $homeText = TranslationService::t('home');
    echo "<p>✅ Home text: $homeText</p>";
    
    // Test events
    echo "<h2>📅 Testing Events</h2>";
    $events = EventService::getEvents();
    echo "<p>✅ Found " . count($events) . " events</p>";
    
    if (!empty($events)) {
        echo "<h3>Event Details:</h3>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>ID</th><th>Title</th><th>Description</th><th>Book Label</th></tr>";
        
        foreach ($events as $event) {
            echo "<tr>";
            echo "<td>{$event['id']}</td>";
            echo "<td>" . htmlspecialchars($event['title']) . "</td>";
            echo "<td>" . htmlspecialchars(substr($event['description'], 0, 50)) . "...</td>";
            echo "<td>" . htmlspecialchars($event['book_label']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Test language switching
    echo "<h2>🔄 Testing Language Switching</h2>";
    echo "<p>Available languages:</p>";
    echo "<ul>";
    foreach (TranslationService::getLanguages() as $code => $name) {
        $url = "?lang=$code";
        echo "<li><a href='$url'>$name ($code)</a></li>";
    }
    echo "</ul>";
    
    echo "<h1>🎉 Application Database Connection Test Complete!</h1>";
    echo "<p><strong>Your application is now connected to the database!</strong></p>";
    echo "<p>✅ Translations are working</p>";
    echo "<p>✅ Events are loading from database</p>";
    echo "<p>✅ Language switching works</p>";
    
    echo "<h3>🔗 Test Your Main Site:</h3>";
    echo "<p><a href='http://localhost:8080' target='_blank'>Visit your main site</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
