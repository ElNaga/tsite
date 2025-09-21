<?php
/**
 * Restore Database from JSON Files
 * Imports events and translations from existing JSON data
 */

require_once __DIR__ . '/bootstrap.php';

try {
    $pdo = require __DIR__ . '/bootstrap.php';
    
    echo "<h1>Restoring Data from JSON Files</h1>\n";
    echo "<p>Starting data restoration...</p>\n";
    
    // 1. Insert Languages (required for foreign keys)
    echo "<h2>1. Inserting Languages...</h2>\n";
    $languages = [
        ['en', 'English', 1],
        ['mk', 'Македонски', 1],
        ['fr', 'Français', 1]
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO languages (code, name, is_active) VALUES (?, ?, ?)");
    foreach ($languages as $lang) {
        $stmt->execute($lang);
        echo "✓ Language: {$lang[1]} ({$lang[0]})\n";
    }
    
    // 2. Insert Admin User
    echo "<h2>2. Inserting Admin User...</h2>\n";
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (email, password_hash, name, role, is_active) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute(['admin@teatarzatebe.mk', password_hash('admin123', PASSWORD_DEFAULT), 'Admin User', 'admin', 1]);
    echo "✓ Admin user ready\n";
    
    // 3. Insert Basic Translations
    echo "<h2>3. Inserting Basic Translations...</h2>\n";
    $translations = [
        // English translations
        ['en', 'site_title', 'Teatar za tebe - Interactive Theatre & Events for Kids'],
        ['en', 'site_description', 'Unforgettable children\'s parties, interactive performances, drama studio, and creative workshops. Book your next event with Teatar za tebe!'],
        ['en', 'home', 'Home'],
        ['en', 'about', 'About'],
        ['en', 'offer', 'Offer'],
        ['en', 'blog', 'Blog'],
        ['en', 'contact', 'Contact'],
        ['en', 'language', 'Language'],
        ['en', 'book_now', 'Book now'],
        ['en', 'not_found_title', 'Page Not Found'],
        ['en', 'not_found_message', 'Sorry, the page you are looking for does not exist or has been moved. Try going back to the homepage.'],
        
        // Macedonian translations
        ['mk', 'site_title', 'Театар за тебе - Интерактивен театар и настани за деца'],
        ['mk', 'site_description', 'Незаборавни детски родендени, интерактивни претстави, драмско студио и креативни работилници. Закажете го вашиот следен настан со Театар за тебе!'],
        ['mk', 'home', 'Дома'],
        ['mk', 'about', 'За нас'],
        ['mk', 'offer', 'Понуда'],
        ['mk', 'blog', 'Блог'],
        ['mk', 'contact', 'Контакт'],
        ['mk', 'language', 'Јазик'],
        ['mk', 'book_now', 'Резервирај'],
        ['mk', 'not_found_title', 'Страницата не е пронајдена'],
        ['mk', 'not_found_message', 'Жалиме, страницата што ја барате не постои или е преместена. Обидете се да се вратите на почетната страница.'],
        
        // French translations
        ['fr', 'site_title', 'Théâtre pour toi - Théâtre interactif et événements pour enfants'],
        ['fr', 'site_description', 'Fêtes d\'enfants inoubliables, spectacles interactifs, studio de théâtre et ateliers créatifs. Réservez votre prochain événement avec Théâtre pour toi!'],
        ['fr', 'home', 'Accueil'],
        ['fr', 'about', 'À propos'],
        ['fr', 'offer', 'Offre'],
        ['fr', 'blog', 'Blog'],
        ['fr', 'contact', 'Contact'],
        ['fr', 'language', 'Langue'],
        ['fr', 'book_now', 'Réserver'],
        ['fr', 'not_found_title', 'Page non trouvée'],
        ['fr', 'not_found_message', 'Désolé, la page que vous recherchez n\'existe pas ou a été déplacée. Essayez de revenir à la page d\'accueil.']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO translations (language_code, translation_key, translation_value) VALUES (?, ?, ?)");
    foreach ($translations as $translation) {
        $stmt->execute($translation);
    }
    echo "✓ Translations ready (" . count($translations) . " entries)\n";
    
    // 4. Read and Import Events from JSON
    echo "<h2>4. Importing Events from JSON...</h2>\n";
    
    if (!file_exists(__DIR__ . '/data/events.json')) {
        throw new Exception("events.json file not found!");
    }
    
    $eventsJson = json_decode(file_get_contents(__DIR__ . '/data/events.json'), true);
    
    if (!$eventsJson) {
        throw new Exception("Failed to parse events.json");
    }
    
    // Get unique event IDs from JSON
    $eventIds = [];
    foreach ($eventsJson as $lang => $events) {
        foreach ($events as $event) {
            if (!in_array($event['id'], $eventIds)) {
                $eventIds[] = $event['id'];
            }
        }
    }
    
    echo "Found " . count($eventIds) . " unique events in JSON\n";
    
    // Insert events
    $stmt = $pdo->prepare("INSERT INTO events (id, image, book_url, status) VALUES (?, ?, ?, ?)");
    foreach ($eventIds as $eventId) {
        // Get first language's data for basic event info
        $firstLang = array_keys($eventsJson)[0];
        $eventData = null;
        foreach ($eventsJson[$firstLang] as $event) {
            if ($event['id'] == $eventId) {
                $eventData = $event;
                break;
            }
        }
        
        if ($eventData) {
            $stmt->execute([
                $eventId,
                $eventData['image'],
                $eventData['book_url'],
                'published'
            ]);
            echo "✓ Inserted event ID: {$eventId}\n";
        }
    }
    
    // 5. Insert Event Translations
    echo "<h2>5. Inserting Event Translations...</h2>\n";
    $stmt = $pdo->prepare("INSERT INTO event_translations (event_id, language_code, title, description, book_label, image_alt) VALUES (?, ?, ?, ?, ?, ?)");
    
    $translationCount = 0;
    foreach ($eventsJson as $lang => $events) {
        foreach ($events as $event) {
            $stmt->execute([
                $event['id'],
                $lang,
                $event['title'],
                $event['desc'],
                $event['book_label'],
                $event['image_alt']
            ]);
            $translationCount++;
            echo "✓ Inserted translation for event {$event['id']} in {$lang}\n";
        }
    }
    
    echo "<h2>✅ Data Restoration Complete!</h2>\n";
    echo "<p><strong>Summary:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Languages: " . count($languages) . "</li>\n";
    echo "<li>Users: 1 (admin)</li>\n";
    echo "<li>Translations: " . count($translations) . "</li>\n";
    echo "<li>Events: " . count($eventIds) . "</li>\n";
    echo "<li>Event Translations: {$translationCount}</li>\n";
    echo "</ul>\n";
    
    echo "<p><strong>Your data has been restored from JSON files!</strong></p>\n";
    echo "<p><a href='index.php'>Visit your website</a></p>\n";
    
} catch (Exception $e) {
    echo "<h2>❌ Error during data restoration:</h2>\n";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>\n";
}
?>
