<?php
/**
 * Simple SMTP Mailer Class
 * A lightweight SMTP email sender that doesn't require external libraries
 */

class SMTPMailer {
    private $smtp_host;
    private $smtp_port;
    private $smtp_username;
    private $smtp_password;
    private $smtp_encryption;
    private $socket;
    
    public function __construct($host, $port, $username, $password, $encryption = 'tls') {
        $this->smtp_host = $host;
        $this->smtp_port = $port;
        $this->smtp_username = $username;
        $this->smtp_password = $password;
        $this->smtp_encryption = $encryption;
    }
    
    public function sendEmail($to, $subject, $message, $from_email, $from_name) {
        try {
            // Debug: Log connection attempt
            error_log("SMTP: Attempting to connect to {$this->smtp_host}:{$this->smtp_port}");
            
            // Connect to SMTP server
            $this->socket = fsockopen($this->smtp_host, $this->smtp_port, $errno, $errstr, 30);
            if (!$this->socket) {
                $error_msg = "Failed to connect to SMTP server {$this->smtp_host}:{$this->smtp_port} - $errstr ($errno)";
                error_log("SMTP Error: $error_msg");
                throw new Exception($error_msg);
            }
            
            error_log("SMTP: Successfully connected to {$this->smtp_host}:{$this->smtp_port}");
            
            // Read initial response
            $this->readResponse();
            
            // Send EHLO command
            $this->sendCommand("EHLO " . $_SERVER['HTTP_HOST']);
            
            // Start TLS if required
            if ($this->smtp_encryption === 'tls') {
                $this->sendCommand("STARTTLS");
                stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
                $this->sendCommand("EHLO " . $_SERVER['HTTP_HOST']);
            }
            
            // Authenticate
            error_log("SMTP: Starting authentication for user: {$this->smtp_username}");
            $response = $this->sendCommand("AUTH LOGIN");
            if (strpos($response, '334') === false) {
                throw new Exception("AUTH LOGIN failed: $response");
            }
            
            $response = $this->sendCommand(base64_encode($this->smtp_username));
            if (strpos($response, '334') === false) {
                throw new Exception("Username authentication failed: $response");
            }
            
            $response = $this->sendCommand(base64_encode($this->smtp_password));
            if (strpos($response, '235') === false) {
                throw new Exception("Password authentication failed: $response");
            }
            
            error_log("SMTP: Authentication successful");
            
            // Set sender
            $this->sendCommand("MAIL FROM: <$from_email>");
            
            // Set recipient
            $this->sendCommand("RCPT TO: <$to>");
            
            // Send data
            $this->sendCommand("DATA");
            
            // Email headers and body
            $email_data = "From: $from_name <$from_email>\r\n";
            $email_data .= "To: $to\r\n";
            $email_data .= "Subject: $subject\r\n";
            $email_data .= "MIME-Version: 1.0\r\n";
            $email_data .= "Content-Type: text/html; charset=UTF-8\r\n";
            $email_data .= "\r\n";
            $email_data .= $message . "\r\n";
            $email_data .= ".\r\n";
            
            fwrite($this->socket, $email_data);
            $this->readResponse();
            
            // Quit
            $this->sendCommand("QUIT");
            
            fclose($this->socket);
            return true;
            
        } catch (Exception $e) {
            if ($this->socket) {
                fclose($this->socket);
            }
            error_log("SMTP Error: " . $e->getMessage());
            return false;
        }
    }
    
    private function sendCommand($command) {
        fwrite($this->socket, $command . "\r\n");
        return $this->readResponse();
    }
    
    private function readResponse() {
        $response = '';
        while (($line = fgets($this->socket, 515)) !== false) {
            $response .= $line;
            if (substr($line, 3, 1) == ' ') {
                break;
            }
        }
        return $response;
    }
}
?>
