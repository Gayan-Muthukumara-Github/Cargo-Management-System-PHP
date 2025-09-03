<?php
// Test script for email functionality
// This script can be used to test email notifications

require_once('config.php');
require_once('classes/EmailNotification.php');

echo "<h2>Email Notification Test</h2>";

// Check if email configuration is set up
if (!defined('SMTP_HOST') || SMTP_HOST === 'smtp.gmail.com' && SMTP_USERNAME === 'your-email@gmail.com') {
    echo "<div style='background-color: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "<h3>⚠️ Email Configuration Required</h3>";
    echo "<p>Please update the email settings in <strong>email_config.php</strong> before testing:</p>";
    echo "<ul>";
    echo "<li>Set your SMTP server details</li>";
    echo "<li>Set your email username and password</li>";
    echo "<li>For Gmail, use an App Password instead of your regular password</li>";
    echo "</ul>";
    echo "<p><strong>Instructions:</strong></p>";
    echo "<ol>";
    echo "<li>Open <code>email_config.php</code></li>";
    echo "<li>Update the SMTP settings with your email provider details</li>";
    echo "<li>For Gmail: Enable 2FA and create an App Password</li>";
    echo "<li>Save the file and refresh this page</li>";
    echo "</ol>";
    echo "</div>";
    exit;
}

// Test data - Update these email addresses to your own for testing
$test_cargo_data = array(
    'ref_code' => 'TEST001',
    'sender_name' => 'John Doe',
    'sender_email' => 'your-test-email@gmail.com', // Change this to your email
    'receiver_name' => 'Jane Smith',
    'receiver_email' => 'your-test-email@gmail.com', // Change this to your email
    'from_location' => 'New York, NY',
    'to_location' => 'Los Angeles, CA',
    'shipping_type' => '2',
    'total_amount' => 150.00
);

echo "<div style='background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
echo "<h3>📧 Testing Email Configuration</h3>";
echo "<p><strong>SMTP Host:</strong> " . SMTP_HOST . "</p>";
echo "<p><strong>SMTP Port:</strong> " . SMTP_PORT . "</p>";
echo "<p><strong>SMTP Username:</strong> " . SMTP_USERNAME . "</p>";
echo "<p><strong>Encryption:</strong> " . SMTP_ENCRYPTION . "</p>";
echo "</div>";

echo "<p><strong>Note:</strong> Make sure to update the test email addresses in this script to your own email address for testing.</p>";

try {
    $emailNotification = new EmailNotification();
    
    echo "<h3>Testing Shipment Created Notification:</h3>";
    $result1 = $emailNotification->sendShipmentCreatedNotification($test_cargo_data);
    echo $result1 ? "✅ Shipment created email sent successfully!" : "❌ Failed to send shipment created email";
    
    echo "<br><br><h3>Testing Status Update Notification:</h3>";
    $result2 = $emailNotification->sendStatusUpdateNotification($test_cargo_data, '1', 'Your shipment is now in transit.');
    echo $result2 ? "✅ Status update email sent successfully!" : "❌ Failed to send status update email";
    
    if ($result1 && $result2) {
        echo "<br><br><div style='background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
        echo "<h3>🎉 Email Test Successful!</h3>";
        echo "<p>Check your email inbox for the test emails. If you don't receive them, check your spam folder.</p>";
        echo "</div>";
    } else {
        echo "<br><br><div style='background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
        echo "<h3>❌ Email Test Failed</h3>";
        echo "<p>Please check:</p>";
        echo "<ul>";
        echo "<li>Your SMTP settings in email_config.php</li>";
        echo "<li>Your email credentials (username/password)</li>";
        echo "<li>Your internet connection</li>";
        echo "<li>Check the error logs for more details</li>";
        echo "</ul>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<br><br><div style='background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "<h3>❌ Error: " . $e->getMessage() . "</h3>";
    echo "</div>";
}

echo "<br><br><p><strong>Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Update the test email addresses in this script to your own email</li>";
echo "<li>Configure your email settings in email_config.php</li>";
echo "<li>Test the email functionality</li>";
echo "<li>Once working, the system will automatically send emails when shipments are created or status is updated</li>";
echo "</ol>";
?>
