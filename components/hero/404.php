<?php
require_once __DIR__ . '/../../i18n.php';
?>
<section class="not-found-section" style="display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:60vh;text-align:center;padding:2rem 1rem;">
  <div style="font-size:5rem;line-height:1;">🎭</div>
  <h1 style="font-size:2.5rem;color:#d7263d;margin:1rem 0 0.5rem 0;">404</h1>
  <h2 style="font-size:1.5rem;color:#1E2C74;margin-bottom:1rem;">
    <?= htmlspecialchars(I18nService::t('not_found_title')) ?>
  </h2>
  <p style="font-size:1.1rem;color:#444;max-width:400px;margin-bottom:2rem;">
    <?= htmlspecialchars(I18nService::t('not_found_message')) ?>
  </p>
  <a href="/home" style="display:inline-block;background:#d7263d;color:#fff;font-weight:700;font-size:1.1rem;letter-spacing:1px;text-transform:uppercase;border:none;border-radius:8px;padding:12px 28px;text-decoration:none;box-shadow:0 2px 8px rgba(215,38,61,0.15);transition:background 0.2s,color 0.2s,box-shadow 0.2s,transform 0.15s;cursor:pointer;outline:none;font-family:inherit;">← <?= htmlspecialchars(I18nService::t('home')) ?></a>
</section> 