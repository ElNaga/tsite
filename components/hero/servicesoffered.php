<?php
$lang = I18nService::getCurrentLang();
$servicesOffered = [
    [
        'icon' => '🎉',
        'title_key' => 'service1_title',
        'desc_key' => 'service1_desc',
    ],
    [
        'icon' => '🎭',
        'title_key' => 'service2_title',
        'desc_key' => 'service2_desc',
    ],
    [
        'icon' => '🖍️',
        'title_key' => 'service3_title',
        'desc_key' => 'service3_desc',
    ],
];
?>
<section class="services-offered-section">
    <div class="services-offered-container">
        <?php foreach ($servicesOffered as $i => $service): ?>
            <div class="service-block">
                <div class="service-knob" title="Knob"></div>
                <div class="service-icon"><?= $service['icon'] ?></div>
                <div class="service-title"><?= htmlspecialchars(I18nService::t($service['title_key'])) ?></div>
                <div class="service-desc"><?= htmlspecialchars(I18nService::t($service['desc_key'])) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</section> 