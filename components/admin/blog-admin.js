// Blog Admin JavaScript functionality
let blogAdminInitialized = false;

document.addEventListener('DOMContentLoaded', function () {
    const blogModal = document.getElementById('blog-modal');
    const blogForm = document.getElementById('blog-form');
    const addBlogBtn = document.getElementById('add-blog-btn');
    const blogCancelBtn = document.getElementById('blog-cancel-btn');
    const blogTable = document.getElementById('blog-table');
    const languageFilter = document.getElementById('blog-language-filter');
    const visibilityFilter = document.getElementById('blog-visibility-filter');

    let currentBlogPosts = [];

    // Initialize blog admin
    initBlogAdmin();

    function initBlogAdmin() {
        if (blogAdminInitialized) return;

        loadBlogPosts();

        // Event listeners
        addBlogBtn.addEventListener('click', openBlogModal);
        blogCancelBtn.addEventListener('click', closeBlogModal);
        blogForm.addEventListener('submit', handleBlogSubmit);
        languageFilter.addEventListener('change', filterBlogPosts);
        visibilityFilter.addEventListener('change', filterBlogPosts);

        // Image preview functionality
        setupImagePreviews();

        // File upload functionality
        setupFileUploads();

        blogAdminInitialized = true;
    }

    // Function to initialize blog admin when section becomes active
    window.initBlogSection = function () {
        initBlogAdmin();
    };

    function setupFileUploads() {
        // Main image upload
        const mainImageUpload = document.getElementById('blog-main-image-upload');
        if (mainImageUpload) {
            mainImageUpload.addEventListener('change', function (e) {
                handleImageUpload(e, 'blog-main-image');
            });
        }

        // Secondary image upload
        const secondaryImageUpload = document.getElementById('blog-secondary-image-upload');
        if (secondaryImageUpload) {
            secondaryImageUpload.addEventListener('change', function (e) {
                handleImageUpload(e, 'blog-secondary-image');
            });
        }

        // Gallery images upload
        const galleryUpload = document.getElementById('blog-gallery-upload');
        if (galleryUpload) {
            galleryUpload.addEventListener('change', function (e) {
                handleGalleryUpload(e);
            });
        }
    }

    function handleImageUpload(event, targetInputId) {
        const file = event.target.files[0];
        if (!file) return;

        const targetInput = document.getElementById(targetInputId);
        const previewContainer = document.getElementById(targetInputId.replace('blog-', '').replace('-image', '-image-preview'));

        // Show loading status
        showUploadStatus(previewContainer, 'Uploading...', 'loading');

        const formData = new FormData();
        formData.append('image', file);

        fetch('/api/upload/blog', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    targetInput.value = data.url;
                    showUploadStatus(previewContainer, 'Upload successful!', 'success');
                    updateImagePreview(targetInputId);

                    // Clear the file input
                    event.target.value = '';
                } else {
                    showUploadStatus(previewContainer, 'Upload failed: ' + data.error, 'error');
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                showUploadStatus(previewContainer, 'Upload failed: ' + error.message, 'error');
            });
    }

    function handleGalleryUpload(event) {
        const files = Array.from(event.target.files);
        if (files.length === 0) return;

        const galleryTextarea = document.getElementById('blog-gallery-images');
        const previewContainer = document.getElementById('gallery-images-preview');

        // Show loading status
        showUploadStatus(previewContainer, `Uploading ${files.length} images...`, 'loading');

        let uploadPromises = files.map(file => {
            const formData = new FormData();
            formData.append('image', file);

            return fetch('/api/upload/blog', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json());
        });

        Promise.all(uploadPromises)
            .then(results => {
                const successfulUploads = results.filter(result => result.success);
                const failedUploads = results.filter(result => !result.success);

                if (successfulUploads.length > 0) {
                    // Get current URLs
                    const currentUrls = galleryTextarea.value.split('\n').filter(url => url.trim());

                    // Add new URLs
                    const newUrls = successfulUploads.map(result => result.url);
                    const allUrls = [...currentUrls, ...newUrls];

                    galleryTextarea.value = allUrls.join('\n');

                    let statusMessage = `Successfully uploaded ${successfulUploads.length} images!`;
                    if (failedUploads.length > 0) {
                        statusMessage += ` ${failedUploads.length} uploads failed.`;
                    }

                    showUploadStatus(previewContainer, statusMessage, 'success');
                    updateImagePreview('blog-gallery-images');
                } else {
                    showUploadStatus(previewContainer, 'All uploads failed', 'error');
                }
            })
            .catch(error => {
                console.error('Gallery upload error:', error);
                showUploadStatus(previewContainer, 'Upload failed: ' + error.message, 'error');
            })
            .finally(() => {
                // Clear the file input
                event.target.value = '';
            });
    }

    function showUploadStatus(container, message, type) {
        // Remove existing status
        const existingStatus = container.querySelector('.upload-status');
        if (existingStatus) {
            existingStatus.remove();
        }

        // Add new status
        const statusDiv = document.createElement('div');
        statusDiv.className = `upload-status ${type}`;
        statusDiv.textContent = message;
        container.appendChild(statusDiv);

        // Auto-remove success/error messages after 3 seconds
        if (type !== 'loading') {
            setTimeout(() => {
                if (statusDiv.parentNode) {
                    statusDiv.remove();
                }
            }, 3000);
        }
    }

    function loadBlogPosts() {
        fetch('/api/blog?admin=true')
            .then(response => {
                console.log('Admin API response status:', response.status);
                console.log('Admin API response headers:', response.headers);

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Response is not JSON');
                }

                return response.text().then(text => {
                    console.log('Admin raw response:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Admin JSON parse error:', e);
                        console.error('Admin response text:', text);
                        throw new Error('Invalid JSON response');
                    }
                });
            })
            .then(data => {
                console.log('Admin blog posts data received:', data);
                currentBlogPosts = data.posts || [];
                renderBlogTable(currentBlogPosts);
            })
            .catch(error => {
                console.error('Error loading blog posts:', error);
                showNotification('Error loading blog posts: ' + error.message, 'error');
            });
    }

    function renderBlogTable(posts) {
        const tbody = blogTable.querySelector('tbody');
        tbody.innerHTML = '';

        if (posts.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No blog posts found</td></tr>';
            return;
        }

        posts.forEach(post => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${post.id}</td>
                <td><span class="language-badge">${post.language.toUpperCase()}</span></td>
                <td>${escapeHtml(post.main_title)}</td>
                <td>${escapeHtml(post.secondary_title)}</td>
                <td>
                    <label class="toggle-switch">
                        <input type="checkbox" ${post.visible ? 'checked' : ''} 
                               onchange="toggleBlogVisibility(${post.id}, this.checked)">
                        <span class="toggle-slider"></span>
                    </label>
                </td>
                <td>${formatDate(post.created_at)}</td>
                <td>
                    <button class="btn-edit" data-post-id="${post.id}">Edit</button>
                    <button class="btn-delete" data-post-id="${post.id}">Delete</button>
                </td>
            `;
            tbody.appendChild(row);
        });

        // Add event listeners for edit and delete buttons
        tbody.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function () {
                const postId = this.getAttribute('data-post-id');
                openBlogModal(postId);
            });
        });

        tbody.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function () {
                const postId = this.getAttribute('data-post-id');
                deleteBlogPost(postId);
            });
        });
    }

    function filterBlogPosts() {
        const language = languageFilter.value;
        const visibility = visibilityFilter.value;

        let filteredPosts = currentBlogPosts;

        if (language) {
            filteredPosts = filteredPosts.filter(post => post.language === language);
        }

        if (visibility !== '') {
            const isVisible = visibility === '1';
            filteredPosts = filteredPosts.filter(post => post.visible === isVisible);
        }

        renderBlogTable(filteredPosts);
    }

    function openBlogModal(postId = null) {
        const modalTitle = document.getElementById('blog-modal-title');
        const form = document.getElementById('blog-form');

        if (postId) {
            modalTitle.textContent = 'Edit Blog Post';
            loadBlogPost(postId);
        } else {
            modalTitle.textContent = 'Add New Blog Post';
            form.reset();
            document.getElementById('blog-visible').checked = true;
            clearImagePreviews();
        }

        blogModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeBlogModal() {
        blogModal.style.display = 'none';
        document.body.style.overflow = '';
        blogForm.reset();
        clearImagePreviews();
    }

    function loadBlogPost(postId) {
        fetch(`/api/blog/${postId}?admin=true`)
            .then(response => response.json())
            .then(post => {
                document.getElementById('blog-id').value = post.id;
                document.getElementById('blog-language').value = post.language;
                document.getElementById('blog-main-title').value = post.main_title;
                document.getElementById('blog-main-text').value = post.main_text;
                document.getElementById('blog-main-image').value = post.main_image;
                document.getElementById('blog-secondary-title').value = post.secondary_title;
                document.getElementById('blog-secondary-text').value = post.secondary_text;
                document.getElementById('blog-secondary-image').value = post.secondary_image;
                // Handle gallery_images - it might be a string or array
                let galleryImages = post.gallery_images;
                if (typeof galleryImages === 'string') {
                    try {
                        galleryImages = JSON.parse(galleryImages);
                    } catch (e) {
                        galleryImages = galleryImages ? [galleryImages] : [];
                    }
                }
                if (!Array.isArray(galleryImages)) {
                    galleryImages = [];
                }
                document.getElementById('blog-gallery-images').value = galleryImages.join('\n');
                document.getElementById('blog-visible').checked = post.visible;

                updateImagePreviews();
            })
            .catch(error => {
                console.error('Error loading blog post:', error);
                showNotification('Error loading blog post', 'error');
            });
    }

    function handleBlogSubmit(e) {
        e.preventDefault();

        const formData = new FormData(blogForm);
        const postId = formData.get('id');
        const galleryImages = formData.get('gallery_images')
            .split('\n')
            .map(url => url.trim())
            .filter(url => url.length > 0);

        const data = {
            language: formData.get('language'),
            main_title: formData.get('main_title'),
            main_text: formData.get('main_text'),
            main_image: formData.get('main_image'),
            secondary_title: formData.get('secondary_title'),
            secondary_text: formData.get('secondary_text'),
            secondary_image: formData.get('secondary_image'),
            gallery_images: galleryImages,
            visible: formData.get('visible') === 'on'
        };

        const url = postId ? `/api/blog/${postId}` : '/api/blog';
        const method = postId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showNotification(result.message, 'success');
                    closeBlogModal();
                    loadBlogPosts();
                } else {
                    showNotification(result.error || 'Operation failed', 'error');
                }
            })
            .catch(error => {
                console.error('Error saving blog post:', error);
                showNotification('Error saving blog post', 'error');
            });
    }

    function setupImagePreviews() {
        const imageInputs = [
            { input: 'blog-main-image', preview: 'main-image-preview' },
            { input: 'blog-secondary-image', preview: 'secondary-image-preview' },
            { input: 'blog-gallery-images', preview: 'gallery-images-preview' }
        ];

        imageInputs.forEach(({ input, preview }) => {
            const inputElement = document.getElementById(input);
            const previewElement = document.getElementById(preview);

            inputElement.addEventListener('input', function () {
                updateImagePreview(inputElement, previewElement);
            });
        });
    }

    function updateImagePreview(inputElement, previewElement) {
        const value = inputElement.value.trim();

        if (inputElement.id === 'blog-gallery-images') {
            // Handle gallery images
            const urls = value.split('\n').filter(url => url.trim().length > 0);
            previewElement.innerHTML = '';

            urls.forEach(url => {
                const img = document.createElement('img');
                img.src = url.trim();
                img.alt = 'Gallery preview';
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.style.margin = '5px';
                img.style.borderRadius = '4px';
                img.onerror = function () {
                    this.style.display = 'none';
                };
                previewElement.appendChild(img);
            });
        } else {
            // Handle single images
            if (value) {
                previewElement.innerHTML = `<img src="${value}" alt="Preview" style="max-width: 200px; max-height: 150px; border-radius: 4px;" onerror="this.style.display='none'">`;
            } else {
                previewElement.innerHTML = '';
            }
        }
    }

    function updateImagePreviews() {
        updateImagePreview(document.getElementById('blog-main-image'), document.getElementById('main-image-preview'));
        updateImagePreview(document.getElementById('blog-secondary-image'), document.getElementById('secondary-image-preview'));
        updateImagePreview(document.getElementById('blog-gallery-images'), document.getElementById('gallery-images-preview'));
    }

    function clearImagePreviews() {
        document.getElementById('main-image-preview').innerHTML = '';
        document.getElementById('secondary-image-preview').innerHTML = '';
        document.getElementById('gallery-images-preview').innerHTML = '';
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
            month: 'short',
            day: 'numeric'
        });
    }

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;

        // Style the notification
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 4px;
            color: white;
            font-weight: 500;
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;

        // Set background color based on type
        switch (type) {
            case 'success':
                notification.style.backgroundColor = '#27ae60';
                break;
            case 'error':
                notification.style.backgroundColor = '#e74c3c';
                break;
            default:
                notification.style.backgroundColor = '#3498db';
        }

        document.body.appendChild(notification);

        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Global functions for inline event handlers
    window.editBlogPost = function (postId) {
        openBlogModal(postId);
    };

    window.deleteBlogPost = function (postId) {
        if (confirm('Are you sure you want to delete this blog post?')) {
            fetch(`/api/blog/${postId}?admin=true`, {
                method: 'DELETE'
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showNotification(result.message, 'success');
                        loadBlogPosts();
                    } else {
                        showNotification(result.error || 'Delete failed', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error deleting blog post:', error);
                    showNotification('Error deleting blog post', 'error');
                });
        }
    };

    window.toggleBlogVisibility = function (postId, isVisible) {
        fetch(`/api/blog/${postId}?admin=true`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ visible: isVisible })
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showNotification('Visibility updated', 'success');
                    loadBlogPosts();
                } else {
                    showNotification(result.error || 'Update failed', 'error');
                }
            })
            .catch(error => {
                console.error('Error updating visibility:', error);
                showNotification('Error updating visibility', 'error');
            });
    };

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        .toggle-switch input:checked + .toggle-slider {
            background-color: #2196F3;
        }
        .toggle-switch input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }
        .language-badge {
            background: #3498db;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .btn-edit, .btn-delete {
            padding: 4px 8px;
            margin: 0 2px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 0.8rem;
        }
        .btn-edit {
            background: #3498db;
            color: white;
        }
        .btn-delete {
            background: #e74c3c;
            color: white;
        }
        .btn-edit:hover {
            background: #2980b9;
        }
        .btn-delete:hover {
            background: #c0392b;
        }
        .admin-filters {
            margin: 1rem 0;
            display: flex;
            gap: 1rem;
        }
        .admin-filters select {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .image-preview {
            margin-top: 0.5rem;
        }
        .image-preview img {
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    `;
    document.head.appendChild(style);
});
