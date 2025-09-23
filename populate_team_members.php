<?php
/**
 * Populate Team Members
 * Adds sample team members to the people table
 */

require_once __DIR__ . '/bootstrap.php';

try {
    $pdo = require __DIR__ . '/bootstrap.php';
    
    echo "<h1>Populating Team Members</h1>\n";
    echo "<p>Adding sample team members...</p>\n";
    
    // Insert Team Members
    echo "<h2>Inserting Team Members...</h2>\n";
    $teamMembers = [
        // English team members
        ['Maja Petrovska', 'Creative Director & Founder', 'Founder of Teatar za tebe with 15+ years experience in theatre, education, and performance. Passionate about creating magical experiences for children.', null, 'en', 1, true],
        ['Aleksandar Stojanov', 'Lead Performer & Workshop Leader', 'Professional actor and drama educator specializing in interactive theatre for children. Brings stories to life with energy and creativity.', null, 'en', 2, true],
        ['Elena Dimitrova', 'Music & Movement Specialist', 'Trained musician and movement educator who combines music, dance, and drama to create engaging learning experiences for children.', null, 'en', 3, true],
        ['Nikola Georgiev', 'Technical Director', 'Handles all technical aspects of our performances and workshops, ensuring smooth operations and high-quality experiences.', null, 'en', 4, true],
        
        // Macedonian team members
        ['Маја Петровска', 'Креативен директор и основач', 'Основач на Театар за тебе со 15+ години искуство во театар, образование и настапување. Страстна за создавање магични искуства за деца.', null, 'mk', 1, true],
        ['Александар Стојанов', 'Главен изведувач и водач на работилници', 'Професионален глумец и драмски едукатор специјализиран за интерактивен театар за деца. Ги оживува приказните со енергија и креативност.', null, 'mk', 2, true],
        ['Елена Димитрова', 'Специјалист за музика и движење', 'Образована музичарка и едукатор за движење која комбинира музика, танц и драма за создавање ангажирачки искуства за учење за деца.', null, 'mk', 3, true],
        ['Никола Георгиев', 'Технички директор', 'Се грижи за сите технички аспекти на нашите претстави и работилници, обезбедувајќи мазни операции и искуства од висок квалитет.', null, 'mk', 4, true],
        
        // French team members
        ['Maja Petrovska', 'Directrice créative et fondatrice', 'Fondatrice du Théâtre pour toi avec plus de 15 ans d\'expérience en théâtre, éducation et performance. Passionnée par la création d\'expériences magiques pour les enfants.', null, 'fr', 1, true],
        ['Aleksandar Stojanov', 'Artiste principal et animateur d\'ateliers', 'Acteur professionnel et éducateur dramatique spécialisé dans le théâtre interactif pour enfants. Donne vie aux histoires avec énergie et créativité.', null, 'fr', 2, true],
        ['Elena Dimitrova', 'Spécialiste en musique et mouvement', 'Musicienne formée et éducatrice en mouvement qui combine musique, danse et théâtre pour créer des expériences d\'apprentissage engageantes pour les enfants.', null, 'fr', 3, true],
        ['Nikola Georgiev', 'Directeur technique', 'Gère tous les aspects techniques de nos spectacles et ateliers, assurant des opérations fluides et des expériences de haute qualité.', null, 'fr', 4, true]
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO people (name, title, description, image_url, language_code, display_order, is_visible) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($teamMembers as $member) {
        $stmt->execute($member);
        echo "✓ Inserted team member: {$member[0]} ({$member[4]})\n";
    }
    
    echo "<h2>✅ Team Members Population Complete!</h2>\n";
    echo "<p><strong>Summary:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Team Members: " . count($teamMembers) . "</li>\n";
    echo "<li>Languages: English, Macedonian, French</li>\n";
    echo "<li>Members per language: 4</li>\n";
    echo "</ul>\n";
    
    echo "<p><strong>Team section is now populated!</strong></p>\n";
    echo "<p><a href='/about'>Visit the About page</a> to see the team members.</p>\n";
    
} catch (Exception $e) {
    echo "<h2>❌ Error during team members population:</h2>\n";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>\n";
}
?>
