<?php
// Modern, styled footer: three columns (logo, links, socials), copyright at bottom, playful icon shadows, full width
?>
<footer class="site-footer">
    <div class="footer-main-modern footer-cols">
        <div class="footer-col footer-brand-modern">
            <div class="footer-logo-modern icon-shadow">🎭</div>
            <div class="footer-brand-title">Театар за тебе</div>
            <div class="footer-brand-desc-modern">
                <?= htmlspecialchars(I18nService::t('footer_page_desc')) ?>
            </div>
        </div>
        <div class="footer-col footer-links-col">
            <a href="/home"><?= I18nService::t('home') ?></a><br>
            <a href="/about"><?= I18nService::t('about') ?></a><br>
            <a href="/offer"><?= I18nService::t('offer') ?></a><br>
            <a href="/blog"><?= I18nService::t('blog') ?></a><br>
            <a href="/contact"><?= I18nService::t('contact') ?></a>
        </div>
        <div class="footer-col footer-info-modern">
            <div class="footer-info-row"><span class="footer-icon-modern icon-shadow">📞</span> <span class="info-row-text">075 262 903</span></div>
            <div class="footer-info-row"><span class="footer-icon-modern icon-shadow">✉️</span> <span class="info-row-text">izabelafdu@outlook.com</span></div>
            <div class="footer-info-row"><span class="footer-icon-modern icon-shadow">📷</span> <a href="https://www.instagram.com/teatarzatebe" target="_blank" rel="noopener">Instagram</a></div>
            <div class="footer-info-row"><span class="footer-icon-modern icon-shadow">💬</span> <a href="#"><?= I18nService::t('footer_channel') ?></a> <span class="info-row-text">Канал · 9 члена</span></div>
        </div>
    </div>
    <div class="footer-bottom-modern">
        <span>&copy; <?= date('Y') ?> Театар за тебе. <?= I18nService::t('footer_rights') ?></span>
    </div>
</footer> 