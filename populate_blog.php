<?php
/**
 * Populate Blog Posts and Blog Translations
 * Adds sample blog posts with multilingual content
 */

require_once __DIR__ . '/bootstrap.php';

try {
    $pdo = require __DIR__ . '/bootstrap.php';
    
    echo "<h1>Populating Blog Posts</h1>\n";
    echo "<p>Adding sample blog posts with translations...</p>\n";
    
    // Insert Blog Posts
    echo "<h2>Inserting Blog Posts...</h2>\n";
    $blogPosts = [
        ['benefits-of-drama-for-children', 1, 'published', '/assets/background-image.png', '2024-01-15 10:00:00'],
        ['how-to-organize-kids-party', 1, 'published', '/assets/background-image.png', '2024-01-20 14:30:00'],
        ['creative-activities-for-toddlers', 1, 'published', '/assets/background-image.png', '2024-02-01 09:15:00'],
        ['upcoming-summer-camps', 1, 'draft', '/assets/background-image.png', null],
        ['theater-education-importance', 1, 'published', '/assets/background-image.png', '2024-02-10 16:45:00'],
        ['parenting-through-drama', 1, 'published', '/assets/background-image.png', '2024-02-15 11:20:00'],
        ['children-confidence-building', 1, 'published', '/assets/background-image.png', '2024-02-20 13:10:00']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO blog_posts (slug, author_id, status, featured_image, published_at) VALUES (?, ?, ?, ?, ?)");
    $blogPostIds = [];
    foreach ($blogPosts as $post) {
        $stmt->execute($post);
        $blogPostIds[] = $pdo->lastInsertId();
        echo "✓ Inserted blog post: {$post[0]} (ID: " . $pdo->lastInsertId() . ")\n";
    }
    
    // Insert Blog Post Translations
    echo "<h2>Inserting Blog Post Translations...</h2>\n";
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
        [5, 'fr', 'L\'importance de l\'éducation théâtrale', 'L\'éducation théâtrale joue un rôle crucial dans le développement de l\'intelligence émotionnelle, de l\'empathie et des compétences sociales des enfants grâce à la narration collaborative.', 'Explorez pourquoi l\'éducation théâtrale est essentielle pour le développement holistique de l\'enfant et comment elle prépare les enfants aux défis futurs.'],
        
        // Blog post 6 translations
        [6, 'en', 'Parenting Through Drama', 'How drama and theater activities can strengthen the parent-child bond and create meaningful family experiences.', 'Learn how to use drama techniques at home to connect with your child and support their emotional development.'],
        [6, 'mk', 'Родителство преку драма', 'Како драмските и театарските активности можат да ја зацврстат врската родител-дете и да создадат значајни семејни искуства.', 'Научете како да користите драмски техники дома за да се поврзете со вашето дете и да го поддржите неговиот емоционален развој.'],
        [6, 'fr', 'Parentalité par le théâtre', 'Comment les activités de théâtre et de drame peuvent renforcer le lien parent-enfant et créer des expériences familiales significatives.', 'Apprenez à utiliser les techniques théâtrales à la maison pour vous connecter avec votre enfant et soutenir son développement émotionnel.'],
        
        // Blog post 7 translations
        [7, 'en', 'Building Children\'s Confidence Through Performance', 'Performance activities help children develop self-confidence, public speaking skills, and emotional resilience.', 'Discover how participating in theater and drama can transform your child\'s confidence and social skills.'],
        [7, 'mk', 'Градење на самодоверба кај децата преку настапување', 'Активностите за настапување им помагаат на децата да развијат самодоверба, вештини за јавно говорење и емоционална отпорност.', 'Откријте како учеството во театар и драма може да ја трансформира самодовербата и социјалните вештини на вашето дете.'],
        [7, 'fr', 'Développer la confiance des enfants par la performance', 'Les activités de performance aident les enfants à développer la confiance en soi, les compétences de prise de parole en public et la résilience émotionnelle.', 'Découvrez comment participer au théâtre et au drame peut transformer la confiance et les compétences sociales de votre enfant.']
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
    
    echo "<h2>✅ Blog Posts Population Complete!</h2>\n";
    echo "<p><strong>Summary:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Blog Posts: " . count($blogPosts) . "</li>\n";
    echo "<li>Blog Translations: " . count($blogTranslations) . "</li>\n";
    echo "</ul>\n";
    
} catch (Exception $e) {
    echo "<h2>❌ Error during blog posts population:</h2>\n";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>\n";
}
?>
