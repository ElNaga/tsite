<?php
/**
 * Update Missing Translations
 * Add missing translation keys to the database
 */

require_once __DIR__ . '/src/services/TranslationService.php';

echo "<h1>🔤 Updating Missing Translations</h1>";

try {
    $pdo = require_once __DIR__ . '/bootstrap.php';
    
    // Define all the missing translations
    $missingTranslations = [
        'en' => [
            'footer_page_desc' => 'Professional children\'s theater and entertainment services. We create magical experiences for children through interactive performances, drama workshops, and birthday party entertainment.',
            'footer_channel' => 'Our Channel',
            'footer_channel_members' => 'Channel · 9 members',
            'footer_rights' => 'All rights reserved.',
            'footer_brand_title' => 'Teatar za tebe',
            'site_description' => 'Unforgettable children\'s parties, interactive performances, drama studio, and creative workshops. Book your next event with Teatar za tebe!',
            'about_mission_desc' => 'Our mission is to create magical theatrical experiences that inspire creativity, build confidence, and bring joy to children of all ages. We believe in the power of interactive storytelling and performance to develop young minds.',
            'about_values_desc' => 'We value creativity, inclusivity, and the joy of learning through play. Every child deserves to experience the magic of theater in a safe, supportive environment.',
            'not_found_title' => 'Page Not Found',
            'not_found_message' => 'The page you are looking for doesn\'t exist. Please check the URL or return to the home page.',
            'offer1' => 'Theater Performances',
            'offer2' => 'Drama Workshops',
            'service1_title' => 'Interactive Theater Performances',
            'service1_desc' => 'Engaging theatrical shows designed specifically for children, featuring interactive elements and audience participation.',
            'service2_title' => 'Creative Drama Workshops',
            'service2_desc' => 'Educational workshops where children learn acting skills, storytelling, and build confidence through creative expression.',
            'service3_title' => 'Storytelling Sessions',
            'service3_desc' => 'Magical storytelling experiences that bring classic tales to life with props, music, and interactive elements.',
            'service4_title' => 'Character Development',
            'service4_desc' => 'Specialized programs helping children develop characters, understand emotions, and express themselves through acting.',
            'service5_title' => 'Movement & Dance',
            'service5_desc' => 'Energetic sessions combining theater with movement, dance, and physical expression for active children.',
            'about_mission_title' => 'Our Mission',
            'about_values_title' => 'Our Values',
            'about_approach_title' => 'Our Approach',
            'about_approach_list' => 'Interactive Learning|Creative Expression|Safe Environment|Professional Guidance|Fun & Engagement',
            'party_animation_title' => 'Birthday Party Animation',
            'party_animation_body' => 'Make your child\'s birthday unforgettable with our professional party animation services. We bring the magic of theater to your home or venue with interactive performances, games, and activities that will keep children entertained and engaged throughout the celebration.',
            'party_ideas_title' => 'Creative Party Ideas',
            'party_ideas_body' => 'From themed performances to interactive workshops, we offer a variety of creative party ideas that can be customized to your child\'s interests and age. Our experienced performers create magical moments that make every birthday special and memorable.'
        ],
        'mk' => [
            'footer_page_desc' => 'Професионални детски театарски и забавни услуги. Создаваме магични искуства за деца преку интерактивни претстави, драмски работилници и забава за родендени.',
            'footer_channel' => 'Нашиот канал',
            'footer_channel_members' => 'Канал · 9 члена',
            'footer_rights' => 'Сите права задржани.',
            'footer_brand_title' => 'Театар за тебе',
            'site_description' => 'Незаборавни детски забави, интерактивни претстави, драмско студио и креативни работилници. Резервирајте го вашиот следен настан со Театар за тебе!',
            'about_mission_desc' => 'Нашата мисија е да создаваме магични театарски искуства кои инспирираат креативност, градат самодоверба и носат радост на деца од сите возрасти. Веруваме во моќта на интерактивното раскажување приказни и претставување за развој на млади умови.',
            'about_values_desc' => 'Ги цениме креативноста, инклузивноста и радоста од учење преку игра. Секое дете заслужува да го искуси волшебството на театарот во безбедна, поддржувачка средина.',
            'not_found_title' => 'Страницата не е пронајдена',
            'not_found_message' => 'Страницата која ја барате не постои. Проверете ја URL адресата или вратете се на почетната страница.',
            'offer1' => 'Театарски претстави',
            'offer2' => 'Драмски работилници',
            'service1_title' => 'Интерактивни театарски претстави',
            'service1_desc' => 'Привлечни театарски претстави дизајнирани специјално за деца, со интерактивни елементи и учество на публиката.',
            'service2_title' => 'Креативни драмски работилници',
            'service2_desc' => 'Образовни работилници каде децата учат актерски вештини, раскажување приказни и градат самодоверба преку креативна експресија.',
            'service3_title' => 'Сесии за раскажување приказни',
            'service3_desc' => 'Магични искуства за раскажување приказни кои ги оживуваат класичните приказни со реквизити, музика и интерактивни елементи.',
            'service4_title' => 'Развој на карактер',
            'service4_desc' => 'Специјализирани програми кои им помагаат на децата да развијат карактери, разберат емоции и се изразат преку актерство.',
            'service5_title' => 'Движење и танц',
            'service5_desc' => 'Енергични сесии кои ги комбинираат театарот со движење, танц и физичка експресија за активни деца.',
            'about_mission_title' => 'Нашата мисија',
            'about_values_title' => 'Нашите вредности',
            'about_approach_title' => 'Нашиот пристап',
            'about_approach_list' => 'Интерактивно учење|Креативна експресија|Безбедна средина|Професионално водство|Забава и ангажман',
            'party_animation_title' => 'Анимација за родендени',
            'party_animation_body' => 'Направете го роденденот на вашето дете незаборавен со нашите професионални услуги за анимација на забави. Носиме волшебство на театарот во вашиот дом или простор со интерактивни претстави, игри и активности кои ќе ги забавуваат и ангажираат децата во текот на прославата.',
            'party_ideas_title' => 'Креативни идеи за забави',
            'party_ideas_body' => 'Од тематски претстави до интерактивни работилници, нудиме разновидни креативни идеи за забави кои можат да се прилагодат на интересите и возраста на вашето дете. Нашите искусни изведувачи создаваат магични моменти кои го прават секој роденден посебен и незаборавен.'
        ],
        'fr' => [
            'footer_page_desc' => 'Services professionnels de théâtre et de divertissement pour enfants. Nous créons des expériences magiques pour les enfants à travers des représentations interactives, des ateliers de théâtre et du divertissement pour anniversaires.',
            'footer_channel' => 'Notre chaîne',
            'footer_channel_members' => 'Chaîne · 9 membres',
            'footer_rights' => 'Tous droits réservés.',
            'footer_brand_title' => 'Théâtre pour toi',
            'site_description' => 'Fêtes d\'enfants inoubliables, représentations interactives, studio de théâtre et ateliers créatifs. Réservez votre prochain événement avec Teatar za tebe !',
            'about_mission_desc' => 'Notre mission est de créer des expériences théâtrales magiques qui inspirent la créativité, développent la confiance et apportent de la joie aux enfants de tous âges. Nous croyons au pouvoir de la narration interactive et de la performance pour développer les jeunes esprits.',
            'about_values_desc' => 'Nous valorisons la créativité, l\'inclusivité et la joie d\'apprendre par le jeu. Chaque enfant mérite de vivre la magie du théâtre dans un environnement sûr et encourageant.',
            'not_found_title' => 'Page non trouvée',
            'not_found_message' => 'La page que vous recherchez n\'existe pas. Veuillez vérifier l\'URL ou retourner à la page d\'accueil.',
            'offer1' => 'Représentations théâtrales',
            'offer2' => 'Ateliers de théâtre',
            'service1_title' => 'Représentations théâtrales interactives',
            'service1_desc' => 'Spectacles théâtraux engageants conçus spécialement pour les enfants, avec des éléments interactifs et la participation du public.',
            'service2_title' => 'Ateliers de théâtre créatifs',
            'service2_desc' => 'Ateliers éducatifs où les enfants apprennent les compétences d\'acteur, la narration d\'histoires et développent la confiance par l\'expression créative.',
            'service3_title' => 'Sessions de narration d\'histoires',
            'service3_desc' => 'Expériences magiques de narration qui donnent vie aux contes classiques avec des accessoires, de la musique et des éléments interactifs.',
            'service4_title' => 'Développement de personnages',
            'service4_desc' => 'Programmes spécialisés aidant les enfants à développer des personnages, comprendre les émotions et s\'exprimer à travers l\'acting.',
            'service5_title' => 'Mouvement et danse',
            'service5_desc' => 'Sessions énergiques combinant le théâtre avec le mouvement, la danse et l\'expression physique pour les enfants actifs.',
            'about_mission_title' => 'Notre mission',
            'about_values_title' => 'Nos valeurs',
            'about_approach_title' => 'Notre approche',
            'about_approach_list' => 'Apprentissage interactif|Expression créative|Environnement sûr|Guidance professionnelle|Amusement et engagement',
            'party_animation_title' => 'Animation d\'anniversaire',
            'party_animation_body' => 'Rendez l\'anniversaire de votre enfant inoubliable avec nos services professionnels d\'animation de fête. Nous apportons la magie du théâtre à votre maison ou lieu avec des représentations interactives, des jeux et des activités qui divertiront et engageront les enfants tout au long de la célébration.',
            'party_ideas_title' => 'Idées créatives de fête',
            'party_ideas_body' => 'Des représentations thématiques aux ateliers interactifs, nous offrons une variété d\'idées créatives de fête qui peuvent être personnalisées selon les intérêts et l\'âge de votre enfant. Nos artistes expérimentés créent des moments magiques qui rendent chaque anniversaire spécial et mémorable.'
        ]
    ];
    
    echo "<h2>📝 Adding missing translations...</h2>";
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO translations (language_code, translation_key, translation_value) VALUES (?, ?, ?)");
    
    $addedCount = 0;
    foreach ($missingTranslations as $lang => $translations) {
        foreach ($translations as $key => $value) {
            $stmt->execute([$lang, $key, $value]);
            if ($stmt->rowCount() > 0) {
                $addedCount++;
                echo "<p>✅ Added: $lang - $key</p>";
            }
        }
    }
    
    echo "<h2>🎉 Translation Update Complete!</h2>";
    echo "<p>✅ Added $addedCount new translation keys</p>";
    
    // Test the new translations
    echo "<h2>🧪 Testing New Translations</h2>";
    
    foreach (['en', 'mk', 'fr'] as $lang) {
        TranslationService::setLang($lang);
        echo "<h3>Language: $lang</h3>";
        echo "<ul>";
        echo "<li><strong>Footer Description:</strong> " . htmlspecialchars(TranslationService::t('footer_page_desc')) . "</li>";
        echo "<li><strong>Channel:</strong> " . htmlspecialchars(TranslationService::t('footer_channel')) . "</li>";
        echo "<li><strong>Channel Members:</strong> " . htmlspecialchars(TranslationService::t('footer_channel_members')) . "</li>";
        echo "<li><strong>Rights:</strong> " . htmlspecialchars(TranslationService::t('footer_rights')) . "</li>";
        echo "<li><strong>Site Description:</strong> " . htmlspecialchars(TranslationService::t('site_description')) . "</li>";
        echo "</ul>";
    }
    
    echo "<h2>🔗 Test Your Site</h2>";
    echo "<p><a href='http://localhost:8080' target='_blank'>Visit Main Site</a></p>";
    echo "<p><a href='http://localhost:8080/?lang=mk' target='_blank'>Visit Macedonian Version</a></p>";
    echo "<p><a href='http://localhost:8080/?lang=fr' target='_blank'>Visit French Version</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
