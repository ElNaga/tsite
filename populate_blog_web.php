<?php
/**
 * Web-based Blog Data Population
 * 
 * This file populates the blog with sample data.
 * Access via: http://localhost:8080/populate_blog_web.php
 */

echo "<h1>📝 Blog Data Population</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; }
    .error { color: red; }
    .info { color: blue; }
    .post { margin: 15px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
</style>";

try {
    require_once __DIR__ . '/src/services/BlogService.php';
    
    // Sample blog posts data
    $samplePosts = [
        [
            'language' => 'en',
            'main_title' => 'Welcome to Our New Blog!',
            'main_text' => 'We are excited to launch our new blog where we will share stories, updates, and insights about our theater productions and events. This is a place where we can connect with our community and share the magic of theater with everyone.',
            'main_image' => '/assets/background-image.png',
            'secondary_title' => 'What to Expect',
            'secondary_text' => 'In the coming weeks, you can expect to see behind-the-scenes content, actor interviews, production updates, and much more. We will be posting regularly to keep you informed about all the exciting things happening at Teatar za tebe.',
            'secondary_image' => '/assets/topright_strip.png',
            'gallery_images' => ['/assets/background-image.png', '/assets/topright_strip.png'],
            'visible' => true
        ],
        [
            'language' => 'mk',
            'main_title' => 'Добредојдовте во нашиот нов блог!',
            'main_text' => 'Возбудени сме што го лансираме нашиот нов блог каде ќе споделуваме приказни, ажурирања и увид за нашите театарски продукции и настани. Ова е место каде можеме да се поврземе со нашата заедница и да ја споделиме магијата на театарот со сите.',
            'main_image' => '/assets/background-image.png',
            'secondary_title' => 'Што да очекувате',
            'secondary_text' => 'Во наредните недели, можете да очекувате да видите содржина зад сцената, интервјуа со глумци, ажурирања за продукциите и многу повеќе. Ќе објавуваме редовно за да ве информираме за сите возбудливи работи што се случуваат во Театар за тебе.',
            'secondary_image' => '/assets/topright_strip.png',
            'gallery_images' => ['/assets/background-image.png', '/assets/topright_strip.png'],
            'visible' => true
        ],
        [
            'language' => 'fr',
            'main_title' => 'Bienvenue sur notre nouveau blog !',
            'main_text' => 'Nous sommes ravis de lancer notre nouveau blog où nous partagerons des histoires, des mises à jour et des aperçus de nos productions théâtrales et événements. C\'est un endroit où nous pouvons nous connecter avec notre communauté et partager la magie du théâtre avec tout le monde.',
            'main_image' => '/assets/background-image.png',
            'secondary_title' => 'À quoi s\'attendre',
            'secondary_text' => 'Dans les semaines à venir, vous pouvez vous attendre à voir du contenu en coulisses, des interviews d\'acteurs, des mises à jour de production et bien plus encore. Nous publierons régulièrement pour vous tenir informés de toutes les choses passionnantes qui se passent au Théâtre pour toi.',
            'secondary_image' => '/assets/topright_strip.png',
            'gallery_images' => ['/assets/background-image.png', '/assets/topright_strip.png'],
            'visible' => true
        ],
        [
            'language' => 'en',
            'main_title' => 'Behind the Scenes: Our Latest Production',
            'main_text' => 'Take a look behind the curtain as we prepare for our upcoming children\'s theater production. From costume design to set construction, there\'s so much that goes into creating the magic that our young audiences experience.',
            'main_image' => '/assets/background-image.png',
            'secondary_title' => 'The Creative Process',
            'secondary_text' => 'Our team of talented artists and craftspeople work tirelessly to bring stories to life. Every detail, from the smallest prop to the grandest set piece, is carefully considered to create an immersive experience for our audience.',
            'secondary_image' => '/assets/topright_strip.png',
            'gallery_images' => ['/assets/background-image.png'],
            'visible' => true
        ],
        [
            'language' => 'en',
            'main_title' => 'Interactive Theater: Engaging Young Minds',
            'main_text' => 'Interactive theater is more than just entertainment - it\'s a powerful educational tool that helps children develop creativity, empathy, and critical thinking skills. In this post, we explore how our interactive productions make learning fun and engaging.',
            'main_image' => '/assets/background-image.png',
            'secondary_title' => 'The Benefits of Interactive Theater',
            'secondary_text' => 'Research shows that children who participate in interactive theater experiences show improved social skills, increased confidence, and better problem-solving abilities. Our productions are designed to be both entertaining and educational.',
            'secondary_image' => '/assets/topright_strip.png',
            'gallery_images' => ['/assets/background-image.png', '/assets/topright_strip.png'],
            'visible' => true
        ]
    ];
    
    echo "<p class='info'>Starting blog population...</p>";
    
    $inserted = 0;
    $errors = 0;
    
    foreach ($samplePosts as $index => $postData) {
        echo "<div class='post'>";
        echo "<h3>Creating post " . ($index + 1) . ": " . htmlspecialchars($postData['main_title']) . "</h3>";
        
        try {
            $id = BlogService::createBlogPost($postData);
            if ($id) {
                $inserted++;
                echo "<p class='success'>✅ Created successfully (ID: $id)</p>";
            } else {
                $errors++;
                echo "<p class='error'>❌ Failed to create</p>";
            }
        } catch (Exception $e) {
            $errors++;
            echo "<p class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        
        echo "</div>";
    }
    
    echo "<h2>📊 Population Summary</h2>";
    echo "<p class='success'>✅ Successfully created: $inserted blog posts</p>";
    if ($errors > 0) {
        echo "<p class='error'>❌ Errors: $errors</p>";
    }
    
    // Show current blog posts count
    try {
        $totalEn = BlogService::getTotalBlogPosts('en');
        $totalMk = BlogService::getTotalBlogPosts('mk');
        $totalFr = BlogService::getTotalBlogPosts('fr');
        
        echo "<h3>📈 Current Blog Posts by Language:</h3>";
        echo "<ul>";
        echo "<li>English: $totalEn posts</li>";
        echo "<li>Македонски: $totalMk posts</li>";
        echo "<li>Français: $totalFr posts</li>";
        echo "</ul>";
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ Error getting totals: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    
    echo "<h2>🔗 Next Steps</h2>";
    echo "<ul>";
    echo "<li><a href='/blog' target='_blank'>View the public blog page</a></li>";
    echo "<li><a href='/admin/blog' target='_blank'>Manage blog posts in admin panel</a></li>";
    echo "<li><a href='/test_blog_web.php' target='_blank'>Run blog functionality test</a></li>";
    echo "</ul>";
    
    echo "<h2 class='success'>🎉 Blog Population Complete!</h2>";
    
} catch (Exception $e) {
    echo "<h2 class='error'>❌ Population Failed</h2>";
    echo "<p class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='error'>Stack trace:</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
?>
