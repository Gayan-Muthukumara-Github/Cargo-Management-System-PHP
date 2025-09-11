<?php
require_once('../../config.php');
require_once('../inc/sess_auth.php');
require_once('../../classes/ComplianceValidator.php');

header('Content-Type: application/json');

if(!isset($_settings) || $_settings->userdata('type') != 1){
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

$action = $_REQUEST['action'] ?? '';

switch($action) {
    case 'get_violations':
        $severity = $_GET['severity'] ?? '';
        $status = $_GET['status'] ?? '';
        $cargo_ref = $_GET['cargo_ref'] ?? '';
        
        $where_conditions = [];
        $params = [];
        $types = '';
        
        if ($severity !== '') {
            $where_conditions[] = "cv.severity = ?";
            $params[] = $severity;
            $types .= 's';
        }
        
        if ($status !== '') {
            $where_conditions[] = "cv.status = ?";
            $params[] = $status;
            $types .= 's';
        }
        
        if ($cargo_ref !== '') {
            $where_conditions[] = "cl.ref_code LIKE ?";
            $params[] = '%' . $cargo_ref . '%';
            $types .= 's';
        }
        
        $where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';
        
        $sql = "SELECT cv.*, cl.ref_code as cargo_ref
                FROM compliance_violations cv
                LEFT JOIN cargo_list cl ON cl.id = cv.cargo_id
                $where_clause
                ORDER BY cv.date_created DESC
                LIMIT 100";
        
        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        $violations = [];
        while ($row = $result->fetch_assoc()) {
            $violations[] = $row;
        }
        
        echo json_encode(['data' => $violations]);
        break;
        
    case 'get_pending_approvals':
        $sql = "SELECT ha.*, cl.ref_code as cargo_ref
                FROM hazardous_approvals ha
                LEFT JOIN cargo_list cl ON cl.id = ha.cargo_id
                WHERE ha.approval_status = 'pending'
                ORDER BY ha.date_created DESC";
        
        $result = $conn->query($sql);
        $approvals = [];
        while ($row = $result->fetch_assoc()) {
            $approvals[] = $row;
        }
        
        echo json_encode(['data' => $approvals]);
        break;
        
    case 'resolve_violation':
        $violation_id = (int)($_POST['id'] ?? 0);
        $resolved_by = $_settings->userdata('id');
        
        if ($violation_id <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid violation ID']);
            break;
        }
        
        $sql = "UPDATE compliance_violations 
                SET status = 'resolved', resolved_by = ?, resolved_at = NOW() 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $resolved_by, $violation_id);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Violation resolved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to resolve violation']);
        }
        break;
        
    case 'approve_hazardous':
        $approval_id = (int)($_POST['id'] ?? 0);
        $approved_by = $_settings->userdata('id');
        
        if ($approval_id <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid approval ID']);
            break;
        }
        
        $sql = "UPDATE hazardous_approvals 
                SET approval_status = 'approved', approved_by = ?, approved_at = NOW() 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $approved_by, $approval_id);
        
        if ($stmt->execute()) {
            // Re-validate the cargo to update compliance status
            $cargo_sql = "SELECT cargo_id FROM hazardous_approvals WHERE id = ?";
            $cargo_stmt = $conn->prepare($cargo_sql);
            $cargo_stmt->bind_param("i", $approval_id);
            $cargo_stmt->execute();
            $cargo_result = $cargo_stmt->get_result();
            
            if ($cargo_row = $cargo_result->fetch_assoc()) {
                $validator = new ComplianceValidator();
                $validator->validateCargo($cargo_row['cargo_id']);
            }
            
            echo json_encode(['status' => 'success', 'message' => 'Approval granted']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to approve']);
        }
        break;
        
    case 'reject_hazardous':
        $approval_id = (int)($_POST['id'] ?? 0);
        $reason = $_POST['reason'] ?? '';
        $approved_by = $_settings->userdata('id');
        
        if ($approval_id <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid approval ID']);
            break;
        }
        
        $sql = "UPDATE hazardous_approvals 
                SET approval_status = 'rejected', approved_by = ?, approved_at = NOW(), approval_notes = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $approved_by, $reason, $approval_id);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Approval rejected']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to reject']);
        }
        break;
        
    case 'validate_cargo':
        $cargo_id = (int)($_POST['cargo_id'] ?? 0);
        
        if ($cargo_id <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid cargo ID']);
            break;
        }
        
        $validator = new ComplianceValidator();
        $result = $validator->validateCargo($cargo_id);
        
        echo json_encode(['status' => 'success', 'data' => $result]);
        break;
        
    case 'get_compliance_rules':
        $sql = "SELECT * FROM compliance_rules WHERE is_active = 1 ORDER BY rule_type, rule_name";
        $result = $conn->query($sql);
        
        $rules = [];
        while ($row = $result->fetch_assoc()) {
            $rules[] = $row;
        }
        
        echo json_encode(['data' => $rules]);
        break;
        
    case 'update_compliance_rule':
        $rule_id = (int)($_POST['rule_id'] ?? 0);
        $rule_value = $_POST['rule_value'] ?? '';
        
        if ($rule_id <= 0 || empty($rule_value)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
            break;
        }
        
        $sql = "UPDATE compliance_rules SET rule_value = ?, date_updated = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $rule_value, $rule_id);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Rule updated']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update rule']);
        }
        break;
        
    case 'check_expired_perishables':
        $validator = new ComplianceValidator();
        $expired = $validator->checkExpiredPerishables();
        
        echo json_encode(['status' => 'success', 'data' => $expired]);
        break;
        
    default:
        echo json_encode(['error' => 'Unknown action']);
}
