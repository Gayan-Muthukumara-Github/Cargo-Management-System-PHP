<?php
require_once('../config.php');
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
		$cargo_allowed_statuss = ["ref_code","shipping_type","total_amount","status"];
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
			$save_track = $this->add_track($id,$status_lbl[$status],$remarks);
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = " Shipment Status has failed update.";
		}

		if($resp['status'] == 'success')
		$this->settings->set_flashdata('success',$resp['msg']);
		return json_encode($resp);
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