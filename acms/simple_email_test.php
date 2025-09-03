<?php
// Simple Email Test with Debugging
require_once('config.php');
require_once('classes/EmailNotification.php');

echo "<h2>🔍 Email Debug Test</h2>";

// Check configuration
echo "<h3>Configuration Check:</h3>";
if (!defined('SMTP_HOST')) {
    echo "❌ email_config.php not loaded properly<br>";
    exit;
}

echo "✅ SMTP Host: " . SMTP_HOST . "<br>";
echo "✅ SMTP Port: " . SMTP_PORT . "<br>";
echo "✅ SMTP Username: " . SMTP_USERNAME . "<br>";
echo "✅ SMTP Password: " . (SMTP_PASSWORD === 'your-app-password' ? '❌ NOT CONFIGURED' : '✅ Configured') . "<br>";
echo "✅ Encryption: " . SMTP_ENCRYPTION . "<br><br>";

// Check if configuration is still using placeholders
if (SMTP_USERNAME === 'your-email@gmail.com' || SMTP_PASSWORD === 'your-app-password') {
    echo "<div style='background-color: #f8d7da; border: 1px solid #dc3545; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "<h3>❌ Configuration Issue</h3>";
    echo "<p><strong>You need to update your email credentials!</strong></p>";
    echo "<p>Please edit <code>email_config.php</code> and replace the placeholder values with your actual email details.</p>";
    echo "<p>See <a href='email_setup_guide.php'>Email Setup Guide</a> for detailed instructions.</p>";
    echo "</div>";
    exit;
}

// Test with your email (update this)
$test_email = 'your-email@gmail.com'; // CHANGE THIS TO YOUR EMAIL
$test_subject = 'ACMS Email Test - ' . date('Y-m-d H:i:s');
$test_message = '<h3>Test Email from ACMS</h3><p>If you receive this email, your configuration is working correctly!</p><p>Time: ' . date('Y-m-d H:i:s') . '</p>';

echo "<h3>Testing Email Sending:</h3>";
echo "Sending test email to: <strong>$test_email</strong><br>";
echo "Subject: $test_subject<br><br>";

try {
    $emailNotification = new EmailNotification();
    
    // Test basic email sending
    $result = $emailNotification->sendEmail($test_email, $test_subject, $test_message);
    
    if ($result) {
        echo "<div style='background-color: #d4edda; border: 1px solid #28a745; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
        echo "<h3>✅ Email Sent Successfully!</h3>";
        echo "<p>Check your email inbox (and spam folder) for the test email.</p>";
        echo "<p>If you don't receive it within 2-3 minutes, check the troubleshooting section below.</p>";
        echo "</div>";
    } else {
        echo "<div style='background-color: #f8d7da; border: 1px solid #dc3545; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
        echo "<h3>❌ Email Sending Failed</h3>";
        echo "<p>Please check the following:</p>";
        echo "<ul>";
        echo "<li>Your email credentials in email_config.php</li>";
        echo "<li>Your internet connection</li>";
        echo "<li>Check XAMPP error logs for more details</li>";
        echo "</ul>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div style='background-color: #f8d7da; border: 1px solid #dc3545; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "<h3>❌ Error: " . $e->getMessage() . "</h3>";
    echo "</div>";
}

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Make sure you updated the test email address in this script to your own email</li>";
echo "<li>Check your email inbox and spam folder</li>";
echo "<li>If working, test the full system by creating a shipment</li>";
echo "</ol>";

echo "<p><a href='email_setup_guide.php'>📖 View Complete Setup Guide</a></p>";
echo "<p><a href='test_email.php'>🧪 Run Full Email Test</a></p>";
?>
