<?php
// Modern, styled footer: three columns (logo, links, socials), copyright at bottom, playful icon shadows, full width
?>
<footer class="site-footer">
    <div class="footer-main-modern footer-cols">
        <div class="footer-col footer-brand-modern">
            <div class="footer-logo-modern icon-shadow">🎭</div>
            <div class="footer-brand-title"><?= htmlspecialchars(TranslationService::t('footer_brand_title')) ?></div>
            <div class="footer-brand-desc-modern">
                <?= htmlspecialchars(TranslationService::t('footer_page_desc')) ?>
            </div>
        </div>
        <div class="footer-col footer-links-col">
            <a href="/home"><?= TranslationService::t('home') ?></a><br>
            <a href="/about"><?= TranslationService::t('about') ?></a><br>
            <a href="/offer"><?= TranslationService::t('offer') ?></a><br>
            <a href="/blog"><?= TranslationService::t('blog') ?></a><br>
            <a href="/contact"><?= TranslationService::t('contact') ?></a>
        </div>
        <div class="footer-col footer-info-modern">
            <div class="footer-info-row"><span class="footer-icon-modern icon-shadow">📞</span> <span class="info-row-text">075 262 903</span></div>
            <div class="footer-info-row"><span class="footer-icon-modern icon-shadow">✉️</span> <span class="info-row-text">izabelafdu@outlook.com</span></div>
            <div class="footer-info-row"><span class="footer-icon-modern icon-shadow">📷</span> <a href="https://www.instagram.com/teatarzatebe" target="_blank" rel="noopener">Instagram</a></div>
            <div class="footer-info-row"><span class="footer-icon-modern icon-shadow">💬</span> <a href="#"><?= TranslationService::t('footer_channel') ?></a> <span class="info-row-text"><?= TranslationService::t('footer_channel_members') ?></span></div>
        </div>
    </div>
    <div class="footer-bottom-modern">
        <span>&copy; <?= date('Y') ?> <?= htmlspecialchars(TranslationService::t('footer_brand_title')) ?>. <?= TranslationService::t('footer_rights') ?></span>
    </div>
</footer> 