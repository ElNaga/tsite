<?php
/**
 * Contact Page Component
 * 
 * Displays a contact form and contact information.
 * Features:
 * - Multi-language support
 * - Client-side validation
 * - Accessible form controls
 * - Responsive design
 * - Success/error messaging
 * 
 * @package TeatarZaTebe\Components
 */

// TranslationService is already loaded in index.php
?>
<section class="contact-page">
    <div class="contact-container">
        <!-- Page Header -->
        <div class="contact-header">
            <h1><?= htmlspecialchars(TranslationService::t('contact_page_title')) ?></h1>
            <p class="contact-subtitle"><?= htmlspecialchars(TranslationService::t('contact_page_subtitle')) ?></p>
            <p class="contact-description"><?= htmlspecialchars(TranslationService::t('contact_page_description')) ?></p>
        </div>

        <div class="contact-content">
            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <form id="contactForm" class="contact-form" novalidate>
                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="fullName" class="form-label">
                            <?= htmlspecialchars(TranslationService::t('contact_form_name')) ?> 
                            <span class="required" aria-label="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="fullName" 
                            name="full_name" 
                            class="form-control" 
                            placeholder="<?= htmlspecialchars(TranslationService::t('contact_form_name_placeholder')) ?>"
                            required
                            aria-required="true"
                            aria-describedby="fullNameError"
                        >
                        <div id="fullNameError" class="error-message" role="alert" aria-live="polite"></div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <?= htmlspecialchars(TranslationService::t('contact_form_email')) ?> 
                            <span class="required" aria-label="required">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control" 
                            placeholder="<?= htmlspecialchars(TranslationService::t('contact_form_email_placeholder')) ?>"
                            required
                            aria-required="true"
                            aria-describedby="emailError"
                        >
                        <div id="emailError" class="error-message" role="alert" aria-live="polite"></div>
                    </div>

                    <!-- Phone (Optional) -->
                    <div class="form-group">
                        <label for="phone" class="form-label">
                            <?= htmlspecialchars(TranslationService::t('contact_form_phone')) ?>
                        </label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            class="form-control" 
                            placeholder="<?= htmlspecialchars(TranslationService::t('contact_form_phone_placeholder')) ?>"
                            aria-describedby="phoneError"
                        >
                        <div id="phoneError" class="error-message" role="alert" aria-live="polite"></div>
                    </div>

                    <!-- Subject (Optional) -->
                    <div class="form-group">
                        <label for="subject" class="form-label">
                            <?= htmlspecialchars(TranslationService::t('contact_form_subject')) ?>
                        </label>
                        <input 
                            type="text" 
                            id="subject" 
                            name="subject" 
                            class="form-control" 
                            placeholder="<?= htmlspecialchars(TranslationService::t('contact_form_subject_placeholder')) ?>"
                            aria-describedby="subjectError"
                        >
                        <div id="subjectError" class="error-message" role="alert" aria-live="polite"></div>
                    </div>

                    <!-- Message -->
                    <div class="form-group">
                        <label for="message" class="form-label">
                            <?= htmlspecialchars(TranslationService::t('contact_form_message')) ?> 
                            <span class="required" aria-label="required">*</span>
                        </label>
                        <textarea 
                            id="message" 
                            name="message" 
                            class="form-control" 
                            rows="6"
                            placeholder="<?= htmlspecialchars(TranslationService::t('contact_form_message_placeholder')) ?>"
                            required
                            aria-required="true"
                            aria-describedby="messageError"
                        ></textarea>
                        <div id="messageError" class="error-message" role="alert" aria-live="polite"></div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <span class="btn-text"><?= htmlspecialchars(TranslationService::t('contact_form_submit')) ?></span>
                            <span class="btn-loading" style="display: none;"><?= htmlspecialchars(TranslationService::t('contact_form_sending')) ?></span>
                        </button>
                    </div>

                    <!-- Success/Error Messages -->
                    <div id="formMessage" class="form-message" role="status" aria-live="polite"></div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="contact-info">
                <h2><?= htmlspecialchars(TranslationService::t('contact_info_title')) ?></h2>
                
                <div class="info-item">
                    <div class="info-icon">📞</div>
                    <div class="info-content">
                        <h3><?= htmlspecialchars(TranslationService::t('contact_info_phone')) ?></h3>
                        <a href="tel:+38975262903">075 262 903</a>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📧</div>
                    <div class="info-content">
                        <h3><?= htmlspecialchars(TranslationService::t('contact_info_email')) ?></h3>
                        <a href="mailto:izabelafdu@outlook.com">izabelafdu@outlook.com</a>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📱</div>
                    <div class="info-content">
                        <h3><?= htmlspecialchars(TranslationService::t('contact_info_social')) ?></h3>
                        <a href="https://www.instagram.com/teatarzatebe" target="_blank" rel="noopener noreferrer">
                            @teatarzatebe
                        </a>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div class="info-content">
                        <h3><?= htmlspecialchars(TranslationService::t('contact_info_address')) ?></h3>
                        <p>Скопје, Македонија</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Load contact form JavaScript -->
<script>
    // Embed translations for JavaScript to use
    window.contactTranslations = {
        errorNameRequired: <?= json_encode(TranslationService::t('contact_error_name_required')) ?>,
        errorNameMin: <?= json_encode(TranslationService::t('contact_error_name_min')) ?>,
        errorEmailRequired: <?= json_encode(TranslationService::t('contact_error_email_required')) ?>,
        errorEmailInvalid: <?= json_encode(TranslationService::t('contact_error_email_invalid')) ?>,
        errorMessageRequired: <?= json_encode(TranslationService::t('contact_error_message_required')) ?>,
        errorMessageMin: <?= json_encode(TranslationService::t('contact_error_message_min')) ?>,
        formSuccess: <?= json_encode(TranslationService::t('contact_form_success')) ?>,
        formError: <?= json_encode(TranslationService::t('contact_form_error')) ?>,
        currentLang: <?= json_encode(TranslationService::getCurrentLang()) ?>
    };
</script>
<script src="components/navbar/contact.js"></script>
