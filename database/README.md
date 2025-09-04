# Database Structure for Teatar za tebe

This directory contains the complete database schema and migration scripts for the Teatar za tebe application.

## Database Schema

### Tables Overview

1. **languages** - Supported languages (en, mk, fr)
2. **users** - User accounts and authentication
3. **user_sessions** - Session management
4. **events** - Main event data
5. **event_translations** - Multilingual event content
6. **blog_posts** - Blog post data
7. **blog_post_translations** - Multilingual blog content
8. **transactions** - Booking transactions
9. **translations** - Static content translations

### Key Features

- **Multilingual Support**: All content supports English, Macedonian, and French
- **User Management**: Admin, editor, and user roles
- **Session Management**: Database-backed sessions for scalability
- **Blog System**: Full blog functionality with translations
- **Transaction Tracking**: Complete booking and payment tracking
- **Content Management**: Dynamic translations for static content

## Setup Instructions

### 1. Database Configuration

Create a `.env` file in the project root with your database credentials:

```env
DB_HOST=localhost
DB_NAME=teatar_zatebe
DB_USER=root
DB_PASS=your_password
```

### 2. Run Migration

Execute the migration script to create the database and migrate existing data:

```bash
php database/migrate.php
```

This will:
- Create the database if it doesn't exist
- Create all tables with proper relationships
- Insert default languages and admin user
- Migrate existing events and transactions from JSON files
- Insert default translations

### 3. Default Admin Account

After migration, you can log in with:
- **Email**: admin@teatarzatebe.mk
- **Password**: admin123

## Database Connection Methods

### Method 1: PDO Bootstrap (Recommended)

For simple, direct database access, use the PDO bootstrap:

```php
// Include the bootstrap file
$pdo = require_once __DIR__ . '/bootstrap.php';

// Now you can use $pdo for all database operations
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([1]);
$event = $stmt->fetch();
```

**Configuration**: The bootstrap uses environment variables with these defaults:
- Host: `127.0.0.1` (or `mysql` in Docker)
- Port: `3307` (or `3306` in Docker)
- Database: `teatar_zatebe`
- User: `tzt`
- Password: `tztpass`
- Charset: `utf8mb4`

**Docker Environment**: When running in Docker containers, the bootstrap automatically uses:
- Host: `mysql` (container name)
- Port: `3306` (internal container port)

### Method 2: DatabaseConnection Class

For more complex operations with additional features:

```php
require_once 'src/database/DatabaseConnection.php';

$db = new DatabaseConnection();
$db->connect();

// Your database operations here
$db->disconnect();
```

## Database Relationships

```
users (1) ←→ (many) blog_posts
users (1) ←→ (many) user_sessions
events (1) ←→ (many) event_translations
events (1) ←→ (many) transactions
blog_posts (1) ←→ (many) blog_post_translations
languages (1) ←→ (many) translations
languages (1) ←→ (many) event_translations
languages (1) ←→ (many) blog_post_translations
```

## Usage Examples

### Connecting to Database

#### Using PDO Bootstrap (Simple)
```php
$pdo = require_once __DIR__ . '/bootstrap.php';

// Simple query
$stmt = $pdo->query("SELECT COUNT(*) as total FROM events");
$result = $stmt->fetch();
echo "Total events: " . $result['total'];

// Prepared statement
$stmt = $pdo->prepare("SELECT * FROM events WHERE status = ?");
$stmt->execute(['published']);
$events = $stmt->fetchAll();
```

#### Using DatabaseConnection Class (Advanced)
```php
require_once 'src/database/DatabaseConnection.php';

$db = new DatabaseConnection();
$db->connect();

// Your database operations here
$db->disconnect();
```

### Working with Events

```php
require_once 'src/models/EventModel.php';

// Get events with translations
$events = $db->fetchAll("
    SELECT e.*, et.* 
    FROM events e 
    JOIN event_translations et ON e.id = et.event_id 
    WHERE et.language_code = ? AND e.status = 'published'
", ['en']);

foreach ($events as $eventData) {
    $event = new EventModel($eventData);
    echo $event->getTitle('en');
}
```

### Working with Blog Posts

```php
require_once 'src/models/BlogPostModel.php';

// Get published blog posts
$posts = $db->fetchAll("
    SELECT bp.*, bpt.* 
    FROM blog_posts bp 
    JOIN blog_post_translations bpt ON bp.id = bpt.blog_post_id 
    WHERE bpt.language_code = ? AND bp.status = 'published'
    ORDER BY bp.published_at DESC
", ['en']);
```

## Testing Database Connection

### Test PDO Bootstrap
Create a test file to verify your connection:

```php
<?php
// test_connection.php
try {
    $pdo = require_once __DIR__ . '/bootstrap.php';
    echo "✅ Connected successfully!";
    
    $stmt = $pdo->query("SELECT VERSION() as version");
    $result = $stmt->fetch();
    echo "MySQL Version: " . $result['version'];
} catch (Exception $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
```

### Docker Environment Testing
When using Docker containers, access the test at:
- **PHPMyAdmin**: `http://localhost:8081`
- **PHP Test**: `http://localhost:8080/test_docker_connection.php`

## Migration from JSON Files

The migration script automatically migrates your existing data:

- **events.json** → events + event_translations tables
- **transactions.json** → transactions table
- **i18n.php translations** → translations table

## Security Features

- **Password Hashing**: All passwords are hashed using bcrypt
- **SQL Injection Protection**: Prepared statements throughout
- **Session Security**: Database-backed sessions with expiration
- **Role-Based Access**: Admin, editor, and user roles

## Performance Optimizations

- **Indexes**: Proper indexing on frequently queried columns
- **Foreign Keys**: Referential integrity constraints
- **JSON Storage**: Efficient storage for flexible data structures
- **Connection Pooling**: Efficient database connection management

## Backup and Maintenance

### Backup Database

```bash
mysqldump -u username -p teatar_zatebe > backup.sql
```

### Restore Database

```bash
mysql -u username -p teatar_zatebe < backup.sql
```

## Troubleshooting

### Common Issues

1. **Connection Failed**: Check database credentials in `.env`
2. **Migration Errors**: Ensure MySQL user has CREATE DATABASE privileges
3. **Character Encoding**: Database uses utf8mb4 for full Unicode support
4. **PDO Driver Missing**: Install `pdo_mysql` extension for PHP

### Logs

Database errors are logged to PHP error log. Check your server's error log for details.

## Future Enhancements

- [ ] Add database indexes for better performance
- [ ] Implement database connection pooling
- [ ] Add database backup automation
- [ ] Create database monitoring and analytics
- [ ] Add soft delete functionality
- [ ] Implement database versioning system

