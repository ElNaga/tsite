-- Complete Database Schema for Teatar za tebe
-- Includes Events, Blog Posts, Users, Sessions, Translations, and Transactions

-- Languages table for i18n support
CREATE TABLE languages (
    code VARCHAR(2) PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Users table for authentication and user management
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'editor', 'user') DEFAULT 'user',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
);

-- User sessions table for session management
CREATE TABLE user_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    session_id VARCHAR(255) NOT NULL UNIQUE,
    user_id INT NULL,
    user_data JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_session_id (session_id),
    INDEX idx_expires_at (expires_at)
);

-- Events table (main event data)
CREATE TABLE events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    image VARCHAR(255) NOT NULL,
    book_url VARCHAR(255) NOT NULL,
    status ENUM('draft', 'published', 'archived') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status)
);

-- Event translations table (multilingual content)
CREATE TABLE event_translations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT NOT NULL,
    language_code VARCHAR(2) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    book_label VARCHAR(100) NOT NULL,
    image_alt VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (language_code) REFERENCES languages(code),
    UNIQUE KEY unique_event_lang (event_id, language_code),
    INDEX idx_language (language_code)
);

-- Blog posts table
CREATE TABLE blog_posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    slug VARCHAR(255) NOT NULL UNIQUE,
    author_id INT NOT NULL,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    featured_image VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published_at TIMESTAMP NULL,
    FOREIGN KEY (author_id) REFERENCES users(id),
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_published_at (published_at)
);

-- Blog post translations table
CREATE TABLE blog_post_translations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    blog_post_id INT NOT NULL,
    language_code VARCHAR(2) NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (language_code) REFERENCES languages(code),
    UNIQUE KEY unique_post_lang (blog_post_id, language_code),
    INDEX idx_language (language_code)
);

-- Transactions table (booking transactions)
CREATE TABLE transactions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT NOT NULL,
    user_data JSON NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    amount DECIMAL(10,2) NULL,
    payment_method VARCHAR(50) NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    INDEX idx_event_id (event_id),
    INDEX idx_status (status),
    INDEX idx_timestamp (timestamp)
);

-- Translations table (static content translations)
CREATE TABLE translations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    language_code VARCHAR(2) NOT NULL,
    translation_key VARCHAR(100) NOT NULL,
    translation_value TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (language_code) REFERENCES languages(code),
    UNIQUE KEY unique_lang_key (language_code, translation_key),
    INDEX idx_language (language_code),
    INDEX idx_key (translation_key)
);

-- Insert default languages
INSERT INTO languages (code, name) VALUES 
('en', 'English'),
('mk', 'Македонски'),
('fr', 'Français');

-- Insert default admin user (password: admin123)
INSERT INTO users (email, password_hash, name, role) VALUES 
('admin@teatarzatebe.mk', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', 'admin');

-- Insert default translations from i18n.php
INSERT INTO translations (language_code, translation_key, translation_value) VALUES
-- English translations
('en', 'site_title', 'Teatar za tebe - Interactive Theatre & Events for Kids'),
('en', 'site_description', 'Unforgettable children''s parties, interactive performances, drama studio, and creative workshops. Book your next event with Teatar za tebe!'),
('en', 'home', 'Home'),
('en', 'about', 'About'),
('en', 'offer', 'Offer'),
('en', 'blog', 'Blog'),
('en', 'contact', 'Contact'),
('en', 'language', 'Language'),
('en', 'book_now', 'Book now'),
('en', 'not_found_title', 'Page Not Found'),
('en', 'not_found_message', 'Sorry, the page you are looking for does not exist or has been moved. Try going back to the homepage.'),

-- Macedonian translations
('mk', 'site_title', 'Театар за тебе - Интерактивен театар и настани за деца'),
('mk', 'site_description', 'Незаборавни детски родендени, интерактивни претстави, драмско студио и креативни работилници. Закажете го вашиот следен настан со Театар за тебе!'),
('mk', 'home', 'Дома'),
('mk', 'about', 'За нас'),
('mk', 'offer', 'Понуда'),
('mk', 'blog', 'Блог'),
('mk', 'contact', 'Контакт'),
('mk', 'language', 'Јазик'),
('mk', 'book_now', 'Резервирај'),
('mk', 'not_found_title', 'Страницата не е пронајдена'),
('mk', 'not_found_message', 'Жалиме, страницата што ја барате не постои или е преместена. Обидете се да се вратите на почетната страница.'),

-- French translations
('fr', 'site_title', 'Théâtre pour toi - Théâtre interactif et événements pour enfants'),
('fr', 'site_description', 'Fêtes d''enfants inoubliables, spectacles interactifs, studio de théâtre et ateliers créatifs. Réservez votre prochain événement avec Théâtre pour toi!'),
('fr', 'home', 'Accueil'),
('fr', 'about', 'À propos'),
('fr', 'offer', 'Offre'),
('fr', 'blog', 'Blog'),
('fr', 'contact', 'Contact'),
('fr', 'language', 'Langue'),
('fr', 'book_now', 'Réserver'),
('fr', 'not_found_title', 'Page non trouvée'),
('fr', 'not_found_message', 'Désolé, la page que vous recherchez n''existe pas ou a été déplacée. Essayez de revenir à la page d''accueil.');








