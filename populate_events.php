<?php
/**
 * Populate Events and Event Translations
 * Adds sample events with multilingual content
 */

require_once __DIR__ . '/bootstrap.php';

try {
    $pdo = require __DIR__ . '/bootstrap.php';
    
    echo "<h1>Populating Events</h1>\n";
    echo "<p>Adding sample events with translations...</p>\n";
    
    // Insert Events
    echo "<h2>Inserting Events...</h2>\n";
    $events = [
        ['/assets/background-image.png', 'https://example.com/book/1', 'published'],
        ['/assets/background-image.png', 'https://example.com/book/2', 'published'],
        ['/assets/background-image.png', 'https://example.com/book/3', 'published'],
        ['/assets/background-image.png', 'https://example.com/book/4', 'draft'],
        ['/assets/background-image.png', 'https://example.com/book/5', 'published'],
        ['/assets/background-image.png', 'https://example.com/book/6', 'archived']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO events (image, book_url, status) VALUES (?, ?, ?)");
    $eventIds = [];
    foreach ($events as $event) {
        $stmt->execute($event);
        $eventIds[] = $pdo->lastInsertId();
        echo "✓ Inserted event with ID: " . $pdo->lastInsertId() . "\n";
    }
    
    // Insert Event Translations
    echo "<h2>Inserting Event Translations...</h2>\n";
    $eventTranslations = [
        // Event 1 translations
        [1, 'en', 'Magic Birthday Party', 'An unforgettable magical birthday party with interactive performances, games, and surprises for your child and their friends.', 'Book Magic Party', 'Magic birthday party with interactive theatre'],
        [1, 'mk', 'Магичен роденден', 'Незаборавен магичен роденден со интерактивни претстави, игри и изненадувања за вашето дете и неговите пријатели.', 'Резервирај магичен роденден', 'Магичен роденден со интерактивен театар'],
        [1, 'fr', 'Fête d\'anniversaire magique', 'Une fête d\'anniversaire magique inoubliable avec des spectacles interactifs, des jeux et des surprises pour votre enfant et ses amis.', 'Réserver fête magique', 'Fête d\'anniversaire magique avec théâtre interactif'],
        
        // Event 2 translations
        [2, 'en', 'Drama Workshop for Kids', 'Creative drama workshop where children learn acting, storytelling, and self-expression through fun activities.', 'Join Workshop', 'Drama workshop for children'],
        [2, 'mk', 'Драмска работилница за деца', 'Креативна драмска работилница каде децата учат глума, раскажување приказни и самоизразување преку забавни активности.', 'Приклучи се', 'Драмска работилница за деца'],
        [2, 'fr', 'Atelier de théâtre pour enfants', 'Atelier de théâtre créatif où les enfants apprennent le jeu, la narration et l\'expression de soi à travers des activités amusantes.', 'Rejoindre l\'atelier', 'Atelier de théâtre pour enfants'],
        
        // Event 3 translations
        [3, 'en', 'Interactive Fairy Tale Show', 'Join our interactive fairy tale performance where children become part of the story and help the characters solve problems.', 'Book Show', 'Interactive fairy tale performance'],
        [3, 'mk', 'Интерактивна приказна за бајки', 'Приклучете се на нашата интерактивна претстава за бајки каде децата стануваат дел од приказната и им помагаат на ликовите да решат проблеми.', 'Резервирај претстава', 'Интерактивна претстава за бајки'],
        [3, 'fr', 'Spectacle de conte de fées interactif', 'Rejoignez notre spectacle de conte de fées interactif où les enfants deviennent partie de l\'histoire et aident les personnages à résoudre des problèmes.', 'Réserver spectacle', 'Spectacle de conte de fées interactif'],
        
        // Event 4 translations (draft)
        [4, 'en', 'Summer Drama Camp', 'A week-long drama camp during summer holidays with daily activities, performances, and creative workshops.', 'Coming Soon', 'Summer drama camp for children'],
        [4, 'mk', 'Летен драмски камп', 'Еднонеделен драмски камп за време на летните празници со дневни активности, претстави и креативни работилници.', 'Наскоро', 'Летен драмски камп за деца'],
        [4, 'fr', 'Camp de théâtre d\'été', 'Un camp de théâtre d\'une semaine pendant les vacances d\'été avec des activités quotidiennes, des spectacles et des ateliers créatifs.', 'Bientôt', 'Camp de théâtre d\'été pour enfants'],
        
        // Event 5 translations
        [5, 'en', 'Princess & Superhero Party', 'A themed party where children can dress up as their favorite princesses and superheroes with special activities and games.', 'Book Party', 'Princess and superhero themed party'],
        [5, 'mk', 'Забава за принцези и суперхерои', 'Тематска забава каде децата можат да се облечат како нивните омилени принцези и суперхерои со посебни активности и игри.', 'Резервирај забава', 'Забава за принцези и суперхерои'],
        [5, 'fr', 'Fête Princesse et Super-héros', 'Une fête à thème où les enfants peuvent se déguiser en leurs princesses et super-héros préférés avec des activités et jeux spéciaux.', 'Réserver fête', 'Fête à thème princesse et super-héros'],
        
        // Event 6 translations (archived)
        [6, 'en', 'Halloween Spooky Theatre', 'A spooky Halloween theatre experience with costumes, scary stories, and fun activities for brave children.', 'Event Ended', 'Halloween spooky theatre experience'],
        [6, 'mk', 'Страшен театар за Ноќта на вештерките', 'Страшно театарско искуство за Ноќта на вештерките со костуми, страшни приказни и забавни активности за храбри деца.', 'Настанот заврши', 'Страшно театарско искуство за Ноќта на вештерките'],
        [6, 'fr', 'Théâtre effrayant d\'Halloween', 'Une expérience théâtrale effrayante d\'Halloween avec des costumes, des histoires effrayantes et des activités amusantes pour les enfants courageux.', 'Événement terminé', 'Expérience théâtrale effrayante d\'Halloween']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO event_translations (event_id, language_code, title, description, book_label, image_alt) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($eventTranslations as $translation) {
        $stmt->execute($translation);
    }
    echo "✓ Inserted " . count($eventTranslations) . " event translations\n";
    
    echo "<h2>✅ Events Population Complete!</h2>\n";
    echo "<p><strong>Summary:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Events: " . count($events) . "</li>\n";
    echo "<li>Event Translations: " . count($eventTranslations) . "</li>\n";
    echo "</ul>\n";
    
} catch (Exception $e) {
    echo "<h2>❌ Error during events population:</h2>\n";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>\n";
}
?>
