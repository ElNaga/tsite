<?php
require_once __DIR__ . '/src/services/BlogService.php';

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
        'language' => 'en',
        'main_title' => 'Behind the Scenes: Our Latest Production',
        'main_text' => 'Take a look behind the curtain as we prepare for our upcoming children\'s theater production. From costume design to set construction, there\'s so much that goes into creating the magic that our young audiences experience.',
        'main_image' => '/assets/background-image.png',
        'secondary_title' => 'The Creative Process',
        'secondary_text' => 'Our team of talented artists and craftspeople work tirelessly to bring stories to life. Every detail, from the smallest prop to the grandest set piece, is carefully considered to create an immersive experience for our audience.',
        'secondary_image' => '/assets/topright_strip.png',
        'gallery_images' => ['/assets/background-image.png'],
        'visible' => true
    ]
];

echo "Populating blog posts...\n";

$inserted = 0;
foreach ($samplePosts as $postData) {
    try {
        $id = BlogService::createBlogPost($postData);
        $inserted++;
        echo "Created blog post: {$postData['main_title']} (ID: $id)\n";
    } catch (Exception $e) {
        echo "Failed to create blog post: {$postData['main_title']} - " . $e->getMessage() . "\n";
    }
}

echo "Blog population completed! Created $inserted posts.\n";
?>