<?php
$lang = TranslationService::getCurrentLang();
$servicesOffered = [
    [
        'icon' => '🎭',
        'title_key' => 'service1_title',
        'desc_key' => 'service1_desc',
        'image' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=800&q=80',
    ],
    [
        'icon' => '🤠',
        'title_key' => 'service2_title',
        'desc_key' => 'service2_desc',
        'image' => 'https://images.unsplash.com/photo-1503676382389-4809596d5290?auto=format&fit=crop&w=800&q=80',
    ],
    [
        'icon' => '📚',
        'title_key' => 'service3_title',
        'desc_key' => 'service3_desc',
        'image' => 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=800&q=80',
    ],
    [
        'icon' => '📝',
        'title_key' => 'service4_title',
        'desc_key' => 'service4_desc',
        'image' => 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=800&q=80',
    ],
    [
        'icon' => '🕺',
        'title_key' => 'service5_title',
        'desc_key' => 'service5_desc',
        'image' => 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=800&q=80',
    ],
];
?>
<section class="services-offered-section">
    <div class="services-offered-container">
        <?php foreach ($servicesOffered as $i => $service): ?>
            <div class="service-block">
                <img src="<?= htmlspecialchars($service['image']) ?>" alt="Service image" class="service-image" />
                <div class="service-knob" title="Knob"></div>
                <div class="service-icon"><?= $service['icon'] ?></div>
                <div class="service-title"><?= htmlspecialchars(TranslationService::t($service['title_key'])) ?></div>
                <div class="service-desc"><?= htmlspecialchars(TranslationService::t($service['desc_key'])) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</section> 