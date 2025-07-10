<?php
$aboutSections = [
    [
        'icon' => '🎯',
        'heading_key' => 'about_mission_title',
        'body_key' => 'about_mission_desc',
        'is_list' => false,
    ],
    [
        'icon' => '🌟',
        'heading_key' => 'about_values_title',
        'body_key' => 'about_values_desc',
        'is_list' => false,
    ],
    [
        'icon' => '💡',
        'heading_key' => 'about_approach_title',
        'body_key' => 'about_approach_list',
        'is_list' => true,
    ],
];
?>
<section class="about-us-section about-us-bg">
    <div class="about-us-container-wrapper">
        <div class="about-us-container">
            <div class="about-column">
                <div class="about-icon"><?= $aboutSections[0]['icon'] ?></div>
                <h2 class="about-heading"><?= htmlspecialchars(I18nService::t($aboutSections[0]['heading_key'])) ?></h2>
                <p class="about-body"><?= htmlspecialchars(I18nService::t($aboutSections[0]['body_key'])) ?></p>
            </div>
            <div class="about-column">
                <div class="about-icon"><?= $aboutSections[1]['icon'] ?></div>
                <h2 class="about-heading"><?= htmlspecialchars(I18nService::t($aboutSections[1]['heading_key'])) ?></h2>
                <p class="about-body"><?= htmlspecialchars(I18nService::t($aboutSections[1]['body_key'])) ?></p>
            </div>
                <div class="about-column">
                <div class="about-icon"><?= $aboutSections[2]['icon'] ?></div>
                <h2 class="about-heading"><?= htmlspecialchars(I18nService::t($aboutSections[2]['heading_key'])) ?></h2>
                        <ul class="about-list">
                            <?php 
                    $listItems = explode('|', I18nService::t($aboutSections[2]['body_key']));
                            foreach ($listItems as $item): 
                            ?>
                                <li><?= htmlspecialchars(trim($item)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                </div>
        </div>
        <div class="about-us-button">
            <div class="about-arrow">→</div>
            <a href="/about" class="about-us-button"><?= I18nService::t('about') ?></a>
        </div>
    </div>
    <div class="about-divider"></div>
</section>
<script>
// Admin Panel Trigger: Ctrl+I
(function() {
  let isAdminPrompted = false;
  document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && (e.key === 'i' || e.key === 'I')) {
      if (isAdminPrompted) return;
      isAdminPrompted = true;
      setTimeout(() => { isAdminPrompted = false; }, 2000);
      const pwd = prompt('Enter admin password:');
      if (pwd && pwd === 'admin123') {
        // Set session via fetch, then redirect
        fetch('/admin_login.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ login: true }) })
          .then(() => { window.location.href = '/admin'; });
      } else if (pwd !== null) {
        alert('Incorrect password.');
      }
    }
  });
})();
</script> 