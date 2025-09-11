<?php
require_once('../config.php');
require_once('../email_config.php');
require_once('SMTPMailer.php');

class EmailNotification extends DBConnection {
    private $settings;
    
    public function __construct() {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }
    
    public function __destruct() {
        parent::__destruct();
    }
    
    /**
     * Send email notification using SMTP
     * @param string $to Recipient email address
     * @param string $subject Email subject
     * @param string $message Email message content
     * @param string $from From email address (optional)
     * @return bool Success status
     */
    public function sendEmail($to, $subject, $message, $from = null) {
        if (empty($to) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        // SMTP Configuration from email_config.php
        $smtp_host = SMTP_HOST;
        $smtp_port = SMTP_PORT;
        $smtp_username = SMTP_USERNAME;
        $smtp_password = SMTP_PASSWORD;
        $smtp_encryption = SMTP_ENCRYPTION;
        
        if (empty($from)) {
            $from = $this->settings->info('name') . ' <' . $smtp_username . '>';
        }
        
        // Try to use PHPMailer if available, otherwise use SMTPMailer, then fall back to basic mail()
        if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            return $this->sendEmailWithPHPMailer($to, $subject, $message, $from, $smtp_host, $smtp_port, $smtp_username, $smtp_password, $smtp_encryption);
        } else {
            // Use our custom SMTPMailer
            try {
                $smtpMailer = new SMTPMailer($smtp_host, $smtp_port, $smtp_username, $smtp_password, $smtp_encryption);
                $from_email = defined('FROM_EMAIL') ? FROM_EMAIL : $smtp_username;
                $from_name = defined('FROM_NAME') ? FROM_NAME : $this->settings->info('name');
                return $smtpMailer->sendEmail($to, $subject, $message, $from_email, $from_name);
            } catch (Exception $e) {
                error_log("SMTPMailer failed: " . $e->getMessage());
                
                // Fallback to basic mail() with better headers
                $headers = array(
                    'From: ' . $from,
                    'Reply-To: ' . $from,
                    'X-Mailer: PHP/' . phpversion(),
                    'MIME-Version: 1.0',
                    'Content-Type: text/html; charset=UTF-8'
                );
                
                $headers_string = implode("\r\n", $headers);
                
                // Try to send email
                $result = @mail($to, $subject, $message, $headers_string);
                
                // If mail() fails, log the error but don't break the application
                if (!$result) {
                    error_log("Email sending failed for: $to");
                }
                
                return $result;
            }
        }
    }
    
    /**
     * Send email using PHPMailer (if available)
     */
    private function sendEmailWithPHPMailer($to, $subject, $message, $from, $smtp_host, $smtp_port, $smtp_username, $smtp_password, $smtp_encryption) {
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = $smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_username;
            $mail->Password = $smtp_password;
            $mail->SMTPSecure = $smtp_encryption;
            $mail->Port = $smtp_port;
            
            // Recipients
            $mail->setFrom($smtp_username, $this->settings->info('name'));
            $mail->addAddress($to);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("PHPMailer Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send shipment creation notification
     * @param array $cargo_data Cargo information
     * @return bool Success status
     */
    public function sendShipmentCreatedNotification($cargo_data) {
        $sender_email = $cargo_data['sender_email'] ?? '';
        $receiver_email = $cargo_data['receiver_email'] ?? '';
        
        $subject = "Shipment Created - Reference: " . $cargo_data['ref_code'];
        
        // Sender notification
        if (!empty($sender_email)) {
            $sender_message = $this->getShipmentCreatedTemplate($cargo_data, 'sender');
            $this->sendEmail($sender_email, $subject, $sender_message);
        }
        
        // Receiver notification
        if (!empty($receiver_email)) {
            $receiver_message = $this->getShipmentCreatedTemplate($cargo_data, 'receiver');
            $this->sendEmail($receiver_email, $subject, $receiver_message);
        }
        
        return true;
    }
    
    /**
     * Send shipment status update notification
     * @param array $cargo_data Cargo information
     * @param string $new_status New status
     * @param string $remarks Status update remarks
     * @return bool Success status
     */
    public function sendStatusUpdateNotification($cargo_data, $new_status, $remarks = '') {
        $sender_email = $cargo_data['sender_email'] ?? '';
        $receiver_email = $cargo_data['receiver_email'] ?? '';
        
        $subject = "Shipment Status Update - Reference: " . $cargo_data['ref_code'];
        
        // Sender notification
        if (!empty($sender_email)) {
            $sender_message = $this->getStatusUpdateTemplate($cargo_data, $new_status, $remarks, 'sender');
            $this->sendEmail($sender_email, $subject, $sender_message);
        }
        
        // Receiver notification
        if (!empty($receiver_email)) {
            $receiver_message = $this->getStatusUpdateTemplate($cargo_data, $new_status, $remarks, 'receiver');
            $this->sendEmail($receiver_email, $subject, $receiver_message);
        }
        
        return true;
    }
    
    /**
     * Get shipment created email template
     * @param array $cargo_data Cargo information
     * @param string $recipient_type 'sender' or 'receiver'
     * @return string HTML email template
     */
    private function getShipmentCreatedTemplate($cargo_data, $recipient_type) {
        $company_name = $this->settings->info('name');
        $logo_url = base_url . $this->settings->info('logo');
        
        $recipient_name = ($recipient_type == 'sender') ? 
            ($cargo_data['sender_name'] ?? '') : 
            ($cargo_data['receiver_name'] ?? '');
            
        $shipping_type_text = $this->getShippingTypeText($cargo_data['shipping_type'] ?? '');
        
        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Shipment Created</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #007bff; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background-color: #f8f9fa; }
                .info-box { background-color: white; padding: 15px; margin: 10px 0; border-left: 4px solid #007bff; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
                .logo { max-height: 50px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <img src='{$logo_url}' alt='{$company_name}' class='logo'>
                    <h2>Shipment Created Successfully</h2>
                </div>
                
                <div class='content'>
                    <p>Dear " . ucwords($recipient_name) . ",</p>
                    
                    <p>Your shipment has been created successfully. Here are the details:</p>
                    
                    <div class='info-box'>
                        <h3>Shipment Information</h3>
                        <p><strong>Reference Code:</strong> " . ($cargo_data['ref_code'] ?? '') . "</p>
                        <p><strong>Shipping Type:</strong> {$shipping_type_text}</p>
                        <p><strong>Total Amount:$</strong> ₱" . number_format($cargo_data['total_amount'] ?? 0, 2) . "</p>
                        <p><strong>Date Created:</strong> " . date('F j, Y g:i A') . "</p>
                    </div>
                    
                    <div class='info-box'>
                        <h3>Route Information</h3>
                        <p><strong>From:</strong> " . ($cargo_data['from_location'] ?? '') . "</p>
                        <p><strong>To:</strong> " . ($cargo_data['to_location'] ?? '') . "</p>
                    </div>
                    
                    <p>You can track your shipment using the reference code: <strong>" . ($cargo_data['ref_code'] ?? '') . "</strong></p>
                    
                    <p>Thank you for choosing our services!</p>
                </div>
                
                <div class='footer'>
                    <p>This is an automated message from {$company_name}</p>
                    <p>Please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>";
        
        return $html;
    }
    
    /**
     * Get status update email template
     * @param array $cargo_data Cargo information
     * @param string $new_status New status
     * @param string $remarks Status update remarks
     * @param string $recipient_type 'sender' or 'receiver'
     * @return string HTML email template
     */
    private function getStatusUpdateTemplate($cargo_data, $new_status, $remarks, $recipient_type) {
        $company_name = $this->settings->info('name');
        $logo_url = base_url . $this->settings->info('logo');
        
        $recipient_name = ($recipient_type == 'sender') ? 
            ($cargo_data['sender_name'] ?? '') : 
            ($cargo_data['receiver_name'] ?? '');
            
        $status_text = $this->getStatusText($new_status);
        
        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Shipment Status Update</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #28a745; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background-color: #f8f9fa; }
                .status-box { background-color: white; padding: 15px; margin: 10px 0; border-left: 4px solid #28a745; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
                .logo { max-height: 50px; }
                .status-badge { display: inline-block; padding: 5px 15px; background-color: #28a745; color: white; border-radius: 20px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <img src='{$logo_url}' alt='{$company_name}' class='logo'>
                    <h2>Shipment Status Update</h2>
                </div>
                
                <div class='content'>
                    <p>Dear " . ucwords($recipient_name) . ",</p>
                    
                    <p>Your shipment status has been updated:</p>
                    
                    <div class='status-box'>
                        <h3>Shipment Information</h3>
                        <p><strong>Reference Code:</strong> " . ($cargo_data['ref_code'] ?? '') . "</p>
                        <p><strong>New Status:</strong> <span class='status-badge'>{$status_text}</span></p>
                        <p><strong>Update Time:</strong> " . date('F j, Y g:i A') . "</p>
                        " . (!empty($remarks) ? "<p><strong>Remarks:</strong> {$remarks}</p>" : "") . "
                    </div>
                    
                    <p>You can continue tracking your shipment using the reference code: <strong>" . ($cargo_data['ref_code'] ?? '') . "</strong></p>
                    
                    <p>Thank you for choosing our services!</p>
                </div>
                
                <div class='footer'>
                    <p>This is an automated message from {$company_name}</p>
                    <p>Please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>";
        
        return $html;
    }
    
    /**
     * Get shipping type text
     * @param string $shipping_type Shipping type code
     * @return string Shipping type text
     */
    private function getShippingTypeText($shipping_type) {
        switch($shipping_type) {
            case '1':
                return 'City to City';
            case '2':
                return 'State to State';
            case '3':
                return 'Country to Country';
            default:
                return 'N/A';
        }
    }
    
    /**
     * Get status text
     * @param string $status Status code
     * @return string Status text
     */
    private function getStatusText($status) {
        $status_lbl = ['Pending', 'In-Transit', 'Arrive at Station', 'Out for Delivery', 'Delivered'];
        return isset($status_lbl[$status]) ? $status_lbl[$status] : 'Unknown';
    }
}
