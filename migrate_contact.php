<?php
/**
 * Contact Feature Migration Script
 * 
 * This script:
 * 1. Creates the contact_messages table
 * 2. Adds contact form translations to the database
 * 
 * Run this script once to set up the contact form feature.
 * 
 * Usage: php migrate_contact.php
 */

require_once __DIR__ . '/bootstrap.php';

try {
    echo "Starting Contact Feature Migration...\n\n";
    
    // Create contact_messages table
    echo "Creating contact_messages table...\n";
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS contact_messages (
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    echo "✓ contact_messages table created successfully\n\n";
    
    // Add translations
    echo "Adding contact form translations...\n";
    
    $translations = [
        // English
        ['en', 'contact_page_title', 'Contact Us'],
        ['en', 'contact_page_subtitle', 'Get in Touch'],
        ['en', 'contact_page_description', 'Have questions or want to book an event? We\'d love to hear from you! Fill out the form below and we\'ll get back to you as soon as possible.'],
        ['en', 'contact_form_name', 'Full Name'],
        ['en', 'contact_form_name_placeholder', 'Enter your full name'],
        ['en', 'contact_form_email', 'Email Address'],
        ['en', 'contact_form_email_placeholder', 'your.email@example.com'],
        ['en', 'contact_form_phone', 'Phone Number'],
        ['en', 'contact_form_phone_placeholder', 'Optional'],
        ['en', 'contact_form_subject', 'Subject'],
        ['en', 'contact_form_subject_placeholder', 'What is this about?'],
        ['en', 'contact_form_message', 'Message'],
        ['en', 'contact_form_message_placeholder', 'Tell us more about your inquiry...'],
        ['en', 'contact_form_submit', 'Send Message'],
        ['en', 'contact_form_sending', 'Sending...'],
        ['en', 'contact_form_success', 'Thank you for your message! We will get back to you soon.'],
        ['en', 'contact_form_error', 'Something went wrong. Please try again later.'],
        ['en', 'contact_info_title', 'Contact Information'],
        ['en', 'contact_info_phone', 'Phone'],
        ['en', 'contact_info_email', 'Email'],
        ['en', 'contact_info_social', 'Social Media'],
        ['en', 'contact_info_address', 'Address'],
        ['en', 'contact_error_name_required', 'Full name is required'],
        ['en', 'contact_error_name_min', 'Full name must be at least 2 characters'],
        ['en', 'contact_error_email_required', 'Email address is required'],
        ['en', 'contact_error_email_invalid', 'Please enter a valid email address'],
        ['en', 'contact_error_message_required', 'Message is required'],
        ['en', 'contact_error_message_min', 'Message must be at least 10 characters'],
        
        // Macedonian
        ['mk', 'contact_page_title', 'Контактирајте не'],
        ['mk', 'contact_page_subtitle', 'Стапете во контакт'],
        ['mk', 'contact_page_description', 'Имате прашања или сакате да резервирате настан? Ќе ни биде драго да ве слушнеме! Пополнете го формуларот подолу и ќе ви одговориме што е можно побрзо.'],
        ['mk', 'contact_form_name', 'Полно име'],
        ['mk', 'contact_form_name_placeholder', 'Внесете го вашето име'],
        ['mk', 'contact_form_email', 'Е-пошта'],
        ['mk', 'contact_form_email_placeholder', 'vasha.eposta@primer.mk'],
        ['mk', 'contact_form_phone', 'Телефонски број'],
        ['mk', 'contact_form_phone_placeholder', 'Опционално'],
        ['mk', 'contact_form_subject', 'Наслов'],
        ['mk', 'contact_form_subject_placeholder', 'За што се работи?'],
        ['mk', 'contact_form_message', 'Порака'],
        ['mk', 'contact_form_message_placeholder', 'Кажете ни повеќе за вашето прашање...'],
        ['mk', 'contact_form_submit', 'Испрати порака'],
        ['mk', 'contact_form_sending', 'Се испраќа...'],
        ['mk', 'contact_form_success', 'Ви благодариме за пораката! Наскоро ќе ви одговориме.'],
        ['mk', 'contact_form_error', 'Нешто тргна наопаку. Ве молиме обидете се повторно подоцна.'],
        ['mk', 'contact_info_title', 'Контакт информации'],
        ['mk', 'contact_info_phone', 'Телефон'],
        ['mk', 'contact_info_email', 'Е-пошта'],
        ['mk', 'contact_info_social', 'Социјални мрежи'],
        ['mk', 'contact_info_address', 'Адреса'],
        ['mk', 'contact_error_name_required', 'Полното име е задолжително'],
        ['mk', 'contact_error_name_min', 'Полното име мора да биде најмалку 2 карактери'],
        ['mk', 'contact_error_email_required', 'Е-поштата е задолжителна'],
        ['mk', 'contact_error_email_invalid', 'Ве молиме внесете валидна е-пошта'],
        ['mk', 'contact_error_message_required', 'Пораката е задолжителна'],
        ['mk', 'contact_error_message_min', 'Пораката мора да биде најмалку 10 карактери'],
        
        // French
        ['fr', 'contact_page_title', 'Contactez-nous'],
        ['fr', 'contact_page_subtitle', 'Entrer en contact'],
        ['fr', 'contact_page_description', 'Vous avez des questions ou souhaitez réserver un événement? Nous serions ravis de vous entendre! Remplissez le formulaire ci-dessous et nous vous répondrons dès que possible.'],
        ['fr', 'contact_form_name', 'Nom complet'],
        ['fr', 'contact_form_name_placeholder', 'Entrez votre nom complet'],
        ['fr', 'contact_form_email', 'Adresse e-mail'],
        ['fr', 'contact_form_email_placeholder', 'votre.email@exemple.fr'],
        ['fr', 'contact_form_phone', 'Numéro de téléphone'],
        ['fr', 'contact_form_phone_placeholder', 'Optionnel'],
        ['fr', 'contact_form_subject', 'Sujet'],
        ['fr', 'contact_form_subject_placeholder', 'De quoi s\'agit-il?'],
        ['fr', 'contact_form_message', 'Message'],
        ['fr', 'contact_form_message_placeholder', 'Parlez-nous de votre demande...'],
        ['fr', 'contact_form_submit', 'Envoyer le message'],
        ['fr', 'contact_form_sending', 'Envoi en cours...'],
        ['fr', 'contact_form_success', 'Merci pour votre message! Nous vous répondrons bientôt.'],
        ['fr', 'contact_form_error', 'Une erreur s\'est produite. Veuillez réessayer plus tard.'],
        ['fr', 'contact_info_title', 'Informations de contact'],
        ['fr', 'contact_info_phone', 'Téléphone'],
        ['fr', 'contact_info_email', 'E-mail'],
        ['fr', 'contact_info_social', 'Réseaux sociaux'],
        ['fr', 'contact_info_address', 'Adresse'],
        ['fr', 'contact_error_name_required', 'Le nom complet est requis'],
        ['fr', 'contact_error_name_min', 'Le nom complet doit comporter au moins 2 caractères'],
        ['fr', 'contact_error_email_required', 'L\'adresse e-mail est requise'],
        ['fr', 'contact_error_email_invalid', 'Veuillez entrer une adresse e-mail valide'],
        ['fr', 'contact_error_message_required', 'Le message est requis'],
        ['fr', 'contact_error_message_min', 'Le message doit comporter au moins 10 caractères']
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO translations (language_code, translation_key, translation_value)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE translation_value = VALUES(translation_value)
    ");
    
    $count = 0;
    foreach ($translations as $translation) {
        $stmt->execute($translation);
        $count++;
    }
    
    echo "✓ Added/updated $count translation entries\n\n";
    
    echo "=================================\n";
    echo "Migration completed successfully!\n";
    echo "=================================\n\n";
    echo "The contact form is now ready to use.\n";
    echo "Visit /contact on your website to see it in action.\n\n";
    
} catch (PDOException $e) {
    echo "✗ Migration failed: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}

