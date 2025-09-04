<?php
// Additional info section (party-ideas), i18n-ready
?>
<section class="party-ideas-section">
    <div class="party-ideas-row">
        <div class="party-ideas-text-col">
            <h2 class="party-ideas-heading"><?= htmlspecialchars(TranslationService::t('party_animation_title')) ?></h2>
            <p class="party-ideas-body">
                <?= nl2br(htmlspecialchars(TranslationService::t('party_animation_body'))) ?>
            </p>
        </div>
        <div class="party-ideas-image-col">
            <img src="https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=900&q=80" alt="Children's party animation" class="party-ideas-image" />
        </div>
    </div>
    <div class="party-ideas-row party-ideas-row-bg">
        <div class="party-ideas-image-col">
            <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=900&q=80" alt="Birthday party ideas" class="party-ideas-image no-radius" />
        </div>
        <div class="party-ideas-text-col party-ideas-bg">
            <h2 class="party-ideas-heading"><?= htmlspecialchars(TranslationService::t('party_ideas_title')) ?></h2>
            <p class="party-ideas-body">
                <?= nl2br(htmlspecialchars(TranslationService::t('party_ideas_body'))) ?>
            </p>
        </div>
    </div>
</section>
<div class="about-divider"></div> 