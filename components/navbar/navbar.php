<?php
require_once __DIR__ . '/../../i18n.php';
?>
<nav class="navbar">
    <div class="navbar-left">
        <span class="logo">LOGO</span>
    </div>
    <div class="navbar-right">
        <a href="#home"><?= I18nService::t('home') ?></a>
        <a href="#about"><?= I18nService::t('about') ?></a>
        <div class="dropdown">
            <button class="dropbtn"><?= I18nService::t('offer') ?> &#9662;</button>
            <div class="dropdown-content">
                <a href="#offer1"><?= I18nService::t('offer1') ?></a>
                <a href="#offer2"><?= I18nService::t('offer2') ?></a>
            </div>
        </div>
        <a href="#blog"><?= I18nService::t('blog') ?></a>
        <a href="#contact"><?= I18nService::t('contact') ?></a>
        <form method="get" class="lang-switch">
            <label for="lang-select">🌐</label>
            <select name="lang" id="lang-select" onchange="this.form.submit()">
                <?php foreach (I18nService::getLanguages() as $code => $name): ?>
                    <option value="<?= $code ?>"<?= I18nService::getCurrentLang() === $code ? ' selected' : '' ?>><?= $name ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
</nav> 