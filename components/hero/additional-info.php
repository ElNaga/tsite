<?php
// Additional info section (party-ideas), i18n-ready
?>
<section class="party-ideas-section">
    <div class="party-ideas-row">
        <div class="party-ideas-text-col">
            <h2 class="party-ideas-heading"><?= htmlspecialchars(I18nService::t('party_animation_title')) ?></h2>
            <p class="party-ideas-body">
                <?= nl2br(htmlspecialchars(I18nService::t('party_animation_body'))) ?>
            </p>
        </div>
        <div class="party-ideas-image-col">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80" alt="Children's party animation" class="party-ideas-image" />
        </div>
    </div>
    <div class="party-ideas-row party-ideas-row-bg">
        <div class="party-ideas-image-col">
            <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=900&q=80" alt="Birthday party ideas" class="party-ideas-image" />
        </div>
        <div class="party-ideas-text-col party-ideas-bg">
            <h2 class="party-ideas-heading"><?= htmlspecialchars(I18nService::t('party_ideas_title')) ?></h2>
            <p class="party-ideas-body">
                <?= nl2br(htmlspecialchars(I18nService::t('party_ideas_body'))) ?>
            </p>
        </div>
    </div>
</section> 