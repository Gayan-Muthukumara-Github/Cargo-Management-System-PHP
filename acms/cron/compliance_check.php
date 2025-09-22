<?php
/**
 * Compliance Check Cron Job
 * Run this script every 15 minutes to check for expired perishable goods
 * Add to crontab: */15 * * * * /usr/bin/php /path/to/acms/cron/compliance_check.php
 */

// Set the path to your application
$app_path = dirname(__DIR__);
require_once($app_path . '/config.php');
require_once($app_path . '/classes/ComplianceValidator.php');

// Set timezone
date_default_timezone_set('UTC');

// Log function
function logMessage($message) {
    $log_file = dirname(__FILE__) . '/compliance_check.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
}

try {
    logMessage("Starting compliance check cron job");
    
    $validator = new ComplianceValidator();
    
    // Check for expired perishable goods
    $expired = $validator->checkExpiredPerishables();
    
    if (!empty($expired)) {
        logMessage("Found " . count($expired) . " expired perishable cargo items");
        
        foreach ($expired as $item) {
            logMessage("Expired cargo: {$item['ref_code']} - stored for " . 
                      (new DateTime())->diff(new DateTime($item['storage_start_time']))->h . " hours");
        }
        
        // Send email notification to compliance officer
        sendComplianceAlert($expired);
    } else {
        logMessage("No expired perishable goods found");
    }
    
    // Check for pending hazardous approvals older than 24 hours
    checkPendingApprovals();
    
    logMessage("Compliance check completed successfully");
    
} catch (Exception $e) {
    logMessage("Error in compliance check: " . $e->getMessage());
}

/**
 * Send compliance alert email
 */
function sendComplianceAlert($expired_items) {
    global $conn;
    
    // Get compliance officer email (you can configure this in system settings)
    $settings_query = $conn->query("SELECT meta_value FROM system_info WHERE meta_field = 'compliance_email'");
    $compliance_email = $settings_query->fetch_assoc()['meta_value'] ?? 'admin@example.com';
    
    $subject = "URGENT: Expired Perishable Cargo Alert";
    $message = "The following perishable cargo items have exceeded their storage time limits:\n\n";
    
    foreach ($expired_items as $item) {
        $hours_stored = (new DateTime())->diff(new DateTime($item['storage_start_time']))->h;
        $message .= "Cargo Ref: {$item['ref_code']}\n";
        $message .= "Storage Time: {$hours_stored} hours (Limit: {$item['max_storage_hours']} hours)\n";
        $message .= "Status: CRITICAL - Immediate action required\n\n";
    }
    
    $message .= "Please take immediate action to process these items or contact the warehouse manager.\n\n";
    $message .= "This is an automated alert from the Cargo Management System.";
    
    // Send email (implement your email sending logic here)
    $headers = "From: noreply@cargosystem.com\r\n";
    $headers .= "Reply-To: admin@cargosystem.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    if (mail($compliance_email, $subject, $message, $headers)) {
        logMessage("Compliance alert email sent to: $compliance_email");
    } else {
        logMessage("Failed to send compliance alert email");
    }
}

/**
 * Check for pending hazardous approvals older than 24 hours
 */
function checkPendingApprovals() {
    global $conn;
    
    $sql = "SELECT ha.*, cl.ref_code 
            FROM hazardous_approvals ha
            LEFT JOIN cargo_list cl ON cl.id = ha.cargo_id
            WHERE ha.approval_status = 'pending' 
            AND ha.date_created < DATE_SUB(NOW(), INTERVAL 24 HOUR)";
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $pending_count = $result->num_rows;
        logMessage("Found $pending_count hazardous material approvals pending for over 24 hours");
        
                // Send reminder email
        $settings_query = $conn->query("SELECT meta_value FROM system_info WHERE meta_field = 'compliance_email'");
        $compliance_email = $settings_query->fetch_assoc()['meta_value'] ?? 'admin@example.com';
        
        $subject = "Reminder: Pending Hazardous Material Approvals";
        $message = "The following hazardous material approvals have been pending for over 24 hours:\n\n";
        
        while ($row = $result->fetch_assoc()) {
            $message .= "Cargo Ref: {$row['ref_code']}\n";
            $message .= "Approval Type: {$row['approval_type']}\n";
            $message .= "Submitted: {$row['date_created']}\n\n";
        }
        
        $message .= "Please review and process these approvals as soon as possible.\n\n";
        $message .= "This is an automated reminder from the Cargo Management System.";
        
        $headers = "From: noreply@cargosystem.com\r\n";
        $headers .= "Reply-To: admin@cargosystem.com\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        if (mail($compliance_email, $subject, $message, $headers)) {
            logMessage("Pending approvals reminder email sent to: $compliance_email");
        }
    }
}
?>
