<?php
/**
 * Populate Missing Content and Translations
 * Adds all the missing placeholder content shown in the UI
 */

require_once __DIR__ . '/bootstrap.php';

try {
    $pdo = require __DIR__ . '/bootstrap.php';
    
    echo "<h1>Populating Missing Content</h1>\n";
    echo "<p>Adding all missing placeholder content...</p>\n";
    
    // Insert Missing Translations
    echo "<h2>Inserting Missing Translations...</h2>\n";
    $missingTranslations = [
        // Service titles and descriptions
        ['en', 'service1_title', 'Interactive Theatre Performances'],
        ['en', 'service1_desc', 'Engaging theatrical shows where children become part of the story and help characters solve problems through interactive participation.'],
        ['en', 'service2_title', 'Drama Workshops'],
        ['en', 'service2_desc', 'Creative drama classes where children learn acting, storytelling, and self-expression through fun activities and games.'],
        ['en', 'service3_title', 'Creative Writing Classes'],
        ['en', 'service3_desc', 'Inspire your child\'s imagination with our creative writing workshops that combine storytelling with drama and performance.'],
        ['en', 'service4_title', 'Party Planning Services'],
        ['en', 'service4_desc', 'Complete party planning for unforgettable birthday celebrations with themed decorations, activities, and entertainment.'],
        ['en', 'service5_title', 'Professional Development'],
        ['en', 'service5_desc', 'Training programs for educators and parents on using drama techniques to enhance children\'s learning and development.'],
        
        // About section
        ['en', 'about_mission_title', 'Our Mission'],
        ['en', 'about_mission_desc', 'To inspire creativity and confidence in children through interactive theatre and creative arts, fostering imagination and self-expression.'],
        ['en', 'about_values_title', 'Our Values'],
        ['en', 'about_values_desc', 'We believe in the power of play, creativity, and storytelling to help children develop essential life skills and emotional intelligence.'],
        ['en', 'about_approach_title', 'Our Approach'],
        ['en', 'about_approach_list', 'Interactive learning, Creative expression, Safe environment, Individual attention, Fun and engaging activities'],
        
        // Party and animation content
        ['en', 'party_animation_title', 'Magical Party Experiences'],
        ['en', 'party_animation_body', 'Transform your child\'s special day into an unforgettable adventure with our themed party packages, interactive entertainment, and personalized activities designed to create lasting memories.'],
        ['en', 'party_ideas_title', 'Creative Party Ideas'],
        ['en', 'party_ideas_body', 'From princess tea parties to superhero adventures, we offer a wide range of themed party packages that bring your child\'s dreams to life with professional entertainment and creative activities.'],
        
        // Footer content
        ['en', 'footer_brand_title', 'Teatar za tebe'],
        ['en', 'footer_page_desc', 'Creating magical experiences for children through interactive theatre, creative workshops, and unforgettable parties.'],
        ['en', 'footer_chann', 'Join our community'],
        ['en', 'footer_channel_members', 'Connect with other parents and stay updated on our latest events and workshops.'],
        ['en', 'footer_rights', 'All rights reserved.'],
        
        // Macedonian translations
        ['mk', 'service1_title', 'Интерактивни театарски претстави'],
        ['mk', 'service1_desc', 'Ангажирачки театарски претстави каде децата стануваат дел од приказната и им помагаат на ликовите да решат проблеми преку интерактивно учество.'],
        ['mk', 'service2_title', 'Драмски работилници'],
        ['mk', 'service2_desc', 'Креативни драмски часови каде децата учат глума, раскажување приказни и самоизразување преку забавни активности и игри.'],
        ['mk', 'service3_title', 'Креативни часови за пишување'],
        ['mk', 'service3_desc', 'Инспирирајте ја имагинацијата на вашето дете со нашите креативни работилници за пишување кои комбинираат раскажување приказни со драма и настапување.'],
        ['mk', 'service4_title', 'Услуги за планирање забави'],
        ['mk', 'service4_desc', 'Комплетно планирање на забави за незаборавни прослави на родендени со тематски украси, активности и забава.'],
        ['mk', 'service5_title', 'Професионален развој'],
        ['mk', 'service5_desc', 'Програми за обука на едукатори и родители за користење на драмски техники за подобрување на учењето и развојот на децата.'],
        
        ['mk', 'about_mission_title', 'Нашата мисија'],
        ['mk', 'about_mission_desc', 'Да ја инспирираме креативноста и самодовербата кај децата преку интерактивен театар и креативни уметности, поттикнувајќи имагинација и самоизразување.'],
        ['mk', 'about_values_title', 'Нашите вредности'],
        ['mk', 'about_values_desc', 'Веруваме во моќта на играта, креативноста и раскажувањето приказни за да им помогнеме на децата да развијат основни животни вештини и емоционална интелигенција.'],
        ['mk', 'about_approach_title', 'Нашиот пристап'],
        ['mk', 'about_approach_list', 'Интерактивно учење, Креативно изразување, Безбедна средина, Индивидуално внимание, Забавни и ангажирачки активности'],
        
        ['mk', 'party_animation_title', 'Магични искуства од забави'],
        ['mk', 'party_animation_body', 'Трансформирајте го посебниот ден на вашето дете во незаборавна авантура со нашите тематски пакети за забави, интерактивна забава и персонализирани активности дизајнирани да создадат трајни спомени.'],
        ['mk', 'party_ideas_title', 'Креативни идеи за забави'],
        ['mk', 'party_ideas_body', 'Од чајни забави за принцези до авантури на суперхерои, нудиме широк спектар на тематски пакети за забави кои ги оживуваат соништата на вашето дете со професионална забава и креативни активности.'],
        
        ['mk', 'footer_brand_title', 'Театар за тебе'],
        ['mk', 'footer_page_desc', 'Создаваме магични искуства за деца преку интерактивен театар, креативни работилници и незаборавни забави.'],
        ['mk', 'footer_chann', 'Приклучете се на нашата заедница'],
        ['mk', 'footer_channel_members', 'Поврзете се со други родители и бидете во тек со нашите најнови настани и работилници.'],
        ['mk', 'footer_rights', 'Сите права се задржани.'],
        
        // French translations
        ['fr', 'service1_title', 'Spectacles de théâtre interactif'],
        ['fr', 'service1_desc', 'Des spectacles théâtraux engageants où les enfants deviennent partie de l\'histoire et aident les personnages à résoudre des problèmes grâce à la participation interactive.'],
        ['fr', 'service2_title', 'Ateliers de théâtre'],
        ['fr', 'service2_desc', 'Des cours de théâtre créatifs où les enfants apprennent le jeu, la narration et l\'expression de soi à travers des activités et jeux amusants.'],
        ['fr', 'service3_title', 'Cours d\'écriture créative'],
        ['fr', 'service3_desc', 'Inspirez l\'imagination de votre enfant avec nos ateliers d\'écriture créative qui combinent la narration avec le théâtre et la performance.'],
        ['fr', 'service4_title', 'Services de planification de fêtes'],
        ['fr', 'service4_desc', 'Planification complète de fêtes pour des célébrations d\'anniversaire inoubliables avec des décorations thématiques, des activités et des divertissements.'],
        ['fr', 'service5_title', 'Développement professionnel'],
        ['fr', 'service5_desc', 'Programmes de formation pour éducateurs et parents sur l\'utilisation des techniques théâtrales pour améliorer l\'apprentissage et le développement des enfants.'],
        
        ['fr', 'about_mission_title', 'Notre mission'],
        ['fr', 'about_mission_desc', 'Inspirer la créativité et la confiance chez les enfants grâce au théâtre interactif et aux arts créatifs, favorisant l\'imagination et l\'expression de soi.'],
        ['fr', 'about_values_title', 'Nos valeurs'],
        ['fr', 'about_values_desc', 'Nous croyons au pouvoir du jeu, de la créativité et de la narration pour aider les enfants à développer des compétences de vie essentielles et l\'intelligence émotionnelle.'],
        ['fr', 'about_approach_title', 'Notre approche'],
        ['fr', 'about_approach_list', 'Apprentissage interactif, Expression créative, Environnement sécurisé, Attention individuelle, Activités amusantes et engageantes'],
        
        ['fr', 'party_animation_title', 'Expériences de fête magiques'],
        ['fr', 'party_animation_body', 'Transformez le jour spécial de votre enfant en une aventure inoubliable avec nos forfaits de fête thématiques, divertissement interactif et activités personnalisées conçues pour créer des souvenirs durables.'],
        ['fr', 'party_ideas_title', 'Idées de fête créatives'],
        ['fr', 'party_ideas_body', 'Des goûters de princesses aux aventures de super-héros, nous offrons une large gamme de forfaits de fête thématiques qui donnent vie aux rêves de votre enfant avec divertissement professionnel et activités créatives.'],
        
        ['fr', 'footer_brand_title', 'Théâtre pour toi'],
        ['fr', 'footer_page_desc', 'Créer des expériences magiques pour les enfants grâce au théâtre interactif, aux ateliers créatifs et aux fêtes inoubliables.'],
        ['fr', 'footer_chann', 'Rejoignez notre communauté'],
        ['fr', 'footer_channel_members', 'Connectez-vous avec d\'autres parents et restez informé de nos derniers événements et ateliers.'],
        ['fr', 'footer_rights', 'Tous droits réservés.']
    ];
    
    // Use REPLACE to update existing entries with proper encoding
    $stmt = $pdo->prepare("REPLACE INTO translations (language_code, translation_key, translation_value) VALUES (?, ?, ?)");
    foreach ($missingTranslations as $translation) {
        $stmt->execute($translation);
    }
    echo "✓ Inserted/Updated " . count($missingTranslations) . " missing translations with proper UTF-8 encoding\n";
    
    // Add more events to fill the gaps
    echo "<h2>Adding More Events...</h2>\n";
    $additionalEvents = [
        ['/assets/background-image.png', 'https://example.com/book/7', 'published'],
        ['/assets/background-image.png', 'https://example.com/book/8', 'published'],
        ['/assets/background-image.png', 'https://example.com/book/9', 'published']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO events (image, book_url, status) VALUES (?, ?, ?)");
    $newEventIds = [];
    foreach ($additionalEvents as $event) {
        $stmt->execute($event);
        $newEventIds[] = $pdo->lastInsertId();
        echo "✓ Inserted event with ID: " . $pdo->lastInsertId() . "\n";
    }
    
    // Add translations for new events
    echo "<h2>Adding Event Translations...</h2>\n";
    $newEventTranslations = [
        // Event 7 translations
        [7, 'en', 'Creative Art Workshop', 'Explore painting, drawing, and sculpture in our creative art workshop designed to inspire young artists.', 'Join Art Class', 'Creative art workshop for children'],
        [7, 'mk', 'Креативна уметничка работилница', 'Истражете сликање, цртање и вајарство во нашата креативна уметничка работилница дизајнирана да ги инспирира младите уметници.', 'Приклучи се на уметнички час', 'Креативна уметничка работилница за деца'],
        [7, 'fr', 'Atelier d\'art créatif', 'Explorez la peinture, le dessin et la sculpture dans notre atelier d\'art créatif conçu pour inspirer les jeunes artistes.', 'Rejoindre la classe d\'art', 'Atelier d\'art créatif pour enfants'],
        
        // Event 8 translations
        [8, 'en', 'Music and Movement Class', 'Combine music, dance, and movement in this energetic class that helps children develop rhythm and coordination.', 'Book Music Class', 'Music and movement class for kids'],
        [8, 'mk', 'Час за музика и движење', 'Комбинирајте музика, танц и движење во овој енергичен час што им помага на децата да развијат ритам и координација.', 'Резервирај музички час', 'Час за музика и движење за деца'],
        [8, 'fr', 'Cours de musique et mouvement', 'Combinez musique, danse et mouvement dans cette classe énergique qui aide les enfants à développer le rythme et la coordination.', 'Réserver cours de musique', 'Cours de musique et mouvement pour enfants'],
        
        // Event 9 translations
        [9, 'en', 'Science Adventure Workshop', 'Discover the wonders of science through hands-on experiments and interactive demonstrations.', 'Join Science Class', 'Science adventure workshop for children'],
        [9, 'mk', 'Научна авантуристичка работилница', 'Откријте ги чудата на науката преку практични експерименти и интерактивни демонстрации.', 'Приклучи се на научен час', 'Научна авантуристичка работилница за деца'],
        [9, 'fr', 'Atelier d\'aventure scientifique', 'Découvrez les merveilles de la science à travers des expériences pratiques et des démonstrations interactives.', 'Rejoindre la classe de sciences', 'Atelier d\'aventure scientifique pour enfants']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO event_translations (event_id, language_code, title, description, book_label, image_alt) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($newEventTranslations as $translation) {
        $stmt->execute($translation);
    }
    echo "✓ Inserted " . count($newEventTranslations) . " new event translations\n";
    
    echo "<h2>✅ Missing Content Population Complete!</h2>\n";
    echo "<p><strong>Summary:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Missing Translations: " . count($missingTranslations) . "</li>\n";
    echo "<li>Additional Events: " . count($additionalEvents) . "</li>\n";
    echo "<li>New Event Translations: " . count($newEventTranslations) . "</li>\n";
    echo "</ul>\n";
    
    echo "<p><strong>All placeholder content has been filled!</strong></p>\n";
    echo "<p><a href='index.php'>Visit your website</a> to see the updated content.</p>\n";
    
} catch (Exception $e) {
    echo "<h2>❌ Error during missing content population:</h2>\n";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>\n";
}
?>
