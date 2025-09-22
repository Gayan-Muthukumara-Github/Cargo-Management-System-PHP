<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `cargo_type_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none;
    }
</style>
<div class="container-fluid">
	<dl>
        <dt class="text-muted">Cargo Type</dt>
        <dd class="pl-4"><?= isset($name) ? $name : "" ?></dd>
        <dt class="text-muted">Description</dt>
        <dd class="pl-4"><?= isset($description) ? $description : '' ?></dd>
        <dt class="text-muted">City to City Price per kg.</dt>
        <dd class="pl-4"><?= isset($city_price) ? format_num($city_price) : '' ?></dd>
        <dt class="text-muted">State to State Price per kg.</dt>
        <dd class="pl-4"><?= isset($state_price) ? format_num($state_price) : '' ?></dd>
        <dt class="text-muted">Country to Country Price per kg.</dt>
        <dd class="pl-4"><?= isset($country_price) ? format_num($country_price) : '' ?></dd>
		<dt class="text-muted">Perishable</dt>
		<dd class="pl-4">
			<?php echo (isset($is_perishable) && (int)$is_perishable === 1) ? '<span class="badge badge-info px-3 rounded-pill">Yes</span>' : '<span class="badge badge-secondary px-3 rounded-pill">No</span>'; ?>
		</dd>
		<dt class="text-muted">Hazardous</dt>
		<dd class="pl-4">
			<?php echo (isset($is_hazardous) && (int)$is_hazardous === 1) ? '<span class="badge badge-warning px-3 rounded-pill">Yes</span>' : '<span class="badge badge-secondary px-3 rounded-pill">No</span>'; ?>
		</dd>
        <dt class="text-muted">Status</dt>
        <dd class="pl-4">
            <?php if($status == 1): ?>
                <span class="badge badge-success px-3 rounded-pill">Active</span>
            <?php else: ?>
                <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
            <?php endif; ?>
        </dd>
		<dt class="text-muted">Date Created</dt>
		<dd class="pl-4"><?= isset($date_created) ? date('Y-m-d H:i', strtotime($date_created)) : '—' ?></dd>
		<dt class="text-muted">Date Updated</dt>
		<dd class="pl-4"><?= isset($date_updated) && !empty($date_updated) ? date('Y-m-d H:i', strtotime($date_updated)) : '—' ?></dd>
    </dl>
    <div class="clear-fix my-3"></div>
    <div class="text-right">
        <button class="btn btn-sm btn-dark bg-gradient-dark btn-flat" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>