<?php
// TranslationService is already loaded in index.php
?>
<nav class="navbar">
    <div class="navbar-left">
        <span class="logo" onclick="window.location.href='/home'" style="cursor:pointer;">LOGO</span>
    </div>
    <button class="navbar-toggle" aria-label="Toggle menu" onclick="document.querySelector('.navbar-menu').classList.toggle('show')">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>
    <div class="navbar-menu">
        <div class="navbar-right">
            <a href="/home"><?= TranslationService::t('home') ?></a>
            <a href="/about"><?= TranslationService::t('about') ?></a>
            <div class="dropdown">
                <button class="dropbtn"><?= TranslationService::t('offer') ?> &#9662;</button>
                <div class="dropdown-content">
                    <a href="/offer1"><?= TranslationService::t('offer1') ?></a>
                    <a href="/offer2"><?= TranslationService::t('offer2') ?></a>
                </div>
            </div>
            <a href="/blog"><?= TranslationService::t('blog') ?></a>
            <a href="/contact"><?= TranslationService::t('contact') ?></a>
            <div class="lang-switch">
                <label for="lang-select" style="display: flex; align-items: center;">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="10" cy="10" r="9" stroke="#222" stroke-width="2" fill="#fff"/>
                        <ellipse cx="10" cy="10" rx="7" ry="9" stroke="#222" stroke-width="1.5" fill="none"/>
                        <ellipse cx="10" cy="10" rx="9" ry="3" stroke="#222" stroke-width="1.5" fill="none"/>
                    </svg>
                </label>
                <select id="lang-select" onchange="changeLanguage(this.value)">
                    <?php foreach (TranslationService::getLanguages() as $code => $name): ?>
                        <option value="<?= $code ?>"<?= TranslationService::getCurrentLang() === $code ? ' selected' : '' ?>><?= $name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <script>
                function changeLanguage(lang) {
                    const currentUrl = new URL(window.location);
                    currentUrl.searchParams.set('lang', lang);
                    window.location.href = currentUrl.toString();
                }
            </script>
        </div>
    </div>
</nav> 