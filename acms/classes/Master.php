<?php
require_once('../config.php');
require_once('EmailNotification.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_cargo_type(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string(trim($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `cargo_type_list` where `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Cargo Type Name already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `cargo_type_list` set {$data} ";
		}else{
			$sql = "UPDATE `cargo_type_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Cargo Type successfully saved.";
			else
				$resp['msg'] = " Cargo Type successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_cargo_type(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `cargo_type_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Cargo Type successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_cargo(){
		if(empty($_POST['id'])){
			$pref = date("Ym");
			$code = sprintf("%'.05d",1);
			while(true){
				$check = $this->conn->query("SELECT * FROM `cargo_list` where ref_code = '{$pref}{$code}'")->num_rows;
				if($check > 0){
					$code = sprintf("%'.05d",ceil($code) + 1);
				}else{
					break;
				}
			}
			$_POST['ref_code'] = $pref.$code;
		}
		extract($_POST);
		// Ensure checkbox flags post defaults when unchecked
		$_POST['is_perishable'] = isset($_POST['is_perishable']) ? (int)!!$_POST['is_perishable'] : 0;
		$_POST['is_hazardous'] = isset($_POST['is_hazardous']) ? (int)!!$_POST['is_hazardous'] : 0;
		$_POST['special_handling_required'] = isset($_POST['special_handling_required']) ? (int)!!$_POST['special_handling_required'] : 0;
		// Normalize numeric fields
		$_POST['weight_kg'] = isset($_POST['weight_kg']) && $_POST['weight_kg'] !== '' ? (float)$_POST['weight_kg'] : 0;
		$_POST['length_cm'] = isset($_POST['length_cm']) && $_POST['length_cm'] !== '' ? (int)$_POST['length_cm'] : 0;
		$_POST['width_cm'] = isset($_POST['width_cm']) && $_POST['width_cm'] !== '' ? (int)$_POST['width_cm'] : 0;
		$_POST['height_cm'] = isset($_POST['height_cm']) && $_POST['height_cm'] !== '' ? (int)$_POST['height_cm'] : 0;
		$_POST['max_storage_hours'] = isset($_POST['max_storage_hours']) && $_POST['max_storage_hours'] !== '' ? (int)$_POST['max_storage_hours'] : null;
		// Auto-set storage_start_time if perishable and not provided
		if((int)$_POST['is_perishable'] === 1){
			if(empty($_POST['storage_start_time'])){
				$_POST['storage_start_time'] = date('Y-m-d H:i:s');
			}
		}else{
			// If not perishable, clear storage start time and max hours to avoid stale data
			$_POST['storage_start_time'] = null;
			if(isset($_POST['max_storage_hours']) && $_POST['max_storage_hours'] === '') $_POST['max_storage_hours'] = null;
		}
		
		// Fields to be stored directly in cargo_list
		$cargo_allowed_statuss = [
			"ref_code","shipping_type","total_amount","status",
			"is_hazardous","is_perishable","storage_start_time","max_storage_hours",
			"weight_kg","length_cm","width_cm","height_cm","special_handling_required"
		];
		$data = "";
		foreach($_POST as $k =>$v){
			if(in_array($k,$cargo_allowed_statuss)){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$this->conn->real_escape_string($v)}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `cargo_list` set {$data} ";
		}else{
			$sql = "UPDATE `cargo_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$cid = empty($id) ? $this->conn->insert_id : $id;
			// Run compliance validation and create records
			$this->validateCargoCompliance($cid);
			$resp['cid'] = $cid;
			if(empty($id))
				$resp['msg'] = " New Smart Phone successfully added.";
			else
				$resp['msg'] = " Smart Phone Details has been updated successfully.";
			$resp['status'] = 'success';
			$data="";
			foreach($_POST as $k =>$v){
				if(!in_array($k,array_merge($cargo_allowed_statuss,['id'])) && !is_array($_POST[$k]) ){
					if(!empty($data)) $data .=",";
					$data .= "('{$cid}', '{$this->conn->real_escape_string($k)}', '{$this->conn->real_escape_string($v)}')";
				}
			}
			if(!empty($data)){
				$this->conn->query("DELETE FROM `cargo_meta` where `cargo_id` = '{$cid}'");
				$sql2 = "INSERT INTO `cargo_meta` (`cargo_id`, `meta_field`, `meta_value`) VALUES {$data}";
				$save2 = $this->conn->query($sql2);
				if(!$save2){
					$resp['status'] = 'failed';
					$resp['msg'] = " Saving Transaction failed.";
					$resp['err'] = $this->conn->error;
					$resp['sql'] = $sql2;
					if(empty($id))
					$this->conn->query("DELETE FROM `cargo_list` where id = '{$cid}'");
				}
			}
			$data="";
			foreach($cargo_type_id as $k =>$v){
				if(empty(trim($v)))
				continue;
				if(!empty($data)) $data .=",";
				$data .= "('{$cid}', '{$this->conn->real_escape_string($v)}', '{$this->conn->real_escape_string($price[$k])}', '{$this->conn->real_escape_string($weight[$k])}', '{$this->conn->real_escape_string($total[$k])}')";
			}
			if(!empty($data)){
				$this->conn->query("DELETE FROM `cargo_items` where `cargo_id` = '{$cid}'");
				$sql3 = "INSERT INTO `cargo_items` (`cargo_id`, `cargo_type_id`, `price`, `weight`, `total`) VALUES {$data}";
				$save3 = $this->conn->query($sql3);
				if(!$save3){
					$resp['status'] = 'failed';
					$resp['msg'] = " Saving Transaction failed.";
					$resp['err'] = $this->conn->error;
					$resp['sql'] = $sql3;
					if(empty($id))
					$this->conn->query("DELETE FROM `cargo_list` where id = '{$cid}'");
				}
			}
			// if(empty($id)){
				$save_track = $this->add_track($cid,"Pending"," Shipment created.");
			// }

			// Attempt dynamic storage allocation on new cargo
			if(empty($id)){
				$allocated = $this->allocate_storage_for_cargo($cid);
				if(!$allocated){
					// Queue: no capacity available
					$this->add_track($cid,"Awaiting Storage","No available storage capacity. Shipment queued.");
					$resp['awaiting_storage'] = 1;
					$this->settings->set_flashdata('warning',"Shipment queued: awaiting storage capacity.");
				}
			}
			
			// Send email notifications for new shipments
			if(empty($id) && $resp['status'] == 'success'){
				$this->sendShipmentEmailNotification($cid);
			}
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_cargo(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `cargo_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," cargo successfully deleted.");
			if(is_dir(base_app."uploads/cargo_".$id)){
				$fopen = scandir(base_app."uploads/cargo_".$id);
				foreach($fopen as $file){
					if(!in_array($file,[".",".."])){
						unlink(base_app."uploads/cargo_".$id."/".$file);
					}
				}
				rmdir(base_app."uploads/cargo_".$id);
			}
			
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function update_cargo_type(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `cargo_list` set `status` = '{$status}' where id ='{$id}'");
		$status_lbl = ['Pending','In-Transit','Arrive at Station', 'Out for Delivery', 'Delivered'];
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = " Shipment Status has been updated.";
			$remarks = !empty($remarks) ? $remarks : "No remarks provided";
			$save_track = $this->add_track($id,$status_lbl[$status],$remarks);

			// If delivered, free allocated storage
			if(isset($status) && (int)$status === 4){
				$this->release_storage_for_cargo($id);
			}
			
			// Send email notification for status update
			if($resp['status'] == 'success'){
				$this->sendStatusUpdateEmailNotification($id, $status, $remarks);
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " Shipment Status has failed update.";
		}

		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
	}

	/**
	 * Dynamic Storage Allocation
	 */
    private function get_cargo_profile($cargo_id){
        // Derive profile from cargo_list row + cargo items
        $profile = [
            'type' => 'any',
            'weight' => 0,
            'length_cm' => 0,
            'width_cm' => 0,
            'height_cm' => 0,
            'priority' => 'normal',
            'refrigerated' => 0,
            'hazardous' => 0
        ];

        // Pull shipment-level flags and dimensions
        $cq = $this->conn->query("SELECT is_perishable, is_hazardous, weight_kg, length_cm, width_cm, height_cm FROM cargo_list WHERE id='{$cargo_id}' LIMIT 1");
        if($cq && $cq->num_rows){
            $C = $cq->fetch_assoc();
            $profile['weight'] = isset($C['weight_kg']) ? (float)$C['weight_kg'] : 0;
            $profile['length_cm'] = isset($C['length_cm']) ? (int)$C['length_cm'] : 0;
            $profile['width_cm'] = isset($C['width_cm']) ? (int)$C['width_cm'] : 0;
            $profile['height_cm'] = isset($C['height_cm']) ? (int)$C['height_cm'] : 0;
            $lvl_perishable = (int)($C['is_perishable'] ?? 0);
            $lvl_hazardous = (int)($C['is_hazardous'] ?? 0);
        } else {
            $lvl_perishable = 0; $lvl_hazardous = 0;
        }

        // Derive perishable/hazardous from selected cargo types
        $tq = $this->conn->query("SELECT ct.is_perishable, ct.is_hazardous FROM cargo_items ci INNER JOIN cargo_type_list ct ON ct.id = ci.cargo_type_id WHERE ci.cargo_id='{$cargo_id}'");
        $need_ref = 0; $need_haz = 0;
        while($tq && $row = $tq->fetch_assoc()){
            $need_ref = $need_ref || ((int)$row['is_perishable'] === 1) ? 1 : $need_ref;
            $need_haz = $need_haz || ((int)$row['is_hazardous'] === 1) ? 1 : $need_haz;
        }

        // Combine shipment-level and item-derived flags
        $is_hazardous = ($lvl_hazardous === 1) || ($need_haz === 1) ? 1 : 0;
        $is_perishable = ($lvl_perishable === 1) || ($need_ref === 1) ? 1 : 0;

        // Prioritize type: hazardous > perishable > any
        if($is_hazardous){
            $profile['type'] = 'hazardous';
            $profile['hazardous'] = 1;
            $profile['refrigerated'] = $is_perishable ? 1 : 0; // may be both
        } elseif($is_perishable){
            $profile['type'] = 'perishable';
            $profile['refrigerated'] = 1;
            $profile['hazardous'] = 0;
        } else {
            $profile['type'] = 'any';
            $profile['refrigerated'] = 0;
            $profile['hazardous'] = 0;
        }

        // Log profile for debugging/traceability
        try{
            $log_dir = base_app.'logs';
            if(!is_dir($log_dir)) @mkdir($log_dir,0777,true);
            $log_path = $log_dir.'/cargo_profile.log';
            $log_line = '['.date('Y-m-d H:i:s')."] cargo_id={$cargo_id} profile=".json_encode($profile)."\n";
            @file_put_contents($log_path, $log_line, FILE_APPEND | LOCK_EX);
        }catch(Exception $e){
            // ignore logging errors
        }

		return $profile;
	}

	/**
	 * Insert or update compliance check record
	 */
	private function insertComplianceCheck($cargo_id, $check_type, $check_status, $check_details, $checked_by = null) {
		$sql = "INSERT INTO compliance_checks (cargo_id, check_type, check_status, check_details, checked_by) VALUES (?, ?, ?, ?, ?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("isssi", $cargo_id, $check_type, $check_status, $check_details, $checked_by);
		return $stmt->execute();
	}

	/**
	 * Insert or update compliance violation record
	 */
	private function insertComplianceViolation($cargo_id, $rule_id, $violation_type, $violation_message, $severity = 'medium') {
		$sql = "INSERT INTO compliance_violations (cargo_id, rule_id, violation_type, violation_message, severity) VALUES (?, ?, ?, ?, ?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("iisss", $cargo_id, $rule_id, $violation_type, $violation_message, $severity);
		return $stmt->execute();
	}

	/**
	 * Insert or update hazardous approval record
	 */
	private function insertHazardousApproval($cargo_id, $approval_type, $document_path = null, $expires_at = null) {
		$sql = "INSERT INTO hazardous_approvals (cargo_id, approval_type, document_path, expires_at) VALUES (?, ?, ?, ?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("isss", $cargo_id, $approval_type, $document_path, $expires_at);
		return $stmt->execute();
	}

	/**
	 * Get compliance rule by type
	 */
	private function getComplianceRule($rule_type) {
		$sql = "SELECT * FROM compliance_rules WHERE rule_type = ? AND is_active = 1 LIMIT 1";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s", $rule_type);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}

	/**
	 * Validate cargo compliance and create records
	 */
	private function validateCargoCompliance($cargo_id) {
		$profile = $this->get_cargo_profile($cargo_id);
		$violations = [];
		$warnings = [];
		
		// Get cargo data for validation
		$cargo_qry = $this->conn->query("SELECT * FROM cargo_list WHERE id = '{$cargo_id}'");
		$cargo_data = $cargo_qry->fetch_assoc();
		
		// Weight validation
		if ($profile['weight'] > 0) {
			$weight_rule = $this->getComplianceRule('weight_limit');
			if ($weight_rule) {
				$config = json_decode($weight_rule['rule_value'], true);
				$max_weight = $config['max_weight_kg'] ?? 1000;
				$warning_weight = $config['warning_weight_kg'] ?? 800;
				
				if ($profile['weight'] > $max_weight) {
					$violations[] = [
						'rule_id' => $weight_rule['id'],
						'type' => 'weight_limit',
						'message' => "Weight ({$profile['weight']}kg) exceeds maximum limit ({$max_weight}kg)",
						'severity' => 'high'
					];
				} elseif ($profile['weight'] > $warning_weight) {
					$warnings[] = [
						'rule_id' => $weight_rule['id'],
						'type' => 'weight_limit',
						'message' => "Weight ({$profile['weight']}kg) approaching limit",
						'severity' => 'medium'
					];
				}
			}
		}
		
		// Size validation
		if ($profile['length_cm'] > 0 || $profile['width_cm'] > 0 || $profile['height_cm'] > 0) {
			$size_rule = $this->getComplianceRule('size_limit');
			if ($size_rule) {
				$config = json_decode($size_rule['rule_value'], true);
				$max_length = $config['max_length_cm'] ?? 300;
				$max_width = $config['max_width_cm'] ?? 200;
				$max_height = $config['max_height_cm'] ?? 150;
				
				if ($profile['length_cm'] > $max_length || $profile['width_cm'] > $max_width || $profile['height_cm'] > $max_height) {
					$violations[] = [
						'rule_id' => $size_rule['id'],
						'type' => 'size_limit',
						'message' => "Dimensions exceed limits (L:{$profile['length_cm']}/{$max_length}, W:{$profile['width_cm']}/{$max_width}, H:{$profile['height_cm']}/{$max_height})",
						'severity' => 'high'
					];
				}
			}
		}
		
		// Perishable goods validation
		if ($profile['type'] === 'perishable') {
			$perishable_rule = $this->getComplianceRule('perishable_time');
			if ($perishable_rule && $cargo_data['storage_start_time']) {
				$config = json_decode($perishable_rule['rule_value'], true);
				$max_hours = $config['max_hours'] ?? 48;
				$alert_hours = $config['alert_hours'] ?? 36;
				
				$storage_start = new DateTime($cargo_data['storage_start_time']);
				$now = new DateTime();
				$hours_stored = $now->diff($storage_start)->h + ($now->diff($storage_start)->days * 24);
				
				if ($hours_stored > $max_hours) {
					$violations[] = [
						'rule_id' => $perishable_rule['id'],
						'type' => 'perishable_time',
						'message' => "Perishable cargo exceeded storage time ({$hours_stored}h > {$max_hours}h)",
						'severity' => 'critical'
					];
				} elseif ($hours_stored > $alert_hours) {
					$warnings[] = [
						'rule_id' => $perishable_rule['id'],
						'type' => 'perishable_time',
						'message' => "Perishable cargo approaching storage limit ({$hours_stored}h)",
						'severity' => 'medium'
					];
				}
			}
		}
		
		// Hazardous materials validation
		if ($profile['type'] === 'hazardous') {
			$hazardous_rule = $this->getComplianceRule('hazardous_approval');
			if ($hazardous_rule) {
				// Check if approval already exists
				$existing_approval = $this->conn->query("SELECT * FROM hazardous_approvals WHERE cargo_id = '{$cargo_id}' AND approval_status = 'pending'");
				if ($existing_approval->num_rows == 0) {
					// Create pending approval
					$this->insertHazardousApproval($cargo_id, 'hazardous_material', null, date('Y-m-d H:i:s', strtotime('+7 days')));
				}
				
				$violations[] = [
					'rule_id' => $hazardous_rule['id'],
					'type' => 'hazardous_approval',
					'message' => "Hazardous materials require approval and safety documentation",
					'severity' => 'critical'
				];
			}
		}
		
		// Record compliance check
		$check_status = !empty($violations) ? 'failed' : (!empty($warnings) ? 'warning' : 'passed');
		$check_details = json_encode(['violations' => $violations, 'warnings' => $warnings, 'profile' => $profile]);
		$this->insertComplianceCheck($cargo_id, 'full_validation', $check_status, $check_details);
		
		// Record violations
		foreach ($violations as $violation) {
			$this->insertComplianceViolation($cargo_id, $violation['rule_id'], $violation['type'], $violation['message'], $violation['severity']);
		}
		
		return ['violations' => $violations, 'warnings' => $warnings, 'profile' => $profile];
	}

	public function allocate_storage_for_cargo($cargo_id){
		$cargo_id = (int)$cargo_id;
		// Skip if already allocated
		$exists = $this->conn->query("SELECT id FROM cargo_allocation WHERE cargo_id='{$cargo_id}' AND status='allocated' LIMIT 1");
		if($exists && $exists->num_rows) return true;

		$P = $this->get_cargo_profile($cargo_id);
		$type = $this->conn->real_escape_string($P['type']);
		$weight = (float)$P['weight'];
		$need_ref = $P['refrigerated'] ? 1 : 0;
		$need_haz = $P['hazardous'] ? 1 : 0;

		// Build filter
		$where = [];
		$where[] = "status=1";
		$where[] = "(capacity_weight - occupied_weight) >= {$weight}";
		$where[] = "is_occupied IN (0,1)"; // allow partially occupied by weight
		if($need_ref) $where[] = "is_refrigerated=1";
		if($need_haz) $where[] = "is_hazardous_zone=1";
		// type compatibility (allow any type when cargo type is unknown)
		$where[] = "(type_allowed='any' OR '".$type."'='any' OR type_allowed='".$type."')";

		$sql = "SELECT *, (capacity_weight - occupied_weight) AS free_wt FROM storage_units
			WHERE ".implode(' AND ', $where)."
			ORDER BY near_exit DESC, free_wt ASC, is_refrigerated DESC
			LIMIT 1";
		$res = $this->conn->query($sql);
		if(!$res || !$res->num_rows){
			// No slot found
			return false;
		}
		$unit = $res->fetch_assoc();
		$unit_id = (int)$unit['id'];

		// Allocate: update unit occupied weight and flag
		$upd = $this->conn->query("UPDATE storage_units SET occupied_weight = occupied_weight + {$weight}, is_occupied = 1 WHERE id='{$unit_id}'");
		if(!$upd){
			return false;
		}
		$this->conn->query("INSERT INTO cargo_allocation (cargo_id, storage_unit_id, status) VALUES ('{$cargo_id}','{$unit_id}','allocated')");
		return true;
	}

	public function release_storage_for_cargo($cargo_id){
		$cargo_id = (int)$cargo_id;
		// Find active allocation
		$q = $this->conn->query("SELECT id, storage_unit_id FROM cargo_allocation WHERE cargo_id='{$cargo_id}' AND status='allocated' ORDER BY id DESC LIMIT 1");
		if(!$q || !$q->num_rows) return true;
		$row = $q->fetch_assoc();
		$alloc_id = (int)$row['id'];
		$unit_id = (int)$row['storage_unit_id'];
		$P = $this->get_cargo_profile($cargo_id);
		$weight = (float)$P['weight'];
		// Decrease occupied weight
		$this->conn->query("UPDATE storage_units SET occupied_weight = GREATEST(0, occupied_weight - {$weight}), is_occupied = CASE WHEN (occupied_weight - {$weight}) > 0 THEN 1 ELSE 0 END WHERE id='{$unit_id}'");
		// Mark allocation released
		$this->conn->query("UPDATE cargo_allocation SET status='released', released_at=NOW() WHERE id='{$alloc_id}'");
		return true;
	}
	function add_track($cargo_id = '', $title= '', $description=''){
		if(!empty($cargo_id) && !empty($title) && !empty($description)){
			$insert = $this->conn->query("INSERT INTO `tracking_list` (`cargo_id`, `title`, `description`) VALUES ('{$cargo_id}', '{$title}', '{$description}') ");
			if($insert)
			return true;
			else
			return false;
		}
		return false;
	}
	
	function sendShipmentEmailNotification($cargo_id){
		try {
			// Get cargo data
			$cargo_qry = $this->conn->query("SELECT * FROM `cargo_list` where id = '{$cargo_id}'");
			if($cargo_qry->num_rows > 0){
				$cargo_data = $cargo_qry->fetch_assoc();
				
				// Get cargo meta data
				$meta_qry = $this->conn->query("SELECT * FROM `cargo_meta` where cargo_id = '{$cargo_id}'");
				while($row = $meta_qry->fetch_assoc()){
					$cargo_data[$row['meta_field']] = $row['meta_value'];
				}
				
				// Send email notification
				$emailNotification = new EmailNotification();
				$emailNotification->sendShipmentCreatedNotification($cargo_data);
			}
		} catch (Exception $e) {
			// Log error but don't break the main process
			error_log("Email notification error: " . $e->getMessage());
		}
	}
	
	function sendStatusUpdateEmailNotification($cargo_id, $new_status, $remarks = ''){
		try {
			// Get cargo data
			$cargo_qry = $this->conn->query("SELECT * FROM `cargo_list` where id = '{$cargo_id}'");
			if($cargo_qry->num_rows > 0){
				$cargo_data = $cargo_qry->fetch_assoc();
				
				// Get cargo meta data
				$meta_qry = $this->conn->query("SELECT * FROM `cargo_meta` where cargo_id = '{$cargo_id}'");
				while($row = $meta_qry->fetch_assoc()){
					$cargo_data[$row['meta_field']] = $row['meta_value'];
				}
				
				// Send email notification
				$emailNotification = new EmailNotification();
				$emailNotification->sendStatusUpdateNotification($cargo_data, $new_status, $remarks);
			}
		} catch (Exception $e) {
			// Log error but don't break the main process
			error_log("Email notification error: " . $e->getMessage());
		}
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_cargo_type':
		echo $Master->save_cargo_type();
	break;
	case 'delete_cargo_type':
		echo $Master->delete_cargo_type();
	break;
	case 'save_cargo_type_order':
		echo $Master->save_cargo_type_order();
	break;
	case 'save_status':
		echo $Master->save_status();
	break;
	case 'delete_status':
		echo $Master->delete_status();
	break;
	case 'save_status_order':
		echo $Master->save_status_order();
	break;
	case 'save_cargo':
		echo $Master->save_cargo();
	break;
	case 'delete_cargo':
		echo $Master->delete_cargo();
	break;
	case 'update_cargo_type':
		echo $Master->update_cargo_type();
	break;
	default:
		// echo $sysset->index();
		break;
}