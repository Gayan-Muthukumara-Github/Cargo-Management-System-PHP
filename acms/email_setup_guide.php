<!DOCTYPE html>
<html>
<head>
    <title>Email Setup Guide</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .step { background-color: #f8f9fa; border-left: 4px solid #007bff; padding: 15px; margin: 10px 0; }
        .warning { background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 10px 0; }
        .success { background-color: #d4edda; border-left: 4px solid #28a745; padding: 15px; margin: 10px 0; }
        .error { background-color: #f8d7da; border-left: 4px solid #dc3545; padding: 15px; margin: 10px 0; }
        code { background-color: #e9ecef; padding: 2px 4px; border-radius: 3px; }
        pre { background-color: #e9ecef; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>📧 Email Setup Guide for ACMS</h1>
    
    <div class="warning">
        <h3>⚠️ Current Issue</h3>
        <p>You're not receiving emails because the email configuration still has placeholder values. You need to update <code>email_config.php</code> with your actual email credentials.</p>
    </div>

    <h2>Step-by-Step Setup Instructions</h2>

    <div class="step">
        <h3>Step 1: Choose Your Email Provider</h3>
        <p>We'll use Gmail as an example (most common). If you use a different provider, see the settings below.</p>
    </div>

    <div class="step">
        <h3>Step 2: Gmail Setup (Recommended)</h3>
        <ol>
            <li><strong>Enable 2-Factor Authentication</strong> on your Google account</li>
            <li><strong>Generate App Password</strong>:
                <ul>
                    <li>Go to <a href="https://myaccount.google.com/security" target="_blank">Google Account Security</a></li>
                    <li>Click on "App passwords" (under 2-Step Verification)</li>
                    <li>Select "Mail" and generate a password</li>
                    <li>Copy the 16-character password (like: abcd efgh ijkl mnop)</li>
                </ul>
            </li>
        </ol>
    </div>

    <div class="step">
        <h3>Step 3: Update email_config.php</h3>
        <p>Open <code>email_config.php</code> and update these lines:</p>
        <pre>
// Change this:
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');
define('FROM_EMAIL', 'your-email@gmail.com');

// To this (with your actual details):
define('SMTP_USERNAME', 'youremail@gmail.com');
define('SMTP_PASSWORD', 'abcd efgh ijkl mnop'); // Your 16-character app password
define('FROM_EMAIL', 'youremail@gmail.com');
        </pre>
    </div>

    <div class="step">
        <h3>Step 4: Test Email Configuration</h3>
        <ol>
            <li>Update the test email addresses in <code>test_email.php</code></li>
            <li>Run <code>test_email.php</code> in your browser</li>
            <li>Check your email inbox (and spam folder)</li>
        </ol>
    </div>

    <h2>Alternative Email Providers</h2>

    <div class="step">
        <h3>Outlook/Hotmail</h3>
        <pre>
define('SMTP_HOST', 'smtp-mail.outlook.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'youremail@outlook.com');
define('SMTP_PASSWORD', 'your-password');
define('SMTP_ENCRYPTION', 'tls');
        </pre>
    </div>

    <div class="step">
        <h3>Yahoo</h3>
        <pre>
define('SMTP_HOST', 'smtp.mail.yahoo.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'youremail@yahoo.com');
define('SMTP_PASSWORD', 'your-password');
define('SMTP_ENCRYPTION', 'tls');
        </pre>
    </div>

    <h2>Common Issues & Solutions</h2>

    <div class="error">
        <h3>❌ "Authentication failed"</h3>
        <ul>
            <li>For Gmail: Make sure you're using an App Password, not your regular password</li>
            <li>Check that 2-Factor Authentication is enabled</li>
            <li>Verify your email address is correct</li>
        </ul>
    </div>

    <div class="error">
        <h3>❌ "Connection refused"</h3>
        <ul>
            <li>Check your internet connection</li>
            <li>Verify SMTP host and port are correct</li>
            <li>Some networks block SMTP ports - try a different network</li>
        </ul>
    </div>

    <div class="error">
        <h3>❌ "Emails not received"</h3>
        <ul>
            <li>Check your spam/junk folder</li>
            <li>Make sure the recipient email address is correct</li>
            <li>Some email providers have delays</li>
        </ul>
    </div>

    <div class="success">
        <h3>✅ Quick Test</h3>
        <p>After updating your configuration, run this test:</p>
        <ol>
            <li>Open <code>test_email.php</code></li>
            <li>Change the test email addresses to your own email</li>
            <li>Run the test</li>
            <li>Check your inbox within 1-2 minutes</li>
        </ol>
    </div>

    <h2>Need Help?</h2>
    <p>If you're still having issues:</p>
    <ul>
        <li>Check the error logs in your XAMPP error log file</li>
        <li>Try a different email provider</li>
        <li>Make sure your firewall isn't blocking SMTP connections</li>
    </ul>

    <div class="step">
        <h3>🔧 Debug Information</h3>
        <p>Current configuration status:</p>
        <?php
        require_once('email_config.php');
        echo "<p><strong>SMTP Host:</strong> " . SMTP_HOST . "</p>";
        echo "<p><strong>SMTP Port:</strong> " . SMTP_PORT . "</p>";
        echo "<p><strong>SMTP Username:</strong> " . SMTP_USERNAME . "</p>";
        echo "<p><strong>SMTP Password:</strong> " . (SMTP_PASSWORD === 'your-app-password' ? '❌ Not configured' : '✅ Configured') . "</p>";
        echo "<p><strong>Encryption:</strong> " . SMTP_ENCRYPTION . "</p>";
        
        if (SMTP_USERNAME === 'your-email@gmail.com' || SMTP_PASSWORD === 'your-app-password') {
            echo "<div class='error'><p><strong>⚠️ Configuration Required:</strong> Please update your email credentials in email_config.php</p></div>";
        } else {
            echo "<div class='success'><p><strong>✅ Configuration looks good!</strong> Try running the test now.</p></div>";
        }
        ?>
    </div>
</body>
</html>
