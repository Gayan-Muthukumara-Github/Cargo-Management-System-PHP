<?php
require_once('../config.php');
require_once('inc/sess_auth.php');

if(!isset($_settings) || $_settings->userdata('login_type') != 1){
    die('Access denied');
}

// Deprecated: schema is optional in simple mode
$schema_file = '../database/compliance_schema.sql';
if (file_exists($schema_file)) {
    $sql = file_get_contents($schema_file);
    
    // Split by semicolon and execute each statement
    $statements = explode(';', $sql);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement) && !preg_match('/^--/', $statement)) {
            try {
                $conn->query($statement);
                echo "Executed: " . substr($statement, 0, 50) . "...<br>";
            } catch (Exception $e) {
                echo "Error executing statement: " . $e->getMessage() . "<br>";
            }
        }
    }
    
    echo "<br><strong>Compliance schema setup completed!</strong><br>";
    echo "<a href='?page=compliance'>Go to Compliance Dashboard</a>";
} else {
    echo "Schema file not found: $schema_file";
}
?>
