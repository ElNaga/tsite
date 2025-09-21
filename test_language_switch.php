<?php
/**
 * Language Switch Test
 * This tests the language switching functionality
 */

// Load services
require_once __DIR__ . '/src/services/TranslationService.php';

// Handle language change
if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'mk', 'fr'])) {
    TranslationService::setLang($_GET['lang']);
}

// Load translations
TranslationService::loadTranslations();

?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars(TranslationService::getCurrentLang()) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Language Switch Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ccc; }
        .language-links { margin: 20px 0; }
        .language-links a { margin: 0 10px; padding: 10px; background: #007cba; color: white; text-decoration: none; border-radius: 5px; }
        .language-links a:hover { background: #005a87; }
        .current-lang { background: #d7263d !important; }
    </style>
</head>
<body>
    <h1>🌐 Language Switch Test</h1>
    
    <div class="test-section">
        <h2>Current Language: <?= htmlspecialchars(TranslationService::getCurrentLang()) ?></h2>
        
        <div class="language-links">
            <a href="?lang=en" <?= TranslationService::getCurrentLang() === 'en' ? 'class="current-lang"' : '' ?>>English</a>
            <a href="?lang=mk" <?= TranslationService::getCurrentLang() === 'mk' ? 'class="current-lang"' : '' ?>>Македонски</a>
            <a href="?lang=fr" <?= TranslationService::getCurrentLang() === 'fr' ? 'class="current-lang"' : '' ?>>Français</a>
        </div>
    </div>
    
    <div class="test-section">
        <h2>Translation Test</h2>
        <ul>
            <li><strong>Site Title:</strong> <?= htmlspecialchars(TranslationService::t('site_title')) ?></li>
            <li><strong>Home:</strong> <?= htmlspecialchars(TranslationService::t('home')) ?></li>
            <li><strong>About:</strong> <?= htmlspecialchars(TranslationService::t('about')) ?></li>
            <li><strong>Contact:</strong> <?= htmlspecialchars(TranslationService::t('contact')) ?></li>
            <li><strong>Blog:</strong> <?= htmlspecialchars(TranslationService::t('blog')) ?></li>
            <li><strong>Offer:</strong> <?= htmlspecialchars(TranslationService::t('offer')) ?></li>
        </ul>
    </div>
    
    <div class="test-section">
        <h2>Session Debug</h2>
        <p>Session ID: <?= session_id() ?: 'No session' ?></p>
        <p>Session Language: <?= $_SESSION['lang'] ?? 'Not set' ?></p>
        <p>GET Language: <?= $_GET['lang'] ?? 'Not set' ?></p>
    </div>
    
    <div class="test-section">
        <h2>Test Main Site</h2>
        <p><a href="http://localhost:8080" target="_blank">Visit Main Site</a></p>
        <p><a href="http://localhost:8080?lang=<?= TranslationService::getCurrentLang() ?>" target="_blank">Visit Main Site with Current Language</a></p>
    </div>
</body>
</html>







