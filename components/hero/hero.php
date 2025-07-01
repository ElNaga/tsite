<?php
require_once __DIR__ . '/../../i18n.php';
require_once __DIR__ . '/../../src/services/EventService.php';

$event = EventService::getLatestEvent(I18nService::getCurrentLang());
?>
<section class="hero-section">
    <video class="hero-bg-video" autoplay loop muted playsinline>
        <source src="https://vimeo.com/284953008" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-event-card">
            <img src="<?= htmlspecialchars($event['image']) ?>" alt="<?= htmlspecialchars($event['image_alt']) ?>" class="hero-event-image">
            <div class="hero-event-info">
                <h1 class="hero-event-title"><?= htmlspecialchars($event['title']) ?></h1>
                <p class="hero-event-desc"><?= htmlspecialchars($event['desc']) ?></p>
                <a href="<?= htmlspecialchars($event['book_url']) ?>" class="hero-event-btn"><?= htmlspecialchars($event['book_label']) ?></a>
            </div>
        </div>
    </div>
</section> 