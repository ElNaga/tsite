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
    language VARCHAR(2) NOT NULL,
    main_title VARCHAR(255) NOT NULL,
    main_text TEXT NOT NULL,
    main_image VARCHAR(255) NOT NULL,
    secondary_title VARCHAR(255) NOT NULL,
    secondary_text TEXT NOT NULL,
    secondary_image VARCHAR(255) NOT NULL,
    gallery_images TEXT NULL,
    visible BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (language) REFERENCES languages(code),
    INDEX idx_language (language),
    INDEX idx_visible (visible),
    INDEX idx_created_at (created_at)
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

-- People table for team members
CREATE TABLE people (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NULL,
    language_code VARCHAR(2) NOT NULL,
    display_order INT DEFAULT 0,
    is_visible BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (language_code) REFERENCES languages(code),
    INDEX idx_language (language_code),
    INDEX idx_visible (is_visible),
    INDEX idx_order (display_order)
);

-- Contact messages table for storing contact form submissions
CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NULL,
    subject VARCHAR(255) NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied', 'archived') DEFAULT 'new',
    language_code VARCHAR(2) NOT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (language_code) REFERENCES languages(code),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    INDEX idx_email (email)
);

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
('en', 'contact_page_title', 'Contact Us'),
('en', 'contact_page_subtitle', 'Get in Touch'),
('en', 'contact_page_description', 'Have questions or want to book an event? We''d love to hear from you! Fill out the form below and we''ll get back to you as soon as possible.'),
('en', 'contact_form_name', 'Full Name'),
('en', 'contact_form_name_placeholder', 'Enter your full name'),
('en', 'contact_form_email', 'Email Address'),
('en', 'contact_form_email_placeholder', 'your.email@example.com'),
('en', 'contact_form_phone', 'Phone Number'),
('en', 'contact_form_phone_placeholder', 'Optional'),
('en', 'contact_form_subject', 'Subject'),
('en', 'contact_form_subject_placeholder', 'What is this about?'),
('en', 'contact_form_message', 'Message'),
('en', 'contact_form_message_placeholder', 'Tell us more about your inquiry...'),
('en', 'contact_form_submit', 'Send Message'),
('en', 'contact_form_sending', 'Sending...'),
('en', 'contact_form_success', 'Thank you for your message! We will get back to you soon.'),
('en', 'contact_form_error', 'Something went wrong. Please try again later.'),
('en', 'contact_info_title', 'Contact Information'),
('en', 'contact_info_phone', 'Phone'),
('en', 'contact_info_email', 'Email'),
('en', 'contact_info_social', 'Social Media'),
('en', 'contact_info_address', 'Address'),
('en', 'contact_error_name_required', 'Full name is required'),
('en', 'contact_error_name_min', 'Full name must be at least 2 characters'),
('en', 'contact_error_email_required', 'Email address is required'),
('en', 'contact_error_email_invalid', 'Please enter a valid email address'),
('en', 'contact_error_message_required', 'Message is required'),
('en', 'contact_error_message_min', 'Message must be at least 10 characters'),

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
('mk', 'contact_page_title', 'Контактирајте не'),
('mk', 'contact_page_subtitle', 'Стапете во контакт'),
('mk', 'contact_page_description', 'Имате прашања или сакате да резервирате настан? Ќе ни биде драго да ве слушнеме! Пополнете го формуларот подолу и ќе ви одговориме што е можно побрзо.'),
('mk', 'contact_form_name', 'Полно име'),
('mk', 'contact_form_name_placeholder', 'Внесете го вашето име'),
('mk', 'contact_form_email', 'Е-пошта'),
('mk', 'contact_form_email_placeholder', 'vasha.eposta@primer.mk'),
('mk', 'contact_form_phone', 'Телефонски број'),
('mk', 'contact_form_phone_placeholder', 'Опционално'),
('mk', 'contact_form_subject', 'Наслов'),
('mk', 'contact_form_subject_placeholder', 'За што се работи?'),
('mk', 'contact_form_message', 'Порака'),
('mk', 'contact_form_message_placeholder', 'Кажете ни повеќе за вашето прашање...'),
('mk', 'contact_form_submit', 'Испрати порака'),
('mk', 'contact_form_sending', 'Се испраќа...'),
('mk', 'contact_form_success', 'Ви благодариме за пораката! Наскоро ќе ви одговориме.'),
('mk', 'contact_form_error', 'Нешто тргна наопаку. Ве молиме обидете се повторно подоцна.'),
('mk', 'contact_info_title', 'Контакт информации'),
('mk', 'contact_info_phone', 'Телефон'),
('mk', 'contact_info_email', 'Е-пошта'),
('mk', 'contact_info_social', 'Социјални мрежи'),
('mk', 'contact_info_address', 'Адреса'),
('mk', 'contact_error_name_required', 'Полното име е задолжително'),
('mk', 'contact_error_name_min', 'Полното име мора да биде најмалку 2 карактери'),
('mk', 'contact_error_email_required', 'Е-поштата е задолжителна'),
('mk', 'contact_error_email_invalid', 'Ве молиме внесете валидна е-пошта'),
('mk', 'contact_error_message_required', 'Пораката е задолжителна'),
('mk', 'contact_error_message_min', 'Пораката мора да биде најмалку 10 карактери'),

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
('fr', 'not_found_message', 'Désolé, la page que vous recherchez n''existe pas ou a été déplacée. Essayez de revenir à la page d''accueil.'),
('fr', 'contact_page_title', 'Contactez-nous'),
('fr', 'contact_page_subtitle', 'Entrer en contact'),
('fr', 'contact_page_description', 'Vous avez des questions ou souhaitez réserver un événement? Nous serions ravis de vous entendre! Remplissez le formulaire ci-dessous et nous vous répondrons dès que possible.'),
('fr', 'contact_form_name', 'Nom complet'),
('fr', 'contact_form_name_placeholder', 'Entrez votre nom complet'),
('fr', 'contact_form_email', 'Adresse e-mail'),
('fr', 'contact_form_email_placeholder', 'votre.email@exemple.fr'),
('fr', 'contact_form_phone', 'Numéro de téléphone'),
('fr', 'contact_form_phone_placeholder', 'Optionnel'),
('fr', 'contact_form_subject', 'Sujet'),
('fr', 'contact_form_subject_placeholder', 'De quoi s''agit-il?'),
('fr', 'contact_form_message', 'Message'),
('fr', 'contact_form_message_placeholder', 'Parlez-nous de votre demande...'),
('fr', 'contact_form_submit', 'Envoyer le message'),
('fr', 'contact_form_sending', 'Envoi en cours...'),
('fr', 'contact_form_success', 'Merci pour votre message! Nous vous répondrons bientôt.'),
('fr', 'contact_form_error', 'Une erreur s''est produite. Veuillez réessayer plus tard.'),
('fr', 'contact_info_title', 'Informations de contact'),
('fr', 'contact_info_phone', 'Téléphone'),
('fr', 'contact_info_email', 'E-mail'),
('fr', 'contact_info_social', 'Réseaux sociaux'),
('fr', 'contact_info_address', 'Adresse'),
('fr', 'contact_error_name_required', 'Le nom complet est requis'),
('fr', 'contact_error_name_min', 'Le nom complet doit comporter au moins 2 caractères'),
('fr', 'contact_error_email_required', 'L''adresse e-mail est requise'),
('fr', 'contact_error_email_invalid', 'Veuillez entrer une adresse e-mail valide'),
('fr', 'contact_error_message_required', 'Le message est requis'),
('fr', 'contact_error_message_min', 'Le message doit comporter au moins 10 caractères');








