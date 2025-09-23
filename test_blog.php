<?php
require_once __DIR__ . '/src/services/BlogService.php';
require_once __DIR__ . '/src/services/TranslationService.php';

echo "Testing Blog Functionality\n";
echo "========================\n\n";

try {
    // Test 1: Create a blog post
    echo "1. Testing blog post creation...\n";
    $testPost = [
        'language' => 'en',
        'main_title' => 'Test Blog Post',
        'main_text' => 'This is a test blog post to verify the blog functionality is working correctly.',
        'main_image' => '/assets/background-image.png',
        'secondary_title' => 'Test Secondary Title',
        'secondary_text' => 'This is the secondary text content for testing purposes.',
        'secondary_image' => '/assets/topright_strip.png',
        'gallery_images' => ['/assets/background-image.png'],
        'visible' => true
    ];
    
    $postId = BlogService::createBlogPost($testPost);
    echo "   ✓ Created blog post with ID: $postId\n";
    
    // Test 2: Retrieve blog post
    echo "\n2. Testing blog post retrieval...\n";
    $retrievedPost = BlogService::getBlogPostById($postId);
    if ($retrievedPost) {
        echo "   ✓ Retrieved blog post: {$retrievedPost->getMainTitle()}\n";
    } else {
        echo "   ✗ Failed to retrieve blog post\n";
    }
    
    // Test 3: Get blog posts with pagination
    echo "\n3. Testing blog posts listing...\n";
    $posts = BlogService::getBlogPosts('en', 1, 10);
    echo "   ✓ Retrieved " . count($posts) . " blog posts\n";
    
    // Test 4: Get pagination info
    echo "\n4. Testing pagination...\n";
    $paginationInfo = BlogService::getPaginationInfo('en', 1, 10);
    echo "   ✓ Total posts: {$paginationInfo['total_posts']}\n";
    echo "   ✓ Total pages: {$paginationInfo['total_pages']}\n";
    
    // Test 5: Update blog post
    echo "\n5. Testing blog post update...\n";
    $updateData = [
        'language' => 'en',
        'main_title' => 'Updated Test Blog Post',
        'main_text' => 'This blog post has been updated to test the update functionality.',
        'main_image' => '/assets/background-image.png',
        'secondary_title' => 'Updated Secondary Title',
        'secondary_text' => 'This secondary text has been updated.',
        'secondary_image' => '/assets/topright_strip.png',
        'gallery_images' => ['/assets/background-image.png'],
        'visible' => true
    ];
    
    $updateSuccess = BlogService::updateBlogPost($postId, $updateData);
    if ($updateSuccess) {
        echo "   ✓ Successfully updated blog post\n";
    } else {
        echo "   ✗ Failed to update blog post\n";
    }
    
    // Test 6: Toggle visibility
    echo "\n6. Testing visibility toggle...\n";
    $toggleSuccess = BlogService::toggleVisibility($postId);
    if ($toggleSuccess) {
        echo "   ✓ Successfully toggled visibility\n";
    } else {
        echo "   ✗ Failed to toggle visibility\n";
    }
    
    // Test 7: Delete blog post
    echo "\n7. Testing blog post deletion...\n";
    $deleteSuccess = BlogService::deleteBlogPost($postId);
    if ($deleteSuccess) {
        echo "   ✓ Successfully deleted blog post\n";
    } else {
        echo "   ✗ Failed to delete blog post\n";
    }
    
    echo "\n========================\n";
    echo "All blog functionality tests completed!\n";
    
} catch (Exception $e) {
    echo "Error during testing: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>
