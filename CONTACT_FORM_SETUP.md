# Contact Form Feature - Setup Guide

## Overview

The contact form feature is a complete, production-ready contact system with:

- ✅ Multi-language support (English, Macedonian, French)
- ✅ Client-side and server-side validation
- ✅ Accessible form controls (WCAG compliant)
- ✅ Responsive design
- ✅ AJAX form submission
- ✅ Email notifications to admin
- ✅ Database storage of messages
- ✅ Clean, documented code

## Architecture

### Backend Components

1. **Database Schema** (`database/schema.sql`)
   - `contact_messages` table with full message tracking
   - Status management (new, read, replied, archived)
   - Language tracking and metadata storage

2. **Interface** (`src/interfaces/ContactInterface.php`)
   - Type-safe contract for contact message objects
   - Getter methods for all message properties

3. **Model** (`src/models/ContactModel.php`)
   - Contact message data object
   - Helper methods for status checking
   - Array conversion and formatting

4. **Service** (`src/services/ContactService.php`)
   - Business logic for contact messages
   - Database operations (CRUD)
   - Validation
   - Email notification system
   - Statistics tracking

5. **API Endpoint** (`api/contact.php`)
   - POST endpoint for form submission
   - GET endpoint for admin message retrieval
   - JSON responses
   - Error handling

### Frontend Components

1. **Page Component** (`components/navbar/Contact.php`)
   - Semantic HTML5 form
   - Accessible form controls
   - Contact information display
   - Translation integration

2. **Styles** (`components/navbar/contact.css`)
   - Responsive design (mobile-first)
   - Modern, clean UI
   - Accessibility features
   - Dark mode support
   - Animation and transitions

3. **JavaScript** (`components/navbar/contact.js`)
   - Real-time validation
   - AJAX submission
   - Error handling
   - Success/error messaging
   - Keyboard navigation support

## Installation

### Step 1: Run Database Migration

Run the migration script to create the table and add translations:

```bash
# From Docker container
docker exec -it tzt-app php migrate_contact.php

# Or via web browser
# Navigate to: http://localhost/migrate_contact.php
```

### Step 2: Configure Email (Optional)

Set the admin email address for notifications:

```bash
# Set environment variable
export ADMIN_EMAIL="your-email@example.com"

# Or edit the ContactService.php file directly
```

### Step 3: Verify Installation

1. Visit `/contact` on your website
2. Fill out the form
3. Submit and verify success message
4. Check database for new entry

## Usage

### For Visitors

Simply navigate to `/contact` and fill out the form:
- Required fields: Full Name, Email, Message
- Optional fields: Phone, Subject

### For Administrators

View contact messages in the database:

```sql
-- Get all new messages
SELECT * FROM contact_messages WHERE status = 'new' ORDER BY created_at DESC;

-- Get message statistics
SELECT status, COUNT(*) as count FROM contact_messages GROUP BY status;
```

Or use the API (requires admin authentication):

```bash
# Get all messages
curl -X GET http://localhost/api/contact \
  -H "Cookie: YOUR_ADMIN_SESSION_COOKIE"

# Get messages by status
curl -X GET "http://localhost/api/contact?status=new" \
  -H "Cookie: YOUR_ADMIN_SESSION_COOKIE"
```

## API Reference

### Submit Contact Form

**Endpoint:** `POST /api/contact`

**Request Body:**
```json
{
  "full_name": "John Doe",
  "email": "john@example.com",
  "phone": "123-456-7890",
  "subject": "Booking Inquiry",
  "message": "I would like to book an event...",
  "language_code": "en"
}
```

**Success Response (201):**
```json
{
  "success": true,
  "message": "Thank you for your message! We will get back to you soon.",
  "message_id": 123
}
```

**Error Response (400):**
```json
{
  "success": false,
  "errors": {
    "email": "Invalid email format",
    "message": "Message is required"
  },
  "message": "Validation failed"
}
```

### Get Messages (Admin Only)

**Endpoint:** `GET /api/contact`

**Query Parameters:**
- `status` (optional): Filter by status (new, read, replied, archived)

**Response:**
```json
{
  "success": true,
  "count": 10,
  "messages": [
    {
      "id": 1,
      "full_name": "John Doe",
      "email": "john@example.com",
      "phone": "123-456-7890",
      "subject": "Booking Inquiry",
      "message": "I would like to book an event...",
      "status": "new",
      "language_code": "en",
      "created_at": "2025-10-13 10:30:00"
    }
  ]
}
```

## Database Schema

```sql
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
```

## Validation Rules

### Client-Side
- Full Name: Required, minimum 2 characters
- Email: Required, valid email format
- Phone: Optional, 5-50 characters if provided
- Subject: Optional, maximum 255 characters
- Message: Required, minimum 10 characters

### Server-Side
- Full Name: Required, 2-100 characters
- Email: Required, valid email format, max 255 characters
- Phone: Optional, max 50 characters
- Subject: Optional, max 255 characters
- Message: Required, 10-5000 characters

## Translations

All form labels, placeholders, and messages are translated into:
- **English (en)**: Default language
- **Macedonian (mk)**: Cyrillic script support
- **French (fr)**: Full French localization

Translation keys are stored in the `translations` table with prefix `contact_*`.

## Customization

### Change Form Fields

Edit `components/navbar/Contact.php` to add/remove fields.

### Change Validation Rules

Edit:
- Client-side: `components/navbar/contact.js`
- Server-side: `src/services/ContactService.php` → `validateFormData()`

### Change Styling

Edit `components/navbar/contact.css` to match your brand.

### Change Email Template

Edit `src/services/ContactService.php` → `sendAdminNotification()`

## Accessibility Features

- ✅ Semantic HTML5 elements
- ✅ ARIA labels and live regions
- ✅ Keyboard navigation support
- ✅ Focus indicators
- ✅ Error announcements for screen readers
- ✅ High contrast mode support
- ✅ Reduced motion support

## Security Features

- ✅ CSRF protection (via session)
- ✅ Input sanitization
- ✅ SQL injection prevention (prepared statements)
- ✅ XSS prevention (htmlspecialchars)
- ✅ Email validation
- ✅ Rate limiting ready (add as needed)

## Browser Support

- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Mobile browsers (iOS Safari, Chrome Android)

## Troubleshooting

### Form doesn't submit
- Check browser console for JavaScript errors
- Verify `/api/contact` endpoint is accessible
- Check database connection

### Email notifications not working
- Verify mail server configuration
- Check error logs
- Consider using PHPMailer library for production

### Translations not showing
- Run migration to populate translations table
- Clear any caching
- Verify language code in session

### Styling issues
- Clear browser cache
- Check CSS file is loaded
- Verify no CSS conflicts

## Future Enhancements

Potential improvements:
- Admin dashboard for managing messages
- Email templates with HTML formatting
- File attachment support
- reCAPTCHA integration
- Auto-reply functionality
- Message tagging and categorization
- Export to CSV/PDF
- Integration with CRM systems

## Support

For issues or questions, contact the development team or check the project documentation.

---

**Version:** 1.0.0  
**Last Updated:** October 13, 2025  
**Author:** Teatar za tebe Development Team

