<?php
// TranslationService is already loaded in index.php
require_once __DIR__ . '/../../src/services/PeopleService.php';

// Get team members for current language
$currentLang = TranslationService::getCurrentLang();
$teamMembers = PeopleService::getVisiblePeople($currentLang);
?>

<!-- Hero Section -->
<section class="about-hero-section">
    <div class="about-hero-content">
        <h1 class="about-hero-title"><?= htmlspecialchars(TranslationService::t('about_hero_title')) ?></h1>
        <p class="about-hero-subtitle"><?= htmlspecialchars(TranslationService::t('about_hero_subtitle')) ?></p>
    </div>
</section>

<!-- Mission Statement Section -->
<section class="mission-section">
    <div class="container">
        <div class="mission-content">
            <h2 class="section-title"><?= htmlspecialchars(TranslationService::t('about_mission_title')) ?></h2>
            <div class="mission-text">
                <p><?= htmlspecialchars(TranslationService::t('about_mission_desc')) ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="story-section">
    <div class="container">
        <div class="story-content">
            <div class="story-text">
                <h2 class="section-title"><?= htmlspecialchars(TranslationService::t('about_story_title')) ?></h2>
                <p><?= htmlspecialchars(TranslationService::t('about_story_desc')) ?></p>
                <p><?= htmlspecialchars(TranslationService::t('about_story_desc2')) ?></p>
            </div>
            <div class="story-image">
                <img src="/assets/background-image.png" alt="<?= htmlspecialchars(TranslationService::t('about_story_image_alt')) ?>" />
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <h2 class="section-title"><?= htmlspecialchars(TranslationService::t('about_values_title')) ?></h2>
        <div class="values-grid">
            <div class="value-item">
                <div class="value-icon">🎭</div>
                <h3><?= htmlspecialchars(TranslationService::t('value_creativity_title')) ?></h3>
                <p><?= htmlspecialchars(TranslationService::t('value_creativity_desc')) ?></p>
            </div>
            <div class="value-item">
                <div class="value-icon">🤝</div>
                <h3><?= htmlspecialchars(TranslationService::t('value_community_title')) ?></h3>
                <p><?= htmlspecialchars(TranslationService::t('value_community_desc')) ?></p>
            </div>
            <div class="value-item">
                <div class="value-icon">🌟</div>
                <h3><?= htmlspecialchars(TranslationService::t('value_excellence_title')) ?></h3>
                <p><?= htmlspecialchars(TranslationService::t('value_excellence_desc')) ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Our Approach Section -->
<section class="approach-section">
    <div class="container">
        <h2 class="section-title"><?= htmlspecialchars(TranslationService::t('about_approach_title')) ?></h2>
        <div class="approach-content">
            <?php 
            $approachList = TranslationService::t('about_approach_list');
            $items = explode('|', $approachList);
            if (empty($items) || count($items) === 1) {
                // Fallback: try comma separation
                $items = explode(',', $approachList);
            }
            ?>
            <ul class="approach-list">
                <?php foreach ($items as $item): ?>
                    <li><?= htmlspecialchars(trim($item)) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <h2 class="section-title"><?= htmlspecialchars(TranslationService::t('about_team_title')) ?></h2>
        <p class="team-intro"><?= htmlspecialchars(TranslationService::t('about_team_intro')) ?></p>
        
        <?php if (!empty($teamMembers)): ?>
        <div class="team-grid">
            <?php foreach ($teamMembers as $member): ?>
            <div class="team-member">
                <div class="member-image">
                    <?php if ($member['image_url']): ?>
                        <img src="<?= htmlspecialchars($member['image_url']) ?>" alt="<?= htmlspecialchars($member['name']) ?>" />
                    <?php else: ?>
                        <div class="member-placeholder">
                            <span><?= strtoupper(substr($member['name'], 0, 2)) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="member-info">
                    <h3 class="member-name"><?= htmlspecialchars($member['name']) ?></h3>
                    <p class="member-title"><?= htmlspecialchars($member['title']) ?></p>
                    <p class="member-description"><?= htmlspecialchars($member['description']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="team-placeholder">
            <p><?= htmlspecialchars(TranslationService::t('about_team_placeholder')) ?></p>
        </div>
        <?php endif; ?>
        
        <div class="team-cta">
            <a href="/contact" class="cta-button"><?= htmlspecialchars(TranslationService::t('about_join_us')) ?></a>
        </div>
    </div>
</section>
