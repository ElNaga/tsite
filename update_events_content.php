<?php
/**
 * Update Events Content
 * Replace placeholder content with proper theater/events content
 */

require_once __DIR__ . '/src/services/EventService.php';
require_once __DIR__ . '/src/services/TranslationService.php';

echo "<h1>🎭 Updating Events Content</h1>";

try {
    $pdo = require_once __DIR__ . '/bootstrap.php';
    
    // Clear existing events
    echo "<h2>🗑️ Clearing existing events...</h2>";
    $pdo->exec("DELETE FROM event_translations");
    $pdo->exec("DELETE FROM events");
    echo "<p>✅ Existing events cleared</p>";
    
    // Create new events with proper content
    echo "<h2>✨ Creating new events with proper content...</h2>";
    
    // Event 1: Children's Theater Performance
    $event1Data = [
        'image' => '/assets/background-image.png',
        'book_url' => '#booking',
        'status' => 'published'
    ];
    
    $event1Translations = [
        'en' => [
            'title' => 'Magical Children\'s Theater',
            'description' => 'An enchanting interactive performance designed specifically for children aged 3-10. Join us for a magical journey filled with music, dance, and audience participation.',
            'book_label' => 'Book Performance',
            'image_alt' => 'Children enjoying magical theater performance'
        ],
        'mk' => [
            'title' => 'Магично детско театарско претставување',
            'description' => 'Волшебна интерактивна претстава дизајнирана специјално за деца на возраст од 3-10 години. Приклучете се на магично патување исполнето со музика, танц и учество на публиката.',
            'book_label' => 'Резервирај претстава',
            'image_alt' => 'Деца уживаат во магична театарска претстава'
        ],
        'fr' => [
            'title' => 'Théâtre magique pour enfants',
            'description' => 'Une représentation interactive enchantée conçue spécialement pour les enfants de 3 à 10 ans. Rejoignez-nous pour un voyage magique rempli de musique, de danse et de participation du public.',
            'book_label' => 'Réserver la représentation',
            'image_alt' => 'Enfants profitant d\'une représentation théâtrale magique'
        ]
    ];
    
    $event1Id = EventService::createEvent($event1Data, $event1Translations);
    echo "<p>✅ Event 1 created (ID: $event1Id) - Magical Children's Theater</p>";
    
    // Event 2: Drama Workshop
    $event2Data = [
        'image' => '/assets/background-image.png',
        'book_url' => '#workshop',
        'status' => 'published'
    ];
    
    $event2Translations = [
        'en' => [
            'title' => 'Creative Drama Workshop',
            'description' => 'Unleash your child\'s creativity through our engaging drama workshop. Learn acting skills, storytelling, and build confidence in a fun, supportive environment.',
            'book_label' => 'Join Workshop',
            'image_alt' => 'Children participating in creative drama workshop'
        ],
        'mk' => [
            'title' => 'Креативна драмска работилница',
            'description' => 'Ослободете ја креативноста на вашето дете преку нашата привлечна драмска работилница. Научете актерски вештини, раскажување приказни и градете самодоверба во забавна, поддржувачка средина.',
            'book_label' => 'Приклучи се на работилницата',
            'image_alt' => 'Деца кои учествуваат во креативна драмска работилница'
        ],
        'fr' => [
            'title' => 'Atelier de théâtre créatif',
            'description' => 'Libérez la créativité de votre enfant grâce à notre atelier de théâtre engageant. Apprenez les compétences d\'acteur, la narration d\'histoires et développez la confiance dans un environnement amusant et encourageant.',
            'book_label' => 'Rejoindre l\'atelier',
            'image_alt' => 'Enfants participant à un atelier de théâtre créatif'
        ]
    ];
    
    $event2Id = EventService::createEvent($event2Data, $event2Translations);
    echo "<p>✅ Event 2 created (ID: $event2Id) - Creative Drama Workshop</p>";
    
    // Event 3: Birthday Party Entertainment
    $event3Data = [
        'image' => '/assets/background-image.png',
        'book_url' => '#birthday',
        'status' => 'published'
    ];
    
    $event3Translations = [
        'en' => [
            'title' => 'Birthday Party Entertainment',
            'description' => 'Make your child\'s birthday unforgettable with our professional entertainment services. Interactive performances, games, and activities tailored to your child\'s age and interests.',
            'book_label' => 'Book Party',
            'image_alt' => 'Children celebrating birthday with theater entertainment'
        ],
        'mk' => [
            'title' => 'Забава за роденден',
            'description' => 'Направете го роденденот на вашето дете незаборавен со нашите професионални услуги за забава. Интерактивни претстави, игри и активности прилагодени на возраста и интересите на вашето дете.',
            'book_label' => 'Резервирај забава',
            'image_alt' => 'Деца кои слават роденден со театарска забава'
        ],
        'fr' => [
            'title' => 'Divertissement pour anniversaire',
            'description' => 'Rendez l\'anniversaire de votre enfant inoubliable avec nos services de divertissement professionnels. Représentations interactives, jeux et activités adaptés à l\'âge et aux intérêts de votre enfant.',
            'book_label' => 'Réserver la fête',
            'image_alt' => 'Enfants célébrant un anniversaire avec du divertissement théâtral'
        ]
    ];
    
    $event3Id = EventService::createEvent($event3Data, $event3Translations);
    echo "<p>✅ Event 3 created (ID: $event3Id) - Birthday Party Entertainment</p>";
    
    echo "<h2>🎉 Events Updated Successfully!</h2>";
    echo "<p>✅ All events now have proper theater/events content</p>";
    echo "<p>✅ Content available in English, Macedonian, and French</p>";
    
    // Test the new content
    echo "<h2>🧪 Testing New Content</h2>";
    
    foreach (['en', 'mk', 'fr'] as $lang) {
        TranslationService::setLang($lang);
        $events = EventService::getEvents($lang);
        echo "<h3>Language: $lang</h3>";
        echo "<ul>";
        foreach ($events as $event) {
            echo "<li><strong>" . htmlspecialchars($event['title']) . "</strong>: " . htmlspecialchars(substr($event['description'], 0, 50)) . "...</li>";
        }
        echo "</ul>";
    }
    
    echo "<h2>🔗 Test Your Site</h2>";
    echo "<p><a href='http://localhost:8080' target='_blank'>Visit Main Site</a></p>";
    echo "<p><a href='http://localhost:8080/admin' target='_blank'>Visit Admin Panel</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>

















