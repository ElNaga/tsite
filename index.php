<?php
require_once __DIR__ . '/i18n.php';

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

debug_to_console("Test message");   

?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars(I18nService::getCurrentLang()) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(I18nService::t('site_title')) ?></title>
    <meta name="description" content="<?= htmlspecialchars(I18nService::t('site_description')) ?>">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars(I18nService::t('site_title')) ?>">
    <meta property="og:description" content="<?= htmlspecialchars(I18nService::t('site_description')) ?>">
    <meta property="og:image" content="/assets/background-image.png">
    <meta property="og:url" content="https://www.teatarzatebe.mk/">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars(I18nService::t('site_title')) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars(I18nService::t('site_description')) ?>">
    <meta name="twitter:image" content="/assets/background-image.png">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='0.9em' font-size='90'%3E%F0%9F%8E%AD%3C/text%3E%3C/svg%3E">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="components/navbar/navbar.css">
    <link rel="stylesheet" href="components/hero/hero.css">
    <link rel="stylesheet" href="components/hero/aboutus.css">
    <link rel="stylesheet" href="components/hero/footer.css">
    <!-- Google Fonts: Caveat and Poiret One, both with latin and cyrillic support -->
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Poiret+One&display=swap&subset=latin,cyrillic" rel="stylesheet">
</head> 
<body>
    <?php include __DIR__ . '/components/navbar/navbar.php'; ?>
    <?php
    // Pretty URL routing: get path from REQUEST_URI
    $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $page = $path ?: 'home';
    debug_to_console($page, "Parsed page from path");
    $allowed = ['about', 'offer', 'offer1', 'offer2', 'blog', 'contact', 'home'];
    // Admin route protection
    if ($page === 'admin') {
        session_start();
        if (empty($_SESSION['is_admin'])) {
            header('Location: /home');
            exit;
        }
        include __DIR__ . '/components/admin/admin.php';
    } elseif ($page === 'home') {
        include __DIR__ . '/components/hero/hero.php';
    } elseif (in_array($page, $allowed)) {
        include __DIR__ . "/components/navbar/" . ucfirst($page) . ".php";
    } else {
        include __DIR__ . '/components/hero/404.php';
    }
    ?>
    <?php include __DIR__ . '/components/hero/footer.php'; ?>
</body>
</html> 