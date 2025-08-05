<?php
require_once __DIR__ . '/../../i18n.php';
?>
<section class="page-section">
    <div class="container">
        <h1><?= htmlspecialchars(I18nService::t('about')) ?></h1>
        <div class="about-content">
            <p><?= htmlspecialchars(I18nService::t('about_mission_desc')) ?></p>
            <p><?= htmlspecialchars(I18nService::t('about_values_desc')) ?></p>
        </div>
    </div>
</section> 