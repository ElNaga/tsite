<?php
// Modern, three-column footer with company info, contact, and links
?>
<footer class="site-footer">
    <div class="footer-main">
        <div class="footer-col footer-brand">
            <div class="footer-logo">🎭</div>
            <div class="footer-brand-name">Teatar za tebe</div>
            <div class="footer-brand-desc">
                <?= htmlspecialchars(I18nService::t('footer_page_desc')) ?>
            </div>
        </div>
        <div class="footer-col footer-contact">
            <div class="footer-contact-title"><?= I18nService::t('footer_contact_title') ?></div>
            <div class="footer-contact-item"><span class="footer-icon">📍</span> Tovarnik 1 br.29, Skopje, North Macedonia</div>
            <div class="footer-contact-item"><span class="footer-icon">📞</span> 075 262 903</div>
            <div class="footer-contact-item"><span class="footer-icon">✉️</span> izabelafdu@outlook.com</div>
        </div>
        <div class="footer-col footer-links">
            <div class="footer-links-title"><?= I18nService::t('footer_links_title') ?></div>
            <div class="footer-link-item"><span class="footer-icon">📷</span> <a href="https://www.instagram.com/teatarzatebe" target="_blank" rel="noopener">Instagram</a></div>
            <div class="footer-link-item"><span class="footer-icon">💬</span> <a href="#"><?= I18nService::t('footer_channel') ?></a> <span class="footer-channel-meta">Канал · 9 члена</span></div>
        </div>
    </div>
    <div class="footer-bottom">
        <span>&copy; <?= date('Y') ?> Teatar za tebe. <?= I18nService::t('footer_rights') ?></span>
    </div>
</footer> 