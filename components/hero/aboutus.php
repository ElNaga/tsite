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
                <h2 class="about-heading"><?= htmlspecialchars(TranslationService::t($aboutSections[0]['heading_key'])) ?></h2>
                <p class="about-body"><?= htmlspecialchars(TranslationService::t($aboutSections[0]['body_key'])) ?></p>
            </div>
            <div class="about-column">
                <div class="about-icon"><?= $aboutSections[1]['icon'] ?></div>
                <h2 class="about-heading"><?= htmlspecialchars(TranslationService::t($aboutSections[1]['heading_key'])) ?></h2>
                <p class="about-body"><?= htmlspecialchars(TranslationService::t($aboutSections[1]['body_key'])) ?></p>
            </div>
                <div class="about-column">
                <div class="about-icon"><?= $aboutSections[2]['icon'] ?></div>
                <h2 class="about-heading"><?= htmlspecialchars(TranslationService::t($aboutSections[2]['heading_key'])) ?></h2>
                        <ul class="about-list">
                            <?php 
                    $listItems = explode('|', TranslationService::t($aboutSections[2]['body_key']));
                            foreach ($listItems as $item): 
                            ?>
                                <li><?= htmlspecialchars(trim($item)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                </div>
        </div>
        <div class="about-us-button">
            <div class="about-arrow">→</div>
            <a href="/about" class="about-us-button"><?= TranslationService::t('about') ?></a>
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
      if (pwd !== null) {
        // Show loading state
        const originalPrompt = prompt;
        prompt = function() { return null; }; // Disable further prompts
        
        // Authenticate via database
        fetch('/api/admin/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ password: pwd })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Success - redirect to admin
            window.location.href = '/admin';
          } else {
            // Show error message
            alert('Incorrect password: ' + (data.error || 'Authentication failed'));
          }
        })
        .catch(error => {
          console.error('Admin login error:', error);
          alert('Login failed. Please try again.');
        })
        .finally(() => {
          // Re-enable prompts
          prompt = originalPrompt;
        });
      }
    }
  });
})();
</script> 