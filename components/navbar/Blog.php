<?php
require_once __DIR__ . '/../../src/services/BlogService.php';
require_once __DIR__ . '/../../src/services/TranslationService.php';

// Get current language
$currentLang = TranslationService::getCurrentLang();

// Get page number from URL
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Get blog posts and pagination info
$blogPosts = BlogService::getBlogPosts($currentLang, $page, 20);
$paginationInfo = BlogService::getPaginationInfo($currentLang, $page, 20);
$paginationLinks = BlogService::generatePaginationLinks($paginationInfo);
?>

<section class="page-section blog-section">
    <div class="container">
        <h1><?= htmlspecialchars(TranslationService::t('blog')) ?></h1>
        
        <?php if (empty($blogPosts)): ?>
            <div class="blog-empty">
                <p>No blog posts available in <?= $currentLang ?>.</p>
            </div>
        <?php else: ?>
            <div class="blog-grid">
                <?php foreach ($blogPosts as $index => $post): ?>
                    <article class="blog-card <?= $index % 2 === 0 ? 'image-left' : 'image-right' ?>" data-post-id="<?= $post->getId() ?>">
                        <div class="blog-card-image">
                            <img src="<?= htmlspecialchars($post->getMainImage()) ?>" alt="<?= htmlspecialchars($post->getMainTitle()) ?>" loading="lazy">
                        </div>
                        <div class="blog-card-content">
                            <h2 class="blog-main-title"><?= htmlspecialchars($post->getMainTitle()) ?></h2>
                            <p class="blog-main-text"><?= htmlspecialchars($post->getTrimmedMainText()) ?></p>
                            
                            <h3 class="blog-secondary-title"><?= htmlspecialchars($post->getSecondaryTitle()) ?></h3>
                            <p class="blog-secondary-text"><?= htmlspecialchars($post->getTrimmedSecondaryText()) ?></p>
                            
                            <div class="blog-card-image-secondary">
                                <img src="<?= htmlspecialchars($post->getSecondaryImage()) ?>" alt="<?= htmlspecialchars($post->getSecondaryTitle()) ?>" loading="lazy">
                            </div>
                            
                            <div class="blog-card-meta">
                                <span class="blog-date"><?= date('M j, Y', strtotime($post->getCreatedAt())) ?></span>
                                <span class="blog-language"><?= strtoupper($post->getLanguage()) ?></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($paginationInfo['total_pages'] > 1): ?>
                <nav class="blog-pagination">
                    <?php if ($paginationInfo['has_previous']): ?>
                        <a href="/blog?page=<?= $paginationInfo['previous_page'] ?>" class="pagination-btn pagination-prev">Previous</a>
                    <?php endif; ?>
                    
                    <div class="pagination-links">
                        <?php foreach ($paginationLinks as $link): ?>
                            <?php if ($link['page'] === null): ?>
                                <span class="pagination-ellipsis"><?= $link['label'] ?></span>
                            <?php else: ?>
                                <a href="<?= $link['url'] ?>" class="pagination-link <?= $link['active'] ? 'active' : '' ?>">
                                    <?= $link['label'] ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if ($paginationInfo['has_next']): ?>
                        <a href="/blog?page=<?= $paginationInfo['next_page'] ?>" class="pagination-btn pagination-next">Next</a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Blog Modal -->
<div id="blog-modal" class="blog-modal" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="modal-close" aria-label="Close modal">&times;</button>
        <div class="modal-body">
            <!-- Content will be loaded via AJAX -->
        </div>
    </div>
</div>

<link rel="stylesheet" href="components/blog/blog.css">
<script src="components/blog/blog.js"></script> 