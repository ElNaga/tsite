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