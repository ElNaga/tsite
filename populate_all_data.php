<?php
/**
 * Database Population Script
 * Populates all database tables with comprehensive sample data
 */

require_once __DIR__ . '/bootstrap.php';

try {
    $pdo = require __DIR__ . '/bootstrap.php';
    
    echo "<h1>Database Population Script</h1>\n";
    echo "<p>Starting database population...</p>\n";
    
    // Clear existing data (optional - comment out if you want to keep existing data)
    echo "<h2>Clearing existing data...</h2>\n";
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("TRUNCATE TABLE transactions");
    $pdo->exec("TRUNCATE TABLE blog_post_translations");
    $pdo->exec("TRUNCATE TABLE blog_posts");
    $pdo->exec("TRUNCATE TABLE event_translations");
    $pdo->exec("TRUNCATE TABLE events");
    $pdo->exec("TRUNCATE TABLE user_sessions");
    $pdo->exec("TRUNCATE TABLE users");
    $pdo->exec("TRUNCATE TABLE translations");
    $pdo->exec("TRUNCATE TABLE languages");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    // 1. Insert Languages
    echo "<h2>1. Inserting Languages...</h2>\n";
    $languages = [
        ['en', 'English', 1],
        ['mk', 'Македонски', 1],
        ['fr', 'Français', 1],
        ['de', 'Deutsch', 0], // Inactive language
        ['es', 'Español', 0]  // Inactive language
    ];
    
    $stmt = $pdo->prepare("INSERT INTO languages (code, name, is_active) VALUES (?, ?, ?)");
    foreach ($languages as $lang) {
        $stmt->execute($lang);
        echo "✓ Inserted language: {$lang[1]} ({$lang[0]})\n";
    }
    
    // 2. Insert Users
    echo "<h2>2. Inserting Users...</h2>\n";
    $users = [
        ['admin@teatarzatebe.mk', password_hash('admin123', PASSWORD_DEFAULT), 'Admin User', 'admin', 1],
        ['editor@teatarzatebe.mk', password_hash('editor123', PASSWORD_DEFAULT), 'Content Editor', 'editor', 1],
        ['john.doe@example.com', password_hash('user123', PASSWORD_DEFAULT), 'John Doe', 'user', 1],
        ['jane.smith@example.com', password_hash('user123', PASSWORD_DEFAULT), 'Jane Smith', 'user', 1],
        ['maria.garcia@example.com', password_hash('user123', PASSWORD_DEFAULT), 'Maria Garcia', 'user', 0] // Inactive
    ];
    
    $stmt = $pdo->prepare("INSERT INTO users (email, password_hash, name, role, is_active) VALUES (?, ?, ?, ?, ?)");
    foreach ($users as $user) {
        $stmt->execute($user);
        echo "✓ Inserted user: {$user[2]} ({$user[0]}) - Role: {$user[3]}\n";
    }
    
    // 3. Insert Translations
    echo "<h2>3. Inserting Translations...</h2>\n";
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
        ['fr', 'testimonials_title', 'Ce que disent les parents']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO translations (language_code, translation_key, translation_value) VALUES (?, ?, ?)");
    foreach ($translations as $translation) {
        $stmt->execute($translation);
    }
    echo "✓ Inserted " . count($translations) . " translations\n";
    
    // 4. Insert Events
    echo "<h2>4. Inserting Events...</h2>\n";
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
    
    // 5. Insert Event Translations
    echo "<h2>5. Inserting Event Translations...</h2>\n";
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
    
    // 6. Insert Blog Posts
    echo "<h2>6. Inserting Blog Posts...</h2>\n";
    $blogPosts = [
        ['benefits-of-drama-for-children', 2, 'published', '/assets/background-image.png', '2024-01-15 10:00:00'],
        ['how-to-organize-kids-party', 2, 'published', '/assets/background-image.png', '2024-01-20 14:30:00'],
        ['creative-activities-for-toddlers', 2, 'published', '/assets/background-image.png', '2024-02-01 09:15:00'],
        ['upcoming-summer-camps', 2, 'draft', '/assets/background-image.png', null],
        ['theater-education-importance', 1, 'published', '/assets/background-image.png', '2024-02-10 16:45:00']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO blog_posts (slug, author_id, status, featured_image, published_at) VALUES (?, ?, ?, ?, ?)");
    $blogPostIds = [];
    foreach ($blogPosts as $post) {
        $stmt->execute($post);
        $blogPostIds[] = $pdo->lastInsertId();
        echo "✓ Inserted blog post: {$post[0]} (ID: " . $pdo->lastInsertId() . ")\n";
    }
    
    // 7. Insert Blog Post Translations
    echo "<h2>7. Inserting Blog Post Translations...</h2>\n";
    $blogTranslations = [
        // Blog post 1 translations
        [1, 'en', 'The Benefits of Drama for Children', 'Drama and theatre activities provide numerous benefits for children\'s development, including improved communication skills, creativity, and confidence.', 'Discover how drama can help your child grow and develop essential life skills through creative expression and storytelling.'],
        [1, 'mk', 'Предностите на драмата за децата', 'Драмските и театарските активности даваат бројни предности за развојот на децата, вклучувајќи подобрени комуникациски вештини, креативност и самодоверба.', 'Откријте како драмата може да им помогне на вашите деца да растат и развиваат основни животни вештини преку креативно изразување и раскажување приказни.'],
        [1, 'fr', 'Les avantages du théâtre pour les enfants', 'Les activités de théâtre et de drame offrent de nombreux avantages pour le développement des enfants, notamment l\'amélioration des compétences de communication, la créativité et la confiance.', 'Découvrez comment le théâtre peut aider votre enfant à grandir et à développer des compétences de vie essentielles grâce à l\'expression créative et à la narration.'],
        
        // Blog post 2 translations
        [2, 'en', 'How to Organize the Perfect Kids Party', 'Planning a children\'s party can be overwhelming, but with the right approach, you can create unforgettable memories for your child and their friends.', 'Learn practical tips and tricks for organizing a successful children\'s party that everyone will enjoy.'],
        [2, 'mk', 'Како да организирате совршена детска забава', 'Планирањето на детска забава може да биде преоптоварувачко, но со правилен пристап, можете да создадете незаборавни спомени за вашето дете и неговите пријатели.', 'Научете практични совети и трикови за организирање на успешна детска забава што ќе им се допадне на сите.'],
        [2, 'fr', 'Comment organiser la fête d\'enfants parfaite', 'Organiser une fête d\'enfants peut être accablant, mais avec la bonne approche, vous pouvez créer des souvenirs inoubliables pour votre enfant et ses amis.', 'Apprenez des conseils et astuces pratiques pour organiser une fête d\'enfants réussie que tout le monde appréciera.'],
        
        // Blog post 3 translations
        [3, 'en', 'Creative Activities for Toddlers', 'Engage your toddler with creative activities that promote learning, motor skills, and imagination through play and exploration.', 'Discover age-appropriate creative activities that will keep your toddler entertained while supporting their development.'],
        [3, 'mk', 'Креативни активности за мали деца', 'Ангажирајте го вашето мало дете со креативни активности кои промовираат учење, моторни вештини и имагинација преку игра и истражување.', 'Откријте креативни активности соодветни за возраста што ќе го забавуваат вашето мало дете додека го поддржуваат неговиот развој.'],
        [3, 'fr', 'Activités créatives pour les tout-petits', 'Engagez votre tout-petit avec des activités créatives qui favorisent l\'apprentissage, les compétences motrices et l\'imagination par le jeu et l\'exploration.', 'Découvrez des activités créatives adaptées à l\'âge qui divertiront votre tout-petit tout en soutenant son développement.'],
        
        // Blog post 4 translations (draft)
        [4, 'en', 'Upcoming Summer Drama Camps', 'Get ready for an exciting summer with our drama camps featuring daily activities, performances, and creative workshops for children of all ages.', 'Registration will open soon for our summer drama camps. Stay tuned for more details!'],
        [4, 'mk', 'Претстојни летни драмски кампови', 'Подгответе се за возбудливо лето со нашите драмски кампови со дневни активности, претстави и креативни работилници за деца од сите возрасти.', 'Регистрацијата ќе се отвори наскоро за нашите летни драмски кампови. Следете не за повеќе детали!'],
        [4, 'fr', 'Camps de théâtre d\'été à venir', 'Préparez-vous pour un été passionnant avec nos camps de théâtre comprenant des activités quotidiennes, des spectacles et des ateliers créatifs pour enfants de tous âges.', 'L\'inscription ouvrira bientôt pour nos camps de théâtre d\'été. Restez à l\'écoute pour plus de détails!'],
        
        // Blog post 5 translations
        [5, 'en', 'The Importance of Theater Education', 'Theater education plays a crucial role in developing children\'s emotional intelligence, empathy, and social skills through collaborative storytelling.', 'Explore why theater education is essential for holistic child development and how it prepares children for future challenges.'],
        [5, 'mk', 'Важноста на театарското образование', 'Театарското образование игра клучна улога во развивањето на емоционалната интелигенција, емпатијата и социјалните вештини на децата преку колаборативно раскажување приказни.', 'Истражете зошто театарското образование е суштинско за холистичкиот развој на детето и како ги подготвува децата за идни предизвици.'],
        [5, 'fr', 'L\'importance de l\'éducation théâtrale', 'L\'éducation théâtrale joue un rôle crucial dans le développement de l\'intelligence émotionnelle, de l\'empathie et des compétences sociales des enfants grâce à la narration collaborative.', 'Explorez pourquoi l\'éducation théâtrale est essentielle pour le développement holistique de l\'enfant et comment elle prépare les enfants aux défis futurs.']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO blog_post_translations (blog_post_id, language_code, title, content, excerpt, meta_title, meta_description) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($blogTranslations as $translation) {
        $content = $translation[3] . "\n\n" . str_repeat("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\n", 3);
        $stmt->execute([
            $translation[0], // blog_post_id
            $translation[1], // language_code
            $translation[2], // title
            $content,        // content
            $translation[4], // excerpt
            $translation[2], // meta_title (same as title)
            $translation[4]  // meta_description (same as excerpt)
        ]);
    }
    echo "✓ Inserted " . count($blogTranslations) . " blog post translations\n";
    
    // 8. Insert Transactions
    echo "<h2>8. Inserting Transactions...</h2>\n";
    $transactions = [
        [1, '{"name": "John Smith", "email": "john@example.com", "phone": "+38970123456", "child_name": "Emma", "child_age": 7, "guests": 12}', 'confirmed', 150.00, 'bank_transfer'],
        [1, '{"name": "Maria Garcia", "email": "maria@example.com", "phone": "+38970234567", "child_name": "Luka", "child_age": 5, "guests": 8}', 'pending', 120.00, 'cash'],
        [2, '{"name": "David Johnson", "email": "david@example.com", "phone": "+38970345678", "child_name": "Sofia", "child_age": 9, "guests": 15}', 'completed', 180.00, 'credit_card'],
        [3, '{"name": "Anna Petrov", "email": "anna@example.com", "phone": "+38970456789", "child_name": "Marko", "child_age": 6, "guests": 10}', 'confirmed', 140.00, 'bank_transfer'],
        [5, '{"name": "Sarah Wilson", "email": "sarah@example.com", "phone": "+38970567890", "child_name": "Nikola", "child_age": 8, "guests": 20}', 'pending', 200.00, 'credit_card'],
        [1, '{"name": "Michael Brown", "email": "michael@example.com", "phone": "+38970678901", "child_name": "Elena", "child_age": 4, "guests": 6}', 'cancelled', 100.00, 'bank_transfer']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO transactions (event_id, user_data, status, amount, payment_method) VALUES (?, ?, ?, ?, ?)");
    foreach ($transactions as $transaction) {
        $stmt->execute($transaction);
        echo "✓ Inserted transaction for event {$transaction[0]} - Status: {$transaction[2]}\n";
    }
    
    // 9. Insert User Sessions
    echo "<h2>9. Inserting User Sessions...</h2>\n";
    $sessions = [
        ['sess_' . uniqid(), 1, '{"login_time": "' . date('Y-m-d H:i:s') . '", "ip": "192.168.1.100", "user_agent": "Mozilla/5.0..."}', date('Y-m-d H:i:s', strtotime('+2 hours'))],
        ['sess_' . uniqid(), 2, '{"login_time": "' . date('Y-m-d H:i:s') . '", "ip": "192.168.1.101", "user_agent": "Mozilla/5.0..."}', date('Y-m-d H:i:s', strtotime('+1 hour'))],
        ['sess_' . uniqid(), null, '{"guest": true, "visit_time": "' . date('Y-m-d H:i:s') . '", "ip": "192.168.1.102"}', date('Y-m-d H:i:s', strtotime('+30 minutes'))]
    ];
    
    $stmt = $pdo->prepare("INSERT INTO user_sessions (session_id, user_id, user_data, expires_at) VALUES (?, ?, ?, ?)");
    foreach ($sessions as $session) {
        $stmt->execute($session);
        echo "✓ Inserted session: {$session[0]}\n";
    }
    
    echo "<h2>✅ Database Population Complete!</h2>\n";
    echo "<p><strong>Summary:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Languages: " . count($languages) . "</li>\n";
    echo "<li>Users: " . count($users) . "</li>\n";
    echo "<li>Translations: " . count($translations) . "</li>\n";
    echo "<li>Events: " . count($events) . "</li>\n";
    echo "<li>Event Translations: " . count($eventTranslations) . "</li>\n";
    echo "<li>Blog Posts: " . count($blogPosts) . "</li>\n";
    echo "<li>Blog Translations: " . count($blogTranslations) . "</li>\n";
    echo "<li>Transactions: " . count($transactions) . "</li>\n";
    echo "<li>User Sessions: " . count($sessions) . "</li>\n";
    echo "</ul>\n";
    
    echo "<p><strong>Test your application:</strong></p>\n";
    echo "<ul>\n";
    echo "<li><a href='index.php'>Visit Homepage</a></li>\n";
    echo "<li><a href='admin_login.php'>Admin Login</a> (admin@teatarzatebe.mk / admin123)</li>\n";
    echo "<li><a href='check_pdo.php'>Check PDO Status</a></li>\n";
    echo "</ul>\n";
    
} catch (Exception $e) {
    echo "<h2>❌ Error during database population:</h2>\n";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>\n";
    echo "<p>Stack trace:</p>\n";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>\n";
}
?>
