<?php
// TranslationService is already loaded in index.php
?>
<section class="page-section">
    <div class="container">
        <h1><?= htmlspecialchars(TranslationService::t('about')) ?></h1>
        <div class="about-content">
            <p><?= htmlspecialchars(TranslationService::t('about_mission_desc')) ?></p>
            <p><?= htmlspecialchars(TranslationService::t('about_values_desc')) ?></p>
        </div>
    </div>
</section> 