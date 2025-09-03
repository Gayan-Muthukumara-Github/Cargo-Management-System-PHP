<?php
/**
 * Email Configuration
 * Update these settings according to your email provider
 */

// Email Configuration Settings
define('SMTP_HOST', 'smtp.gmail.com'); // Your SMTP server
define('SMTP_PORT', 587); // Your SMTP port (587 for TLS, 465 for SSL)
define('SMTP_USERNAME', 'mglmuthukumara@gmail.com'); // Your email address
define('SMTP_PASSWORD', 'ojrk jwla ndqt nshq'); // Your email password or app password
define('SMTP_ENCRYPTION', 'tls'); // 'tls' or 'ssl'
define('FROM_EMAIL', 'mglmuthukumara@gmail.com'); // From email address
define('FROM_NAME', 'ACMS System'); // From name

/**
 * Popular Email Provider Settings:
 * 
 * Gmail:
 * - Host: smtp.gmail.com
 * - Port: 587 (TLS) or 465 (SSL)
 * - Username: your-email@gmail.com
 * - Password: Use App Password (not your regular password)
 * - Encryption: tls or ssl
 * 
 * Outlook/Hotmail:
 * - Host: smtp-mail.outlook.com
 * - Port: 587
 * - Username: your-email@outlook.com
 * - Password: your password
 * - Encryption: tls
 * 
 * Yahoo:
 * - Host: smtp.mail.yahoo.com
 * - Port: 587 or 465
 * - Username: your-email@yahoo.com
 * - Password: your password
 * - Encryption: tls or ssl
 * 
 * Custom SMTP:
 * - Contact your hosting provider for SMTP settings
 */

// Instructions for Gmail App Password:
// 1. Enable 2-Factor Authentication on your Google account
// 2. Go to Google Account settings > Security > App passwords
// 3. Generate an app password for "Mail"
// 4. Use that app password instead of your regular password
?>
