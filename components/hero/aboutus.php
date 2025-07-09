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
    <div class="about-divider"></div>
</section> 