<?php
// Test admin page loading
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Admin Debug Test</h1>";

try {
    echo "<p>1. Testing admin controller...</p>";
    require_once __DIR__ . '/components/admin/admin-controller.php';
    echo "<p>✅ Admin controller loaded</p>";
    
    echo "<p>2. Testing admin data...</p>";
    $data = AdminController::getData();
    echo "<p>✅ Admin data loaded</p>";
    echo "<p>Blog posts count: " . count($data['blogPosts']) . "</p>";
    
    echo "<p>3. Testing admin template...</p>";
    ob_start();
    include __DIR__ . '/components/admin/admin-template.php';
    $template = ob_get_clean();
    echo "<p>✅ Admin template loaded</p>";
    echo "<p>Template length: " . strlen($template) . " characters</p>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='error'>Stack trace:</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
} catch (Error $e) {
    echo "<p class='error'>❌ Fatal Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p class='error'>Stack trace:</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
?>
