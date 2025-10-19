<?php
// Enhanced footer with three sections: CTA, content grid, and copyright
?>
<footer class="site-footer">
    <!-- Top Section: Call-to-Action -->
    <div class="footer-cta-section">
        <div class="footer-cta-content">
            <div class="footer-cta-icon">✨</div>
            <h3 class="footer-cta-title"><?= htmlspecialchars(TranslationService::t('footer_ready_magic')) ?></h3>
            <p class="footer-cta-description"><?= htmlspecialchars(TranslationService::t('footer_plan_experience')) ?></p>
            <div class="footer-cta-buttons">
                <a href="/contact" class="cta-button cta-button-primary" aria-label="<?= htmlspecialchars(TranslationService::t('footer_book_party')) ?>">
                    <span class="cta-button-icon">🎉</span>
                    <?= htmlspecialchars(TranslationService::t('footer_book_party')) ?>
                </a>
                <a href="/contact" class="cta-button cta-button-secondary" aria-label="<?= htmlspecialchars(TranslationService::t('footer_join_newsletter')) ?>">
                    <span class="cta-button-icon">📧</span>
                    <?= htmlspecialchars(TranslationService::t('footer_join_newsletter')) ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Middle Section: Content Grid -->
    <div class="footer-content-grid">
        <div class="footer-content-container">
            <!-- Brand Column -->
            <div class="footer-column footer-brand-column">
                <div class="footer-brand-logo icon-shadow" aria-label="Theater mask logo">🎭</div>
                <h4 class="footer-column-title"><?= htmlspecialchars(TranslationService::t('footer_brand_title')) ?></h4>
                <p class="footer-brand-description"><?= htmlspecialchars(TranslationService::t('footer_brand_description')) ?></p>
            </div>

            <!-- Explore Column -->
            <div class="footer-column footer-explore-column">
                <h4 class="footer-column-title"><?= htmlspecialchars(TranslationService::t('footer_explore')) ?></h4>
                <nav class="footer-nav" aria-label="Main navigation">
                    <a href="/home" class="footer-link"><?= TranslationService::t('home') ?></a>
                    <a href="/about" class="footer-link"><?= TranslationService::t('about') ?></a>
                    <a href="/offer" class="footer-link"><?= TranslationService::t('offer') ?></a>
                    <a href="/blog" class="footer-link"><?= TranslationService::t('blog') ?></a>
                    <a href="/contact" class="footer-link"><?= TranslationService::t('contact') ?></a>
                </nav>
            </div>

            <!-- Contact Column -->
            <div class="footer-column footer-contact-column">
                <h4 class="footer-column-title">Contact</h4>
                <div class="footer-contact-info">
                    <div class="footer-contact-item">
                        <span class="footer-contact-icon icon-shadow" aria-label="Phone">📞</span>
                        <a href="tel:075262903" class="footer-contact-link">075 262 903</a>
                    </div>
                    <div class="footer-contact-item">
                        <span class="footer-contact-icon icon-shadow" aria-label="Email">✉️</span>
                        <a href="mailto:izabelafdu@outlook.com" class="footer-contact-link">izabelafdu@outlook.com</a>
                    </div>
                </div>
            </div>

            <!-- Follow Us Column -->
            <div class="footer-column footer-social-column">
                <h4 class="footer-column-title"><?= htmlspecialchars(TranslationService::t('footer_follow_us')) ?></h4>
                <div class="footer-social-links">
                    <a href="https://www.instagram.com/teatarzatebe" target="_blank" rel="noopener" class="footer-social-link" aria-label="Follow us on Instagram">
                        <span class="footer-social-icon icon-shadow">📷</span>
                        <span class="footer-social-text">Instagram</span>
                    </a>
                    <a href="#" class="footer-social-link" aria-label="Join our community">
                        <span class="footer-social-icon icon-shadow">💬</span>
                        <span class="footer-social-text"><?= TranslationService::t('footer_channel') ?></span>
                    </a>
                </div>
                <p class="footer-social-description"><?= TranslationService::t('footer_channel_members') ?></p>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Copyright and Language Selector -->
    <div class="footer-bottom-section">
        <div class="footer-bottom-content">
            <div class="footer-copyright">
                <span>&copy; <?= date('Y') ?> <?= htmlspecialchars(TranslationService::t('footer_brand_title')) ?>. <?= TranslationService::t('footer_rights') ?></span>
            </div>
            <div class="footer-language-selector">
                <a href="?lang=en" class="footer-lang-link<?= TranslationService::getCurrentLang() === 'en' ? ' active' : '' ?>" aria-label="Switch to English">EN</a>
                <a href="?lang=mk" class="footer-lang-link<?= TranslationService::getCurrentLang() === 'mk' ? ' active' : '' ?>" aria-label="Switch to Macedonian">MK</a>
                <a href="?lang=fr" class="footer-lang-link<?= TranslationService::getCurrentLang() === 'fr' ? ' active' : '' ?>" aria-label="Switch to French">FR</a>
            </div>
        </div>
    </div>
</footer> 