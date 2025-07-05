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
<section class="about-us-section">
    <div class="about-us-container">
        <?php foreach ($aboutSections as $section): ?>
            <div class="about-column">
                <div class="about-icon"><?= $section['icon'] ?></div>
                <h2 class="about-heading"><?= htmlspecialchars(I18nService::t($section['heading_key'])) ?></h2>
                <?php if ($section['is_list']): ?>
                    <ul class="about-list">
                        <?php 
                        $listItems = explode('|', I18nService::t($section['body_key']));
                        foreach ($listItems as $item): 
                        ?>
                            <li><?= htmlspecialchars(trim($item)) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="about-body"><?= htmlspecialchars(I18nService::t($section['body_key'])) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="about-divider"></div>
</section> 