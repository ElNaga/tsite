<?php
require_once __DIR__ . '/../../i18n.php';
?>
<section class="page-section">
    <div class="container">
        <h1><?= htmlspecialchars(I18nService::t('blog')) ?></h1>
        <div class="blog-content">
            <p>Our latest news and updates will appear here.</p>
            <div class="blog-posts">
                <article class="blog-post">
                    <h3>Coming Soon</h3>
                    <p>We're working on bringing you the latest updates and news about our theater events.</p>
                </article>
            </div>
        </div>
    </div>
</section> 