<?php
/**
 * Populate Translations
 * Adds comprehensive static content translations in multiple languages
 */

require_once __DIR__ . '/bootstrap.php';

try {
    $pdo = require __DIR__ . '/bootstrap.php';
    
    echo "<h1>Populating Translations</h1>\n";
    echo "<p>Adding comprehensive static content translations...</p>\n";
    
    // Insert Comprehensive Translations
    echo "<h2>Inserting Translations...</h2>\n";
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
        ['en', 'welcome_message', 'Welcome to Teatar za tebe!'],
        ['en', 'services_title', 'Our Services'],
        ['en', 'events_title', 'Upcoming Events'],
        ['en', 'testimonials_title', 'What Parents Say'],
        ['en', 'hero_title', 'Magical Experiences for Your Child'],
        ['en', 'hero_subtitle', 'Interactive theatre, creative workshops, and unforgettable birthday parties'],
        ['en', 'about_title', 'About Teatar za tebe'],
        ['en', 'about_description', 'We create magical experiences that inspire creativity and joy in children through interactive theatre and creative activities.'],
        ['en', 'contact_title', 'Get in Touch'],
        ['en', 'contact_description', 'Ready to create magical memories? Contact us to book your next event!'],
        ['en', 'phone', 'Phone'],
        ['en', 'email', 'Email'],
        ['en', 'address', 'Address'],
        ['en', 'hours', 'Working Hours'],
        ['en', 'monday_friday', 'Monday - Friday'],
        ['en', 'saturday', 'Saturday'],
        ['en', 'sunday', 'Sunday'],
        ['en', 'closed', 'Closed'],
        ['en', 'follow_us', 'Follow Us'],
        ['en', 'all_rights_reserved', 'All rights reserved'],
        ['en', 'privacy_policy', 'Privacy Policy'],
        ['en', 'terms_of_service', 'Terms of Service'],
        
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
        ['mk', 'welcome_message', 'Добредојдовте во Театар за тебе!'],
        ['mk', 'services_title', 'Наши услуги'],
        ['mk', 'events_title', 'Претстојни настани'],
        ['mk', 'testimonials_title', 'Што велат родителите'],
        ['mk', 'hero_title', 'Магични искуства за вашето дете'],
        ['mk', 'hero_subtitle', 'Интерактивен театар, креативни работилници и незаборавни родендени'],
        ['mk', 'about_title', 'За Театар за тебе'],
        ['mk', 'about_description', 'Создаваме магични искуства кои ги инспирираат креативноста и радоста кај децата преку интерактивен театар и креативни активности.'],
        ['mk', 'contact_title', 'Контактирајте не'],
        ['mk', 'contact_description', 'Подготвени да создадете магични спомени? Контактирајте не за да го закажете вашиот следен настан!'],
        ['mk', 'phone', 'Телефон'],
        ['mk', 'email', 'Е-пошта'],
        ['mk', 'address', 'Адреса'],
        ['mk', 'hours', 'Работно време'],
        ['mk', 'monday_friday', 'Понеделник - Петок'],
        ['mk', 'saturday', 'Сабота'],
        ['mk', 'sunday', 'Недела'],
        ['mk', 'closed', 'Затворено'],
        ['mk', 'follow_us', 'Следете не'],
        ['mk', 'all_rights_reserved', 'Сите права се задржани'],
        ['mk', 'privacy_policy', 'Политика за приватност'],
        ['mk', 'terms_of_service', 'Услови за користење'],
        
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
        ['fr', 'not_found_message', 'Désolé, la page que vous recherchez n\'existe pas ou a été déplacée. Essayez de revenir à la page d\'accueil.'],
        ['fr', 'welcome_message', 'Bienvenue au Théâtre pour toi!'],
        ['fr', 'services_title', 'Nos services'],
        ['fr', 'events_title', 'Événements à venir'],
        ['fr', 'testimonials_title', 'Ce que disent les parents'],
        ['fr', 'hero_title', 'Expériences magiques pour votre enfant'],
        ['fr', 'hero_subtitle', 'Théâtre interactif, ateliers créatifs et fêtes d\'anniversaire inoubliables'],
        ['fr', 'about_title', 'À propos du Théâtre pour toi'],
        ['fr', 'about_description', 'Nous créons des expériences magiques qui inspirent la créativité et la joie chez les enfants grâce au théâtre interactif et aux activités créatives.'],
        ['fr', 'contact_title', 'Contactez-nous'],
        ['fr', 'contact_description', 'Prêt à créer des souvenirs magiques? Contactez-nous pour réserver votre prochain événement!'],
        ['fr', 'phone', 'Téléphone'],
        ['fr', 'email', 'E-mail'],
        ['fr', 'address', 'Adresse'],
        ['fr', 'hours', 'Heures d\'ouverture'],
        ['fr', 'monday_friday', 'Lundi - Vendredi'],
        ['fr', 'saturday', 'Samedi'],
        ['fr', 'sunday', 'Dimanche'],
        ['fr', 'closed', 'Fermé'],
        ['fr', 'follow_us', 'Suivez-nous'],
        ['fr', 'all_rights_reserved', 'Tous droits réservés'],
        ['fr', 'privacy_policy', 'Politique de confidentialité'],
        ['fr', 'terms_of_service', 'Conditions d\'utilisation']
    ];
    
    // Use REPLACE to update existing entries with proper encoding
    $stmt = $pdo->prepare("REPLACE INTO translations (language_code, translation_key, translation_value) VALUES (?, ?, ?)");
    foreach ($translations as $translation) {
        $stmt->execute($translation);
    }
    echo "✓ Inserted/Updated " . count($translations) . " translations with proper UTF-8 encoding\n";
    
    echo "<h2>✅ Translations Population Complete!</h2>\n";
    echo "<p><strong>Summary:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Total Translations: " . count($translations) . "</li>\n";
    echo "<li>Languages: English, Macedonian, French</li>\n";
    echo "<li>Translation Keys: " . count(array_unique(array_column($translations, 1))) . "</li>\n";
    echo "</ul>\n";
    
} catch (Exception $e) {
    echo "<h2>❌ Error during translations population:</h2>\n";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>\n";
}
?>
