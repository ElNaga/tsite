<?php
/**
 * Populate About Page Translations
 * Adds all missing translations for the About page
 */

require_once __DIR__ . '/bootstrap.php';

try {
    $pdo = require __DIR__ . '/bootstrap.php';
    
    echo "<h1>Populating About Page Translations</h1>\n";
    echo "<p>Adding all missing About page translations...</p>\n";
    
    // Insert About Page Translations
    echo "<h2>Inserting About Page Translations...</h2>\n";
    $aboutTranslations = [
        // English translations
        ['en', 'about_hero_title', 'About Teatar za tebe'],
        ['en', 'about_hero_subtitle', 'Creating magical experiences for children through interactive theatre, creative workshops, and unforgettable parties.'],
        ['en', 'about_story_title', 'Our Story'],
        ['en', 'about_story_desc', 'Founded with a passion for children\'s development and creativity, Teatar za tebe began as a small initiative to bring interactive theatre to local communities. Our journey started when we realized the transformative power of drama and storytelling in children\'s lives.'],
        ['en', 'about_story_desc2', 'Today, we continue to grow and evolve, reaching hundreds of children and families across the region. Our commitment remains the same: to create safe, engaging, and educational experiences that spark imagination and build confidence in every child we work with.'],
        ['en', 'about_story_image_alt', 'Teatar za tebe team working with children'],
        ['en', 'value_creativity_title', 'Creativity'],
        ['en', 'value_creativity_desc', 'We believe in the power of creative expression to unlock children\'s potential and inspire their imagination through drama, art, and storytelling.'],
        ['en', 'value_community_title', 'Community'],
        ['en', 'value_community_desc', 'Building strong connections between children, families, and our team to create a supportive environment where everyone can thrive and grow together.'],
        ['en', 'value_excellence_title', 'Excellence'],
        ['en', 'value_excellence_desc', 'Committed to delivering the highest quality experiences with professional performers, safe environments, and carefully crafted programs that exceed expectations.'],
        ['en', 'about_team_title', 'Meet Our Team'],
        ['en', 'about_team_intro', 'Our passionate team of educators, performers, and creative professionals are dedicated to making every child\'s experience magical and memorable.'],
        ['en', 'about_team_placeholder', 'Our team information is being updated. Please check back soon!'],
        ['en', 'about_join_us', 'Join Our Team'],
        ['en', 'about_cta_title', 'Ready to Create Magic?'],
        ['en', 'about_cta_desc', 'Whether you\'re planning a birthday party, looking for creative workshops, or want to collaborate with us, we\'d love to hear from you.'],
        
        // Macedonian translations
        ['mk', 'about_hero_title', 'За Театар за тебе'],
        ['mk', 'about_hero_subtitle', 'Создаваме магични искуства за деца преку интерактивен театар, креативни работилници и незаборавни забави.'],
        ['mk', 'about_story_title', 'Нашата приказна'],
        ['mk', 'about_story_desc', 'Основан со страст за развојот и креативноста на децата, Театар за тебе започна како мала иницијатива за донесување на интерактивен театар во локалните заедници. Нашата авантура започна кога ја сфативме трансформативната моќ на драмата и раскажувањето приказни во животите на децата.'],
        ['mk', 'about_story_desc2', 'Денес, продолжуваме да растеме и еволуираме, допирајќи стотици деца и семејства низ регионот. Нашата посветеност останува иста: да создаваме безбедни, ангажирачки и едукативни искуства кои ја палјат имагинацијата и градат самодоверба кај секое дете со кое работиме.'],
        ['mk', 'about_story_image_alt', 'Тимот на Театар за тебе работи со деца'],
        ['mk', 'value_creativity_title', 'Креативност'],
        ['mk', 'value_creativity_desc', 'Веруваме во моќта на креативното изразување за отклучување на потенцијалот на децата и инспирирање на нивната имагинација преку драма, уметност и раскажување приказни.'],
        ['mk', 'value_community_title', 'Заедница'],
        ['mk', 'value_community_desc', 'Градење силни врски помеѓу деца, семејства и нашиот тим за создавање на поддржувачка средина каде сите можат да процветаат и растат заедно.'],
        ['mk', 'value_excellence_title', 'Извонредност'],
        ['mk', 'value_excellence_desc', 'Посветени на доставување на највисок квалитет искуства со професионални изведувачи, безбедни средини и внимателно изработени програми кои ги надминуваат очекувањата.'],
        ['mk', 'about_team_title', 'Запознајте го нашиот тим'],
        ['mk', 'about_team_intro', 'Нашиот страстен тим од едукатори, изведувачи и креативни професионалци е посветен на правење на секое детско искуство магично и незаборавно.'],
        ['mk', 'about_team_placeholder', 'Информациите за нашиот тим се ажурираат. Ве молиме проверете повторно наскоро!'],
        ['mk', 'about_join_us', 'Приклучете се на нашиот тим'],
        ['mk', 'about_cta_title', 'Подготвени да создадете магија?'],
        ['mk', 'about_cta_desc', 'Дали планирате роденденска забава, барате креативни работилници или сакате да соработувате со нас, би сакале да чуеме од вас.'],
        
        // French translations
        ['fr', 'about_hero_title', 'À propos du Théâtre pour toi'],
        ['fr', 'about_hero_subtitle', 'Créer des expériences magiques pour les enfants grâce au théâtre interactif, aux ateliers créatifs et aux fêtes inoubliables.'],
        ['fr', 'about_story_title', 'Notre histoire'],
        ['fr', 'about_story_desc', 'Fondé avec une passion pour le développement et la créativité des enfants, le Théâtre pour toi a commencé comme une petite initiative pour apporter le théâtre interactif aux communautés locales. Notre voyage a commencé lorsque nous avons réalisé le pouvoir transformateur du drame et de la narration dans la vie des enfants.'],
        ['fr', 'about_story_desc2', 'Aujourd\'hui, nous continuons à grandir et à évoluer, touchant des centaines d\'enfants et de familles dans toute la région. Notre engagement reste le même: créer des expériences sûres, engageantes et éducatives qui éveillent l\'imagination et renforcent la confiance de chaque enfant avec lequel nous travaillons.'],
        ['fr', 'about_story_image_alt', 'L\'équipe du Théâtre pour toi travaille avec les enfants'],
        ['fr', 'value_creativity_title', 'Créativité'],
        ['fr', 'value_creativity_desc', 'Nous croyons au pouvoir de l\'expression créative pour libérer le potentiel des enfants et inspirer leur imagination à travers le théâtre, l\'art et la narration.'],
        ['fr', 'value_community_title', 'Communauté'],
        ['fr', 'value_community_desc', 'Construire des liens solides entre les enfants, les familles et notre équipe pour créer un environnement de soutien où chacun peut s\'épanouir et grandir ensemble.'],
        ['fr', 'value_excellence_title', 'Excellence'],
        ['fr', 'value_excellence_desc', 'Engagés à offrir des expériences de la plus haute qualité avec des artistes professionnels, des environnements sûrs et des programmes soigneusement conçus qui dépassent les attentes.'],
        ['fr', 'about_team_title', 'Rencontrez notre équipe'],
        ['fr', 'about_team_intro', 'Notre équipe passionnée d\'éducateurs, d\'artistes et de professionnels créatifs se consacre à rendre l\'expérience de chaque enfant magique et mémorable.'],
        ['fr', 'about_team_placeholder', 'Les informations sur notre équipe sont en cours de mise à jour. Veuillez revenir bientôt!'],
        ['fr', 'about_join_us', 'Rejoignez notre équipe'],
        ['fr', 'about_cta_title', 'Prêt à créer de la magie?'],
        ['fr', 'about_cta_desc', 'Que vous planifiiez une fête d\'anniversaire, que vous cherchiez des ateliers créatifs ou que vous souhaitiez collaborer avec nous, nous aimerions avoir de vos nouvelles.']
    ];
    
    // Use REPLACE to update existing entries with proper encoding
    $stmt = $pdo->prepare("REPLACE INTO translations (language_code, translation_key, translation_value) VALUES (?, ?, ?)");
    foreach ($aboutTranslations as $translation) {
        $stmt->execute($translation);
    }
    echo "✓ Inserted/Updated " . count($aboutTranslations) . " about page translations with proper UTF-8 encoding\n";
    
    echo "<h2>✅ About Page Translations Complete!</h2>\n";
    echo "<p><strong>Summary:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>About Page Translations: " . count($aboutTranslations) . "</li>\n";
    echo "<li>Languages: English, Macedonian, French</li>\n";
    echo "<li>Translation Keys: " . count(array_unique(array_column($aboutTranslations, 1))) . "</li>\n";
    echo "</ul>\n";
    
    echo "<p><strong>About page is now ready with comprehensive translations!</strong></p>\n";
    echo "<p><a href='/about'>Visit the About page</a> to see the new content.</p>\n";
    
} catch (Exception $e) {
    echo "<h2>❌ Error during about translations population:</h2>\n";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>\n";
}
?>
