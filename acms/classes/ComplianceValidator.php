<?php
require_once('DBConnection.php');

class ComplianceValidator extends DBConnection {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Validate cargo against all compliance rules
     */
    public function validateCargo($cargo_id, $cargo_data = []) {
        $violations = [];
        $warnings = [];
        
        // Get cargo details if not provided
        if (empty($cargo_data)) {
            $cargo_data = $this->getCargoData($cargo_id);
        }
        
        if (!$cargo_data) {
            return ['violations' => [], 'warnings' => [], 'status' => 'error'];
        }
        
        // Check perishable goods storage time
        $perishable_check = $this->checkPerishableStorage($cargo_id, $cargo_data);
        if ($perishable_check['violation']) {
            $violations[] = $perishable_check;
        } elseif ($perishable_check['warning']) {
            $warnings[] = $perishable_check;
        }
        
        // Check hazardous materials approval
        $hazardous_check = $this->checkHazardousApproval($cargo_id, $cargo_data);
        if ($hazardous_check['violation']) {
            $violations[] = $hazardous_check;
        }
        
        // Check weight/size restrictions
        $weight_check = $this->checkWeightRestrictions($cargo_id, $cargo_data);
        if ($weight_check['violation']) {
            $violations[] = $weight_check;
        } elseif ($weight_check['warning']) {
            $warnings[] = $weight_check;
        }
        
        $size_check = $this->checkSizeRestrictions($cargo_id, $cargo_data);
        if ($size_check['violation']) {
            $violations[] = $size_check;
        } elseif ($size_check['warning']) {
            $warnings[] = $size_check;
        }
        
        // Determine overall compliance status
        $status = 'compliant';
        if (!empty($violations)) {
            $status = 'non_compliant';
        } elseif (!empty($warnings)) {
            $status = 'requires_approval';
        }
        
        // Log compliance check
        $this->logComplianceCheck($cargo_id, $violations, $warnings, $status);
        
        return [
            'violations' => $violations,
            'warnings' => $warnings,
            'status' => $status
        ];
    }
    
    /**
     * Check perishable goods storage time limits
     */
    private function checkPerishableStorage($cargo_id, $cargo_data) {
        if (!$cargo_data['is_perishable'] || !$cargo_data['storage_start_time']) {
            return ['violation' => false, 'warning' => false];
        }
        
        $rule = $this->getComplianceRule('perishable_time');
        if (!$rule) {
            return ['violation' => false, 'warning' => false];
        }
        
        $config = json_decode($rule['rule_value'], true);
        $max_hours = $config['max_hours'] ?? 48;
        $alert_hours = $config['alert_hours'] ?? 36;
        
        $storage_start = new DateTime($cargo_data['storage_start_time']);
        $now = new DateTime();
        $hours_stored = $now->diff($storage_start)->h + ($now->diff($storage_start)->days * 24);
        
        if ($hours_stored > $max_hours) {
            return [
                'violation' => true,
                'type' => 'perishable_time',
                'message' => "Perishable cargo exceeded maximum storage time ({$max_hours} hours). Current: {$hours_stored} hours.",
                'severity' => 'critical'
            ];
        } elseif ($hours_stored > $alert_hours) {
            return [
                'warning' => true,
                'type' => 'perishable_time',
                'message' => "Perishable cargo approaching storage limit. {$hours_stored}/{$max_hours} hours used.",
                'severity' => 'medium'
            ];
        }
        
        return ['violation' => false, 'warning' => false];
    }
    
    /**
     * Check hazardous materials approval requirements
     */
    private function checkHazardousApproval($cargo_id, $cargo_data) {
        if (!$cargo_data['is_hazardous']) {
            return ['violation' => false, 'warning' => false];
        }
        
        $rule = $this->getComplianceRule('hazardous_approval');
        if (!$rule) {
            return ['violation' => false, 'warning' => false];
        }
        
        $config = json_decode($rule['rule_value'], true);
        $required_docs = $config['required_docs'] ?? ['msds', 'safety_cert'];
        
        $approvals = $this->getHazardousApprovals($cargo_id);
        $missing_docs = [];
        
        foreach ($required_docs as $doc_type) {
            $has_approval = false;
            foreach ($approvals as $approval) {
                if ($approval['approval_type'] === $doc_type && $approval['approval_status'] === 'approved') {
                    $has_approval = true;
                    break;
                }
            }
            if (!$has_approval) {
                $missing_docs[] = $doc_type;
            }
        }
        
        if (!empty($missing_docs)) {
            return [
                'violation' => true,
                'type' => 'hazardous_approval',
                'message' => "Hazardous cargo missing required approvals: " . implode(', ', $missing_docs),
                'severity' => 'high'
            ];
        }
        
        return ['violation' => false, 'warning' => false];
    }
    
    /**
     * Check weight restrictions
     */
    private function checkWeightRestrictions($cargo_id, $cargo_data) {
        if (!$cargo_data['weight_kg']) {
            return ['violation' => false, 'warning' => false];
        }
        
        $rule = $this->getComplianceRule('weight_limit');
        if (!$rule) {
            return ['violation' => false, 'warning' => false];
        }
        
        $config = json_decode($rule['rule_value'], true);
        $max_weight = $config['max_weight_kg'] ?? 1000;
        $warning_weight = $config['warning_weight_kg'] ?? 800;
        
        if ($cargo_data['weight_kg'] > $max_weight) {
            return [
                'violation' => true,
                'type' => 'weight_limit',
                'message' => "Cargo weight ({$cargo_data['weight_kg']}kg) exceeds maximum limit ({$max_weight}kg).",
                'severity' => 'high'
            ];
        } elseif ($cargo_data['weight_kg'] > $warning_weight) {
            return [
                'warning' => true,
                'type' => 'weight_limit',
                'message' => "Cargo weight ({$cargo_data['weight_kg']}kg) is approaching limit. Special handling may be required.",
                'severity' => 'medium'
            ];
        }
        
        return ['violation' => false, 'warning' => false];
    }
    
    /**
     * Check size restrictions
     */
    private function checkSizeRestrictions($cargo_id, $cargo_data) {
        if (!$cargo_data['length_cm'] || !$cargo_data['width_cm'] || !$cargo_data['height_cm']) {
            return ['violation' => false, 'warning' => false];
        }
        
        $rule = $this->getComplianceRule('size_limit');
        if (!$rule) {
            return ['violation' => false, 'warning' => false];
        }
        
        $config = json_decode($rule['rule_value'], true);
        $max_length = $config['max_length_cm'] ?? 300;
        $max_width = $config['max_width_cm'] ?? 200;
        $max_height = $config['max_height_cm'] ?? 150;
        
        $violations = [];
        if ($cargo_data['length_cm'] > $max_length) {
            $violations[] = "length ({$cargo_data['length_cm']}cm > {$max_length}cm)";
        }
        if ($cargo_data['width_cm'] > $max_width) {
            $violations[] = "width ({$cargo_data['width_cm']}cm > {$max_width}cm)";
        }
        if ($cargo_data['height_cm'] > $max_height) {
            $violations[] = "height ({$cargo_data['height_cm']}cm > {$max_height}cm)";
        }
        
        if (!empty($violations)) {
            return [
                'violation' => true,
                'type' => 'size_limit',
                'message' => "Cargo dimensions exceed limits: " . implode(', ', $violations),
                'severity' => 'high'
            ];
        }
        
        return ['violation' => false, 'warning' => false];
    }
    
    /**
     * Get cargo data for validation
     */
    private function getCargoData($cargo_id) {
        $sql = "SELECT cl.*, 
                       GROUP_CONCAT(DISTINCT ci.cargo_type_id) as cargo_type_ids,
                       GROUP_CONCAT(DISTINCT ctl.is_perishable) as is_perishable_types,
                       GROUP_CONCAT(DISTINCT ctl.is_hazardous) as is_hazardous_types
                FROM cargo_list cl
                LEFT JOIN cargo_items ci ON ci.cargo_id = cl.id
                LEFT JOIN cargo_type_list ctl ON ctl.id = ci.cargo_type_id
                WHERE cl.id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cargo_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            // Determine if any cargo type is perishable or hazardous
            $row['is_perishable'] = (strpos($row['is_perishable_types'], '1') !== false) ? 1 : 0;
            $row['is_hazardous'] = (strpos($row['is_hazardous_types'], '1') !== false) ? 1 : 0;
            
            return $row;
        }
        
        return false;
    }
    
    /**
     * Get compliance rule by type
     */
    private function getComplianceRule($rule_type) {
        $sql = "SELECT * FROM compliance_rules WHERE rule_type = ? AND is_active = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $rule_type);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Get hazardous material approvals for cargo
     */
    private function getHazardousApprovals($cargo_id) {
        $sql = "SELECT * FROM hazardous_approvals WHERE cargo_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cargo_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $approvals = [];
        while ($row = $result->fetch_assoc()) {
            $approvals[] = $row;
        }
        
        return $approvals;
    }
    
    /**
     * Log compliance check results
     */
    private function logComplianceCheck($cargo_id, $violations, $warnings, $status) {
        $check_type = 'full_validation';
        $check_status = (!empty($violations)) ? 'failed' : ((!empty($warnings)) ? 'warning' : 'passed');
        $check_details = json_encode(['violations' => $violations, 'warnings' => $warnings]);
        
        $sql = "INSERT INTO compliance_checks (cargo_id, check_type, check_status, check_details) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isss", $cargo_id, $check_type, $check_status, $check_details);
        $stmt->execute();
        
        // Update cargo compliance status
        $this->updateCargoComplianceStatus($cargo_id, $status);
        
        // Create violation records
        $this->createViolationRecords($cargo_id, $violations);
    }
    
    /**
     * Update cargo compliance status
     */
    private function updateCargoComplianceStatus($cargo_id, $status) {
        $sql = "UPDATE cargo_list SET compliance_status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $status, $cargo_id);
        $stmt->execute();
    }
    
    /**
     * Create violation records
     */
    private function createViolationRecords($cargo_id, $violations) {
        foreach ($violations as $violation) {
            $rule_id = $this->getRuleIdByType($violation['type']);
            if (!$rule_id) continue;
            
            $sql = "INSERT INTO compliance_violations 
                    (cargo_id, rule_id, violation_type, violation_message, severity) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iisss", $cargo_id, $rule_id, $violation['type'], 
                            $violation['message'], $violation['severity']);
            $stmt->execute();
        }
    }
    
    /**
     * Get rule ID by type
     */
    private function getRuleIdByType($rule_type) {
        $sql = "SELECT id FROM compliance_rules WHERE rule_type = ? AND is_active = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $rule_type);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['id'];
        }
        
        return null;
    }
    
    /**
     * Check for expired perishable goods (cron job)
     */
    public function checkExpiredPerishables() {
        $sql = "SELECT cl.id, cl.ref_code, cl.storage_start_time, cl.max_storage_hours
                FROM cargo_list cl
                WHERE cl.is_perishable = 1 
                AND cl.storage_start_time IS NOT NULL
                AND cl.compliance_status != 'non_compliant'
                AND cl.status IN (0, 1, 2)";
        
        $result = $this->conn->query($sql);
        $expired = [];
        
        while ($row = $result->fetch_assoc()) {
            $max_hours = $row['max_storage_hours'] ?? 48;
            $storage_start = new DateTime($row['storage_start_time']);
            $now = new DateTime();
            $hours_stored = $now->diff($storage_start)->h + ($now->diff($storage_start)->days * 24);
            
            if ($hours_stored > $max_hours) {
                $expired[] = $row;
                // Re-validate to create violation
                $this->validateCargo($row['id']);
            }
        }
        
        return $expired;
    }
    
    /**
     * Get compliance dashboard data
     */
    public function getComplianceDashboard() {
        $data = [];
        
        // Check if compliance tables exist
        $tables_exist = $this->checkComplianceTables();
        
        if (!$tables_exist) {
            // Return empty data if tables don't exist
            return [
                'violations_by_severity' => ['critical' => 0, 'high' => 0, 'medium' => 0, 'low' => 0],
                'pending_approvals' => 0,
                'compliance_status' => ['compliant' => 0, 'non_compliant' => 0, 'requires_approval' => 0, 'pending' => 0]
            ];
        }
        
        // Total violations by severity
        $sql = "SELECT severity, COUNT(*) as count 
                FROM compliance_violations 
                WHERE status = 'open' 
                GROUP BY severity";
        $result = $this->conn->query($sql);
        $data['violations_by_severity'] = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data['violations_by_severity'][$row['severity']] = $row['count'];
            }
        }
        
        // Pending hazardous approvals
        $sql = "SELECT COUNT(*) as count 
                FROM hazardous_approvals 
                WHERE approval_status = 'pending'";
        $result = $this->conn->query($sql);
        $data['pending_approvals'] = $result ? $result->fetch_assoc()['count'] : 0;
        
        // Compliance status distribution
        $sql = "SELECT compliance_status, COUNT(*) as count 
                FROM cargo_list 
                GROUP BY compliance_status";
        $result = $this->conn->query($sql);
        $data['compliance_status'] = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data['compliance_status'][$row['compliance_status']] = $row['count'];
            }
        }
        
        return $data;
    }
    
    /**
     * Check if compliance tables exist
     */
    private function checkComplianceTables() {
        $tables = ['compliance_violations', 'hazardous_approvals', 'compliance_rules'];
        foreach ($tables as $table) {
            $result = $this->conn->query("SHOW TABLES LIKE '$table'");
            if (!$result || $result->num_rows == 0) {
                return false;
            }
        }
        return true;
    }
}
