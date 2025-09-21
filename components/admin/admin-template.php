<?php
require_once __DIR__ . '/admin-controller.php';

// Check admin access
AdminController::requireAdmin();

// Get data from controller
$adminData = AdminController::getData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - TZT</title>
    <link rel="stylesheet" href="components/admin/admin.css">
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <h2>Admin Panel</h2>
            <nav class="admin-menu">
                <a href="#events" class="active">Events</a>
                <a href="#people">People of TZT</a>
            </nav>
        </aside>
        
        <main class="admin-content">
            <!-- Events Section -->
            <section id="section-events" class="admin-section active">
                <div class="admin-header">
                    <h1>Events (<?= $adminData['totalEvents'] ?>)</h1>
                    <button class="admin-btn">Add New Event</button>
                </div>
                
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title (EN)</th>
                            <th>Title (MK)</th>
                            <th>Title (FR)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Events will be loaded dynamically via JavaScript -->
                    </tbody>
                </table>
            </section>
            
            <!-- People Section -->
            <section id="section-people" class="admin-section">
                <div class="admin-header">
                    <h1>People of TZT</h1>
                    <button class="admin-btn" id="add-person-btn">Add New Person</button>
                </div>
                
                <table class="admin-table">
                    <thead>
                        <tr>
                       <th>ID</th>
                       <th>Name (EN)</th>
                       <th>Name (MK)</th>
                       <th>Name (FR)</th>
                       <th>Title</th>
                       <th>Visible</th>
                       <th>Order</th>
                       <th>Reorder</th>
                       <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- People will be loaded dynamically via JavaScript -->
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    
    <!-- Event Modal -->
    <div id="event-modal" class="event-modal">
        <div class="modal-content">
            <h2>Add/Edit Event</h2>
            <form id="event-form">
                <div class="form-grid">
                    <!-- English Column -->
                    <div class="form-column">
                        <label>Title (EN):</label>
                        <input name="title_en" required>
                        
                        <label>Description (EN):</label>
                        <textarea name="desc_en" required></textarea>
                        
                        <label>Book Label (EN):</label>
                        <input name="book_label_en" required value="Book now">
                        
                        <label>Book URL (EN):</label>
                        <input name="book_url_en" value="#">
                        
                        <label>Image URL (EN):</label>
                        <input name="image_en" value="/assets/background-image.png">
                        
                        <label>Image Alt (EN):</label>
                        <input name="image_alt_en">
                    </div>
                    
                    <!-- Macedonian Column -->
                    <div class="form-column">
                        <label>Title (MK):</label>
                        <input name="title_mk" required>
                        
                        <label>Description (MK):</label>
                        <textarea name="desc_mk" required></textarea>
                        
                        <label>Book Label (MK):</label>
                        <input name="book_label_mk" required value="Резервирај">
                        
                        <label>Book URL (MK):</label>
                        <input name="book_url_mk" value="#">
                        
                        <label>Image URL (MK):</label>
                        <input name="image_mk" value="/assets/background-image.png">
                        
                        <label>Image Alt (MK):</label>
                        <input name="image_alt_mk">
                    </div>
                    
                    <!-- French Column -->
                    <div class="form-column">
                        <label>Title (FR):</label>
                        <input name="title_fr" required>
                        
                        <label>Description (FR):</label>
                        <textarea name="desc_fr" required></textarea>
                        
                        <label>Book Label (FR):</label>
                        <input name="book_label_fr" required value="Réserver">
                        
                        <label>Book URL (FR):</label>
                        <input name="book_url_fr" value="#">
                        
                        <label>Image URL (FR):</label>
                        <input name="image_fr" value="/assets/background-image.png">
                        
                        <label>Image Alt (FR):</label>
                        <input name="image_alt_fr">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="admin-btn">Save</button>
                    <button type="button" class="admin-btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- People Modal -->
    <div id="people-modal" class="event-modal">
        <div class="modal-content">
            <h2>Add/Edit Person</h2>
            <form id="people-form" enctype="multipart/form-data">
                <div class="form-grid">
                    <!-- English Column -->
                    <div class="form-column">
                        <label>Name (EN):</label>
                        <input name="name_en" required>
                        
                        <label>Title (EN):</label>
                        <input name="title_en" required>
                        
                        <label>Description (EN):</label>
                        <textarea name="description_en" required></textarea>
                    </div>
                    
                    <!-- Macedonian Column -->
                    <div class="form-column">
                        <label>Name (MK):</label>
                        <input name="name_mk" required>
                        
                        <label>Title (MK):</label>
                        <input name="title_mk" required>
                        
                        <label>Description (MK):</label>
                        <textarea name="description_mk" required></textarea>
                    </div>
                    
                    <!-- French Column -->
                    <div class="form-column">
                        <label>Name (FR):</label>
                        <input name="name_fr" required>
                        
                        <label>Title (FR):</label>
                        <input name="title_fr" required>
                        
                        <label>Description (FR):</label>
                        <textarea name="description_fr" required></textarea>
                    </div>
                </div>
                
                <div class="form-row">
                    <label>
                        <input type="checkbox" name="is_visible" checked> Visible on website
                    </label>
                    <small>Display order will be assigned automatically</small>
                </div>
                
                <div class="form-row">
                    <label>Profile Image:</label>
                    <input type="file" name="profile_image" accept="image/*">
                    <small>Leave empty to keep current image</small>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="admin-btn">Save</button>
                    <button type="button" class="admin-btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="components/admin/admin.js"></script>
</body>
</html> 