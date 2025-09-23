// Blog JavaScript functionality
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('blog-modal');

    if (!modal) {
        console.error('Blog modal not found');
        return;
    }

    const modalOverlay = modal.querySelector('.modal-overlay');
    const modalClose = modal.querySelector('.modal-close');
    const modalBody = modal.querySelector('.modal-body');
    const blogCards = document.querySelectorAll('.blog-card');

    console.log('Found', blogCards.length, 'blog cards');

    // Open modal when blog card is clicked
    blogCards.forEach(card => {
        card.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            console.log('Blog card clicked, post ID:', postId);
            if (postId) {
                openBlogModal(postId);
            } else {
                console.error('No post ID found on blog card');
            }
        });
    });

    // Close modal events
    modalClose.addEventListener('click', closeBlogModal);
    modalOverlay.addEventListener('click', closeBlogModal);

    // Close modal with ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.style.display !== 'none') {
            closeBlogModal();
        }
    });

    // Prevent modal content clicks from closing modal
    modal.querySelector('.modal-content').addEventListener('click', function (e) {
        e.stopPropagation();
    });

    function openBlogModal(postId) {
        console.log('Opening modal for post ID:', postId);

        // Show loading state
        modalBody.innerHTML = '<div class="loading">Loading...</div>';
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        // Fetch blog post content
        fetch(`/api/blog/${postId}`)
            .then(response => {
                console.log('API response status:', response.status);
                console.log('API response headers:', response.headers);

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Response is not JSON');
                }

                return response.text().then(text => {
                    console.log('Raw response:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        console.error('Response text:', text);
                        throw new Error('Invalid JSON response');
                    }
                });
            })
            .then(data => {
                console.log('Blog post data received:', data);
                renderBlogModal(data);
            })
            .catch(error => {
                console.error('Error loading blog post:', error);
                modalBody.innerHTML = `<div class="error">Failed to load blog post: ${error.message}</div>`;
            });
    }

    function closeBlogModal() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        modalBody.innerHTML = '';
    }

    function renderBlogModal(post) {
        const galleryHtml = post.gallery_images && post.gallery_images.length > 0
            ? renderGallery(post.gallery_images)
            : '';

        modalBody.innerHTML = `
            <h1 class="modal-blog-title">${escapeHtml(post.main_title)}</h1>
            <div class="modal-blog-meta">
                <span class="blog-date">${formatDate(post.created_at)}</span>
                <span class="blog-language">${post.language.toUpperCase()}</span>
            </div>
            <div class="modal-blog-image">
                <img src="${escapeHtml(post.main_image)}" alt="${escapeHtml(post.main_title)}" loading="lazy">
            </div>
            <div class="modal-blog-text">${post.main_text}</div>
            <h2 class="modal-blog-secondary-title">${escapeHtml(post.secondary_title)}</h2>
            <div class="modal-blog-secondary-image">
                <img src="${escapeHtml(post.secondary_image)}" alt="${escapeHtml(post.secondary_title)}" loading="lazy">
            </div>
            <div class="modal-blog-text">${post.secondary_text}</div>
            ${galleryHtml}
        `;

        // Initialize gallery functionality if present
        if (post.gallery_images && post.gallery_images.length > 0) {
            initializeGallery();
        }
    }

    function renderGallery(galleryImages) {
        if (!galleryImages || galleryImages.length === 0) return '';

        const galleryItems = galleryImages.map((image, index) =>
            `<div class="gallery-item" data-index="${index}">
                <img src="${escapeHtml(image)}" alt="Gallery image ${index + 1}" loading="lazy">
            </div>`
        ).join('');

        return `
            <div class="modal-blog-gallery">
                <h3>Gallery</h3>
                <div class="gallery-grid">
                    ${galleryItems}
                </div>
            </div>
            <div class="gallery-fullscreen" id="gallery-fullscreen">
                <button class="gallery-fullscreen-close">&times;</button>
                <img id="gallery-fullscreen-img" src="" alt="">
            </div>
        `;
    }

    function initializeGallery() {
        const galleryItems = modalBody.querySelectorAll('.gallery-item');
        const fullscreen = document.getElementById('gallery-fullscreen');
        const fullscreenImg = document.getElementById('gallery-fullscreen-img');
        const fullscreenClose = fullscreen.querySelector('.gallery-fullscreen-close');

        galleryItems.forEach(item => {
            item.addEventListener('click', function () {
                const imgSrc = this.querySelector('img').src;
                fullscreenImg.src = imgSrc;
                fullscreenImg.alt = this.querySelector('img').alt;
                fullscreen.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });

        // Close fullscreen gallery
        fullscreenClose.addEventListener('click', closeFullscreenGallery);
        fullscreen.addEventListener('click', function (e) {
            if (e.target === fullscreen) {
                closeFullscreenGallery();
            }
        });

        // Close with ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && fullscreen.classList.contains('active')) {
                closeFullscreenGallery();
            }
        });
    }

    function closeFullscreenGallery() {
        const fullscreen = document.getElementById('gallery-fullscreen');
        if (fullscreen) {
            fullscreen.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    // Smooth scrolling for pagination links
    document.querySelectorAll('.pagination-link, .pagination-btn').forEach(link => {
        link.addEventListener('click', function (e) {
            // Only handle if it's a same-page link
            if (this.href && this.href.includes(window.location.pathname)) {
                e.preventDefault();
                window.location.href = this.href;
            }
        });
    });

    // Add loading states for better UX
    function addLoadingState() {
        const loadingStyle = document.createElement('style');
        loadingStyle.textContent = `
            .loading {
                text-align: center;
                padding: 2rem;
                color: #666;
                font-size: 1.1rem;
            }
            .error {
                text-align: center;
                padding: 2rem;
                color: #e74c3c;
                font-size: 1.1rem;
            }
        `;
        document.head.appendChild(loadingStyle);
    }

    addLoadingState();
});
