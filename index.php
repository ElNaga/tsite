<?php
require_once __DIR__ . '/i18n.php';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars(I18nService::getCurrentLang()) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with i18n</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="components/navbar/navbar.css">
    <link rel="stylesheet" href="components/hero/hero.css">
    <link rel="stylesheet" href="components/hero/aboutus.css">
    <!-- Google Fonts: Montserrat for titles, Roboto for body, both with Cyrillic and Latin support -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap&subset=latin,cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap&subset=latin,cyrillic" rel="stylesheet">
    <!-- Google Fonts: Bad Script for titles -->
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script&display=swap" rel="stylesheet">
    <!-- Google Fonts: Caveat for titles -->
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap" rel="stylesheet">
    <!-- Google Fonts: Caveat for titles, Poiret One for body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script&family=Caveat:wght@400..700&family=Pacifico&family=Poiret+One&display=swap" rel="stylesheet">
</head> 
<body>
    <?php include __DIR__ . '/components/navbar/navbar.php'; ?>
    <?php
    $page = $_GET['page'] ?? 'home';
    $allowed = ['about', 'offer', 'offer1', 'offer2', 'blog', 'contact'];
    if ($page === 'home') {
        include __DIR__ . '/components/hero/hero.php';
    } elseif (in_array($page, $allowed)) {
        include __DIR__ . "/components/navbar/" . ucfirst($page) . ".php";
    } else {
        echo '<div>Page not found</div>';
    }
    ?>
    <?php include __DIR__ . '/components/hero/footer.php'; ?>
</body>
</html> 