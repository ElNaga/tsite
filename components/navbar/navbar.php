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
            <div class="navbar-language-selector">
                <a href="?lang=en" class="navbar-lang-link<?= TranslationService::getCurrentLang() === 'en' ? ' active' : '' ?>" aria-label="Switch to English">EN</a>
                <a href="?lang=mk" class="navbar-lang-link<?= TranslationService::getCurrentLang() === 'mk' ? ' active' : '' ?>" aria-label="Switch to Macedonian">MK</a>
                <a href="?lang=fr" class="navbar-lang-link<?= TranslationService::getCurrentLang() === 'fr' ? ' active' : '' ?>" aria-label="Switch to French">FR</a>
            </div>
        </div>
    </div>
</nav> 