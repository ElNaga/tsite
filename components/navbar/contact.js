/**
 * Contact Form Client-Side Validation and Submission
 * 
 * Provides:
 * - Real-time form validation
 * - Accessible error messaging
 * - AJAX form submission
 * - Multi-language support
 * 
 * @package TeatarZaTebe\Components
 */

(function() {
    'use strict';

    // Get translations from window object (set by PHP)
    const t = window.contactTranslations || {};

    // Form elements
    const form = document.getElementById('contactForm');
    const fullNameInput = document.getElementById('fullName');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const subjectInput = document.getElementById('subject');
    const messageInput = document.getElementById('message');
    const submitBtn = document.getElementById('submitBtn');
    const formMessage = document.getElementById('formMessage');

    // Error message elements
    const fullNameError = document.getElementById('fullNameError');
    const emailError = document.getElementById('emailError');
    const phoneError = document.getElementById('phoneError');
    const subjectError = document.getElementById('subjectError');
    const messageError = document.getElementById('messageError');

    /**
     * Validate email format
     * @param {string} email - Email address to validate
     * @returns {boolean} True if valid
     */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Show error message for a field
     * @param {HTMLElement} input - Input element
     * @param {HTMLElement} errorElement - Error message element
     * @param {string} message - Error message
     */
    function showError(input, errorElement, message) {
        input.classList.add('error');
        input.classList.remove('success');
        errorElement.textContent = message;
        input.setAttribute('aria-invalid', 'true');
    }

    /**
     * Show success state for a field
     * @param {HTMLElement} input - Input element
     * @param {HTMLElement} errorElement - Error message element
     */
    function showSuccess(input, errorElement) {
        input.classList.remove('error');
        input.classList.add('success');
        errorElement.textContent = '';
        input.setAttribute('aria-invalid', 'false');
    }

    /**
     * Validate full name field
     * @returns {boolean} True if valid
     */
    function validateFullName() {
        const value = fullNameInput.value.trim();
        
        if (value === '') {
            showError(fullNameInput, fullNameError, t.errorNameRequired || 'Full name is required');
            return false;
        }
        
        if (value.length < 2) {
            showError(fullNameInput, fullNameError, t.errorNameMin || 'Full name must be at least 2 characters');
            return false;
        }
        
        showSuccess(fullNameInput, fullNameError);
        return true;
    }

    /**
     * Validate email field
     * @returns {boolean} True if valid
     */
    function validateEmail() {
        const value = emailInput.value.trim();
        
        if (value === '') {
            showError(emailInput, emailError, t.errorEmailRequired || 'Email is required');
            return false;
        }
        
        if (!isValidEmail(value)) {
            showError(emailInput, emailError, t.errorEmailInvalid || 'Invalid email address');
            return false;
        }
        
        showSuccess(emailInput, emailError);
        return true;
    }

    /**
     * Validate message field
     * @returns {boolean} True if valid
     */
    function validateMessage() {
        const value = messageInput.value.trim();
        
        if (value === '') {
            showError(messageInput, messageError, t.errorMessageRequired || 'Message is required');
            return false;
        }
        
        if (value.length < 10) {
            showError(messageInput, messageError, t.errorMessageMin || 'Message must be at least 10 characters');
            return false;
        }
        
        showSuccess(messageInput, messageError);
        return true;
    }

    /**
     * Validate phone field (optional, but if provided must be reasonable)
     * @returns {boolean} True if valid
     */
    function validatePhone() {
        const value = phoneInput.value.trim();
        
        // Phone is optional, so empty is valid
        if (value === '') {
            showSuccess(phoneInput, phoneError);
            return true;
        }
        
        // If provided, basic validation
        if (value.length < 5 || value.length > 50) {
            showError(phoneInput, phoneError, 'Please enter a valid phone number');
            return false;
        }
        
        showSuccess(phoneInput, phoneError);
        return true;
    }

    /**
     * Validate subject field (optional)
     * @returns {boolean} True if valid
     */
    function validateSubject() {
        const value = subjectInput.value.trim();
        
        // Subject is optional
        if (value.length > 255) {
            showError(subjectInput, subjectError, 'Subject is too long');
            return false;
        }
        
        showSuccess(subjectInput, subjectError);
        return true;
    }

    /**
     * Validate entire form
     * @returns {boolean} True if all fields are valid
     */
    function validateForm() {
        const isFullNameValid = validateFullName();
        const isEmailValid = validateEmail();
        const isPhoneValid = validatePhone();
        const isSubjectValid = validateSubject();
        const isMessageValid = validateMessage();
        
        return isFullNameValid && isEmailValid && isPhoneValid && isSubjectValid && isMessageValid;
    }

    /**
     * Show form message (success or error)
     * @param {string} message - Message to display
     * @param {string} type - 'success' or 'error'
     */
    function showFormMessage(message, type) {
        formMessage.textContent = message;
        formMessage.className = 'form-message ' + type;
        formMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /**
     * Hide form message
     */
    function hideFormMessage() {
        formMessage.className = 'form-message';
        formMessage.textContent = '';
    }

    /**
     * Set loading state
     * @param {boolean} loading - True to show loading state
     */
    function setLoading(loading) {
        if (loading) {
            submitBtn.disabled = true;
            submitBtn.querySelector('.btn-text').style.display = 'none';
            submitBtn.querySelector('.btn-loading').style.display = 'block';
        } else {
            submitBtn.disabled = false;
            submitBtn.querySelector('.btn-text').style.display = 'block';
            submitBtn.querySelector('.btn-loading').style.display = 'none';
        }
    }

    /**
     * Handle form submission
     * @param {Event} e - Submit event
     */
    async function handleSubmit(e) {
        e.preventDefault();
        
        // Hide any previous messages
        hideFormMessage();
        
        // Validate form
        if (!validateForm()) {
            showFormMessage('Please fix the errors above.', 'error');
            
            // Focus on first error
            const firstError = form.querySelector('.error');
            if (firstError) {
                firstError.focus();
            }
            return;
        }
        
        // Prepare form data
        const formData = {
            full_name: fullNameInput.value.trim(),
            email: emailInput.value.trim(),
            phone: phoneInput.value.trim() || null,
            subject: subjectInput.value.trim() || null,
            message: messageInput.value.trim(),
            language_code: t.currentLang || 'en'
        };
        
        // Set loading state
        setLoading(true);
        
        try {
            // Submit form via AJAX
            const response = await fetch('/api/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                // Success!
                showFormMessage(
                    data.message || t.formSuccess || 'Thank you for your message!',
                    'success'
                );
                
                // Reset form
                form.reset();
                
                // Clear all validation states
                [fullNameInput, emailInput, phoneInput, subjectInput, messageInput].forEach(input => {
                    input.classList.remove('error', 'success');
                    input.removeAttribute('aria-invalid');
                });
                
                // Clear error messages
                [fullNameError, emailError, phoneError, subjectError, messageError].forEach(error => {
                    error.textContent = '';
                });
                
            } else {
                // Server-side validation errors
                if (data.errors) {
                    // Show field-specific errors
                    Object.keys(data.errors).forEach(field => {
                        const errorElement = document.getElementById(field + 'Error');
                        const inputElement = document.getElementById(field);
                        if (errorElement && inputElement) {
                            showError(inputElement, errorElement, data.errors[field]);
                        }
                    });
                }
                
                showFormMessage(
                    data.message || t.formError || 'Something went wrong.',
                    'error'
                );
            }
            
        } catch (error) {
            console.error('Form submission error:', error);
            showFormMessage(
                t.formError || 'An error occurred. Please try again later.',
                'error'
            );
        } finally {
            setLoading(false);
        }
    }

    // Event Listeners
    if (form) {
        // Form submission
        form.addEventListener('submit', handleSubmit);
        
        // Real-time validation on blur
        fullNameInput.addEventListener('blur', validateFullName);
        emailInput.addEventListener('blur', validateEmail);
        phoneInput.addEventListener('blur', validatePhone);
        subjectInput.addEventListener('blur', validateSubject);
        messageInput.addEventListener('blur', validateMessage);
        
        // Clear error on input
        fullNameInput.addEventListener('input', function() {
            if (fullNameError.textContent) {
                validateFullName();
            }
        });
        
        emailInput.addEventListener('input', function() {
            if (emailError.textContent) {
                validateEmail();
            }
        });
        
        phoneInput.addEventListener('input', function() {
            if (phoneError.textContent) {
                validatePhone();
            }
        });
        
        subjectInput.addEventListener('input', function() {
            if (subjectError.textContent) {
                validateSubject();
            }
        });
        
        messageInput.addEventListener('input', function() {
            if (messageError.textContent) {
                validateMessage();
            }
        });
    }

})();

