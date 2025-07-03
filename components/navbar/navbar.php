<?php
require_once __DIR__ . '/../../i18n.php';
?>
<nav class="navbar">
    <div class="navbar-left">
        <span class="logo">LOGO</span>
    </div>
    <div class="navbar-right">
        <a href="?page=home"><?= I18nService::t('home') ?></a>
        <a href="?page=about"><?= I18nService::t('about') ?></a>
        <div class="dropdown">
            <button class="dropbtn"><?= I18nService::t('offer') ?> &#9662;</button>
            <div class="dropdown-content">
                <a href="?page=offer1"><?= I18nService::t('offer1') ?></a>
                <a href="?page=offer2"><?= I18nService::t('offer2') ?></a>
            </div>
        </div>
        <a href="?page=blog"><?= I18nService::t('blog') ?></a>
        <a href="?page=contact"><?= I18nService::t('contact') ?></a>
        <form method="get" class="lang-switch">
            <label for="lang-select" style="display: flex; align-items: center;">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="10" cy="10" r="9" stroke="#222" stroke-width="2" fill="#fff"/>
                    <ellipse cx="10" cy="10" rx="7" ry="9" stroke="#222" stroke-width="1.5" fill="none"/>
                    <ellipse cx="10" cy="10" rx="9" ry="3" stroke="#222" stroke-width="1.5" fill="none"/>
                </svg>
            </label>
            <select name="lang" id="lang-select" onchange="this.form.submit()">
                <?php foreach (I18nService::getLanguages() as $code => $name): ?>
                    <option value="<?= $code ?>"<?= I18nService::getCurrentLang() === $code ? ' selected' : '' ?>><?= $name ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
</nav> 