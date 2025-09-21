<?php
/**
 * Contact Form Handler
 * Processes contact form submissions and sends emails to admin
 */

require_once('initialize.php');
require_once('email_config.php');
require_once('classes/SMTPMailer.php');

// Set content type to JSON
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    // Validate required fields
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    
    if (empty($subject)) {
        $errors[] = 'Subject is required';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    }
    
    // If there are validation errors, return them
    if (!empty($errors)) {
        echo json_encode([
            'success' => false, 
            'message' => 'Validation failed',
            'errors' => $errors
        ]);
        exit;
    }
    
    // Admin email (you can change this to your admin email)
    $admin_email = 'mglmuthukumara@gmail.com'; // Change this to your admin email
    
    // Create email content
    $email_subject = "New Contact Form Submission: " . $subject;
    
    $email_body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; padding: 20px; border-radius: 8px 8px 0 0; }
            .content { background: #f8fafc; padding: 20px; border-radius: 0 0 8px 8px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #374151; }
            .value { margin-top: 5px; }
            .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #6b7280; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2 style='margin: 0;'>New Contact Form Submission</h2>
                <p style='margin: 5px 0 0 0; opacity: 0.9;'>You have received a new message from your website contact form</p>
            </div>
            <div class='content'>
                <div class='field'>
                    <div class='label'>Name:</div>
                    <div class='value'>" . htmlspecialchars($name) . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>Email:</div>
                    <div class='value'>" . htmlspecialchars($email) . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>Phone:</div>
                    <div class='value'>" . htmlspecialchars($phone ?: 'Not provided') . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>Subject:</div>
                    <div class='value'>" . htmlspecialchars($subject) . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>Message:</div>
                    <div class='value' style='background: white; padding: 15px; border-radius: 5px; border-left: 4px solid #2563eb;'>" . nl2br(htmlspecialchars($message)) . "</div>
                </div>
                
                <div class='footer'>
                    <p>This message was sent from your website contact form on " . date('F j, Y \a\t g:i A') . "</p>
                    <p>You can reply directly to this email to respond to " . htmlspecialchars($name) . "</p>
                </div>
            </div>
        </div>
    </body>
    </html>";
    
    // Initialize SMTP Mailer
    $mailer = new SMTPMailer(
        SMTP_HOST,
        SMTP_PORT,
        SMTP_USERNAME,
        SMTP_PASSWORD,
        SMTP_ENCRYPTION
    );
    
    // Send email to admin
    $email_sent = $mailer->sendEmail(
        $admin_email,
        $email_subject,
        $email_body,
        FROM_EMAIL,
        FROM_NAME
    );
    
    if ($email_sent) {
        // Optional: Send auto-reply to the user
        $auto_reply_subject = "Thank you for contacting us - " . $subject;
        $auto_reply_body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white; padding: 20px; border-radius: 8px 8px 0 0; }
                .content { background: #f8fafc; padding: 20px; border-radius: 0 0 8px 8px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2 style='margin: 0;'>Thank You for Contacting Us!</h2>
                </div>
                <div class='content'>
                    <p>Dear " . htmlspecialchars($name) . ",</p>
                    <p>Thank you for reaching out to us. We have received your message regarding <strong>" . htmlspecialchars($subject) . "</strong> and will get back to you within 24 hours.</p>
                    <p>Your message:</p>
                    <div style='background: white; padding: 15px; border-radius: 5px; border-left: 4px solid #2563eb; margin: 15px 0;'>
                        " . nl2br(htmlspecialchars($message)) . "
                    </div>
                    <p>If you have any urgent inquiries, please don't hesitate to call us directly.</p>
                    <p>Best regards,<br>ACMS Team</p>
                </div>
            </div>
        </body>
        </html>";
        
        // Send auto-reply
        $mailer->sendEmail(
            $email,
            $auto_reply_subject,
            $auto_reply_body,
            FROM_EMAIL,
            FROM_NAME
        );
        
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for contacting us! We\'ll get back to you within 24 hours.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to send email. Please try again later.'
        ]);
    }
    
} catch (Exception $e) {
    error_log("Contact form error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again later.'
    ]);
}
?>
