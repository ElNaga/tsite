<?php
/**
 * Quick script to populate contact form translations
 * Run this to add contact translations to existing database
 */

require_once __DIR__ . '/bootstrap.php';

try {
    echo "Adding contact form translations...\n";
    
    $translations = [
        // English
        ['en', 'contact_page_title', 'Contact Us'],
        ['en', 'contact_page_subtitle', 'Let\'s Create Magic Together!'],
        ['en', 'contact_page_description', 'Ready to bring joy and laughter to your next event? Whether you\'re planning an unforgettable birthday party, an interactive theatre performance, or a creative workshop, we\'re here to make it special! Fill out the form below and we\'ll get back to you within 24 hours.'],
        ['en', 'contact_info_hours', 'Working Hours'],
        ['en', 'contact_info_hours_text', 'Monday - Sunday: 9:00 AM - 8:00 PM'],
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
        ['mk', 'contact_page_subtitle', 'Да создадеме магија заедно!'],
        ['mk', 'contact_page_description', 'Подготвени сте да донесете радост и смеа на вашиот следен настан? Без разлика дали планирате незаборавна прослава за роденден, интерактивна театарска претстава или креативна работилница, ние сме тука за да го направиме тоа посебно! Пополнете го формуларот подолу и ќе ви одговориме во рок од 24 часа.'],
        ['mk', 'contact_info_hours', 'Работно време'],
        ['mk', 'contact_info_hours_text', 'Понеделник - Недела: 9:00 - 20:00'],
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
        ['fr', 'contact_page_subtitle', 'Créons la magie ensemble!'],
        ['fr', 'contact_page_description', 'Prêt à apporter joie et rire à votre prochain événement? Que vous planifiez une fête d\'anniversaire inoubliable, une représentation théâtrale interactive ou un atelier créatif, nous sommes là pour le rendre spécial! Remplissez le formulaire ci-dessous et nous vous répondrons dans les 24 heures.'],
        ['fr', 'contact_info_hours', 'Heures d\'ouverture'],
        ['fr', 'contact_info_hours_text', 'Lundi - Dimanche: 9h00 - 20h00'],
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
        echo "✓ Added: {$translation[0]} - {$translation[1]}\n";
    }
    
    echo "\n=================================\n";
    echo "Successfully added $count contact translations!\n";
    echo "=================================\n\n";
    echo "Now visit /contact to see the form with proper text.\n";
    
} catch (PDOException $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
