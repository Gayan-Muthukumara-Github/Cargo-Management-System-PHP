<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `cargo_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
        if(isset($id)){
            $meta_qry = $conn->query("SELECT * FROM `cargo_meta` where cargo_id = '{$id}'");
            while($row = $meta_qry->fetch_assoc()){
                ${$row['meta_field']} = $row['meta_value'];
            }
        }
    }
}
$cargo_type = [];
$cargo_type_qry = $conn->query("SELECT id,`name`, city_price, state_price, country_price FROM `cargo_type_list` where delete_flag = 0 order by `name` asc");
while($row = $cargo_type_qry->fetch_assoc()){
    $cargo_type[$row['id']] = $row;
}
?>
<style>
    img#cimg{
		max-height: 15vh;
		width: 100%;
		object-fit: scale-down;
		object-position: center center;
	}
    
</style>
<div class="content py-3">
    <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
            <h4 class="card-title"><b><?= isset($id) ? "Add New Smart Phone" : "Update Smart Phone's Details" ?></b></h4>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <form action="" id="cargo-form">
                    <input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="card rounded-0 shadow">
                                    <div class="card-header">
                                        <h5 class="font-weight-bolder">Sender Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-2">
                                            <label for="sender_name" class="control-label">Full Name</label>
                                            <input type="text" name="sender_name" id="sender_name" class="form-control form-control-sm form-control-border" value="<?= isset($sender_name) ? $sender_name : '' ?>" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="sender_contact" class="control-label">Contact #</label>
                                            <input type="text" name="sender_contact" id="sender_contact" class="form-control form-control-sm form-control-border" value="<?= isset($sender_contact) ? $sender_contact : '' ?>" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="sender_email" class="control-label">Email Address</label>
                                            <input type="email" name="sender_email" id="sender_email" class="form-control form-control-sm form-control-border" value="<?= isset($sender_email) ? $sender_email : '' ?>" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="sender_address" class="control-label">Address</label>
                                            <textarea rows="3" name="sender_address" id="sender_address" class="form-control form-control-sm rounded-0" required><?= isset($sender_address) ? $sender_address : '' ?></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="sender_provided_id_type" class="control-label">Provided ID Type</label>
                                            <input type="text" name="sender_provided_id_type" id="sender_provided_id_type" class="form-control form-control-sm form-control-border" value="<?= isset($sender_provided_id_type) ? $sender_provided_id_type : '' ?>" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="sender_provided_id" class="control-label">Provided ID #/Code</label>
                                            <input type="text" name="sender_provided_id" id="sender_provided_id" class="form-control form-control-sm form-control-border" value="<?= isset($sender_provided_id) ? $sender_provided_id : '' ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="card rounded-0 shadow">
                                    <div class="card-header">
                                        <h5 class="font-weight-bolder">Receiver Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-2">
                                            <label for="receiver_name" class="control-label">Full Name</label>
                                            <input type="text" name="receiver_name" id="receiver_name" class="form-control form-control-sm form-control-border" value="<?= isset($receiver_name) ? $receiver_name : '' ?>" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="receiver_contact" class="control-label">Contact #</label>
                                            <input type="text" name="receiver_contact" id="receiver_contact" class="form-control form-control-sm form-control-border" value="<?= isset($receiver_contact) ? $receiver_contact : '' ?>" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="receiver_email" class="control-label">Email Address</label>
                                            <input type="email" name="receiver_email" id="receiver_email" class="form-control form-control-sm form-control-border" value="<?= isset($receiver_email) ? $receiver_email : '' ?>" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="receiver_address" class="control-label">Address</label>
                                            <textarea rows="3" name="receiver_address" id="receiver_address" class="form-control form-control-sm rounded-0" required><?= isset($receiver_address) ? $receiver_address : '' ?></textarea>
                                        </div>
                                        <!-- <div class="form-group mb-2">
                                            <label for="receiver_provided_id_type" class="control-label">Provided ID Type</label>
                                            <input type="text" name="receiver_provided_id_type" id="receiver_provided_id_type" class="form-control form-control-sm form-control-border" value="<?= isset($receiver_provided_id_type) ? $receiver_provided_id_type : '' ?>" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="receiver_provided_id" class="control-label">Provided ID #/Code</label>
                                            <input type="text" name="receiver_provided_id" id="receiver_provided_id" class="form-control form-control-sm form-control-border" value="<?= isset($receiver_provided_id) ? $receiver_provided_id : '' ?>" required>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-sm-12">
                                <div class="form-group mb-2">
                                    <label for="from_location" class="control-label">From Location</label>
                                    <textarea name="from_location" id="from_location" class="form-control form-control-sm rounded-0" rows="3" required><?= isset($from_location) ? $from_location : "" ?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-sm-12">
                                <div class="form-group mb-2">
                                    <label for="to_location" class="control-label">To Location</label>
                                    <textarea name="to_location" id="to_location" class="form-control form-control-sm rounded-0" rows="3" required><?= isset($to_location) ? $to_location : "" ?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-sm-12">
                                <div class="form-group mb-2">
                                    <label for="shipping_type" class="control-label">Shipping Type</label>
                                    <select name="shipping_type" id="shipping_type" class="form-control form-control-sm  form-control-border"  required>
                                    <option value="1" <?= isset($shipping_type) && $shipping_type == 1 ? 'selected' : "" ?>>City to City</option>
                                    <option value="2" <?= isset($shipping_type) && $shipping_type == 2 ? 'selected' : "" ?>>State to State</option>
                                    <option value="3" <?= isset($shipping_type) && $shipping_type == 3 ? 'selected' : "" ?>>Country to Country</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Compliance & Validation Section -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-outline card-warning shadow rounded-0">
                                    <div class="card-header">
                                        <h5 class="card-title"><b><i class="fas fa-shield-alt mr-2"></i>Compliance & Validation</b></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="weight_kg" class="control-label">Total Weight (kg)</label>
                                                    <input type="number" step="0.01" name="weight_kg" id="weight_kg" class="form-control form-control-sm form-control-border" value="<?= isset($weight_kg) ? $weight_kg : '' ?>" placeholder="0.00">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="length_cm" class="control-label">Length (cm)</label>
                                                    <input type="number" name="length_cm" id="length_cm" class="form-control form-control-sm form-control-border" value="<?= isset($length_cm) ? $length_cm : '' ?>" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="width_cm" class="control-label">Width (cm)</label>
                                                    <input type="number" name="width_cm" id="width_cm" class="form-control form-control-sm form-control-border" value="<?= isset($width_cm) ? $width_cm : '' ?>" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="height_cm" class="control-label">Height (cm)</label>
                                                    <input type="number" name="height_cm" id="height_cm" class="form-control form-control-sm form-control-border" value="<?= isset($height_cm) ? $height_cm : '' ?>" placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                            <div class="form-group mb-2">
                                                <input type="hidden" name="is_perishable" value="0">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_perishable" name="is_perishable" value="1" <?= isset($is_perishable) && $is_perishable ? 'checked' : '' ?>>
                                                    <label class="custom-control-label" for="is_perishable">Perishable Goods</label>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                            <div class="form-group mb-2">
                                                <input type="hidden" name="is_hazardous" value="0">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="is_hazardous" name="is_hazardous" value="1" <?= isset($is_hazardous) && $is_hazardous ? 'checked' : '' ?>>
                                                    <label class="custom-control-label" for="is_hazardous">Hazardous Materials</label>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                            <div class="form-group mb-2">
                                                <input type="hidden" name="special_handling_required" value="0">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="special_handling_required" name="special_handling_required" value="1" <?= isset($special_handling_required) && $special_handling_required ? 'checked' : '' ?>>
                                                    <label class="custom-control-label" for="special_handling_required">Special Handling Required</label>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="row" id="perishable_fields" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-2">
                                                    <label for="max_storage_hours" class="control-label">Max Storage Hours</label>
                                                    <input type="number" name="max_storage_hours" id="max_storage_hours" class="form-control form-control-sm form-control-border" value="<?= isset($max_storage_hours) ? $max_storage_hours : '48' ?>" placeholder="48">
                                                    <small class="text-muted">Maximum hours perishable goods can be stored</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="hazardous_fields" style="display: none;">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-2">
                                                    <label for="hazardous_documents" class="control-label">Safety Documents</label>
                                                    <input type="file" name="hazardous_documents[]" id="hazardous_documents" class="form-control form-control-sm form-control-border" multiple accept=".pdf,.doc,.docx">
                                                    <small class="text-muted">Upload MSDS, safety certificates, and other required documents</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="compliance_warnings" class="alert alert-warning" style="display: none;">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            <span id="compliance_warning_text"></span>
                                        </div>
                                        <div id="compliance_errors" class="alert alert-danger" style="display: none;">
                                            <i class="fas fa-times-circle mr-2"></i>
                                            <span id="compliance_error_text"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card card-outline card-info shadow rounded0">
                                    <div class="card-header">
                                        <h5 class="card-title"><b>Cargo Items</b></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-center mb-0 pb-0">
                                            <div class="col-3 border text-center"><b>Cargo Type</b></div>
                                            <div class="col-3 border text-center"><b>Price($)</b></div>
                                            <div class="col-3 border text-center"><b>Weight/kg.</b></div>
                                            <div class="col-3 border text-center"><b>Total</b></div>
                                        </div>
                                        <div id="cargo-item-list" class="d-table w-100">
                                        <?php 
                                        if(isset($id)):
                                        $items = $conn->query("SELECT i.*,t.name as cargo_type FROM `cargo_items` i inner join cargo_type_list t on i.cargo_type_id = t.id where i.cargo_id = '{$id}'");
                                        while($row = $items->fetch_array()):
                                        ?>
                                        <div class="d-table-row align-items-center justify-content-center my-0 py-0 cargo-item">
                                            <div class="d-table-cell col-3 px-2 py-1 border text-center">
                                                <input type="hidden" name="price[]" value="<?= $row['price'] ?>">
                                                <input type="hidden" name="total[]" value="<?= $row['total'] ?>">
                                                <select name="cargo_type_id[]" class="form-control form-control-sm form-control-border select2">
                                                    <option value="" disabled='' selected></option>
                                                    <?php 
                                                        foreach($cargo_type as $crow):
                                                    ?>
                                                    <option value="<?= $crow['id'] ?>" <?= $crow['id'] == $row['cargo_type_id'] ? 'selected': ''  ?>><?= $crow['name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="d-table-cell col-3 px-2 py-1 border text-right"><span class="font-weight-bold price"><?= format_num($row['price']) ?></span></div>
                                            <div class="d-table-cell col-3 px-2 py-1 border text-center"><input type="number" step="any" name="weight[]" class="form-control form-control-sm form-control-border text-right" value="<?= ($row['weight']) ?>"></div>
                                            <div class="d-table-cell col-3 px-2 py-1 border text-right"><span class="font-weight-bold total"><?= format_num($row['total']) ?></span></div>
                                        </div>
                                        <?php endwhile; ?>
                                        <?php endif; ?>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-0 pb-0">
                                            <div class="col-9 border text-center"><b>Total</b></div>
                                            <div class="col-3 border text-center">$<b id="gtotal"><?= isset($total_amount) ? format_num($total_amount) : '0.00' ?></b><input type="hidden" name="total_amount" value="<?= isset($total_amount) ? $total_amount : "" ?>"></div>
                                        </div>
                                        <div class="clear-fix my-2"></div>
                                        <div class="text-right">
                                            <button class="btn btn-default border btn-sm btn-flat" id="add_item" type="button"><i class="fa fa-plus"></i> Add Item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-footer text-right">
                <button class="btn btn-sm btn-flat btn-primary" type="submit" form="cargo-form">Save</button>
                <a class="btn btn-sm btn-flat btn-default border" href="./?page=transactions">Cancel</a>
        </div>
    </div>
</div>
<noscript id="cargo-item-clone">
<div class="d-table-row align-items-center justify-content-center my-0 py-0 cargo-item">
    <div class="d-table-cell col-3 px-2 py-1 border text-center">
        <input type="hidden" name="price[]">
        <input type="hidden" name="total[]">
        <select name="cargo_type_id[]" class="form-control form-control-sm form-control-border select2">
            <option value="" disabled='' selected></option>
            <?php 
                foreach($cargo_type as $row):
            ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="d-table-cell col-3 px-2 py-1 border text-right"><span class="font-weight-bold price">$0.00</span></div>
    <div class="d-table-cell col-3 px-2 py-1 border text-center"><input type="number" step="any" name="weight[]" class="form-control form-control-sm form-control-border text-right"></div>
    <div class="d-table-cell col-3 px-2 py-1 border text-right"><span class="font-weight-bold total">$0.00</span></div>
</div>
</noscript>
<script>
    const cargo_type = $.parseJSON('<?= json_encode($cargo_type) ?>');
    function change_price(_this,cargo_type_id){
        var type= $('#shipping_type').val()

        if(!!cargo_type[cargo_type_id]){
            if(type == 1){
                var price = cargo_type[cargo_type_id].city_price
            }else if(type == 2){
                var price = cargo_type[cargo_type_id].state_price
            }else if(type == 3){
                var price = cargo_type[cargo_type_id].country_price
            }else{
                var price = 0;
            }
            _this.find("input[name='price[]']").val(price)
            _this.find(".price").text(parseFloat(price).toLocaleString("en-US"))
            calc()
        }
    }
    function calc(){
        var gtotal = 0;
        $('#cargo-item-list .cargo-item').each(function(){
            var price = $(this).find('[name="price[]"]').val();
            var weight = $(this).find('[name="weight[]"]').val();
            price = price > 0 ? price : 0;
            weight = weight > 0 ? weight : 0;
            var total = parseFloat(price) * parseFloat(weight)
            $(this).find('[name="total[]"]').val(total)
            $(this).find('.total').text(parseFloat(total).toLocaleString('en-US'))
            gtotal += parseFloat(total)

        })
        $('[name="total_amount"]').val(gtotal)
        $('#gtotal').text(parseFloat(gtotal).toLocaleString('en-US'))
    }
    
    // Compliance validation function
    function validateCompliance() {
        var warnings = [];
        var errors = [];
        
        // Weight validation
        var weight = parseFloat($('#weight_kg').val()) || 0;
        if (weight > 1000) {
            errors.push('Weight exceeds maximum limit (1000kg). Special handling required.');
        } else if (weight > 800) {
            warnings.push('Weight is approaching limit (800kg). Consider special handling.');
        }
        
        // Size validation
        var length = parseInt($('#length_cm').val()) || 0;
        var width = parseInt($('#width_cm').val()) || 0;
        var height = parseInt($('#height_cm').val()) || 0;
        
        if (length > 300 || width > 200 || height > 150) {
            errors.push('Dimensions exceed standard limits. Special handling required.');
        }
        
        // Hazardous materials validation
        if ($('#is_hazardous').is(':checked')) {
            var files = $('#hazardous_documents')[0].files;
            if (files.length === 0) {
                errors.push('Hazardous materials require safety documentation upload.');
            }
        }
        
        // Display warnings and errors
        $('#compliance_warnings').hide();
        $('#compliance_errors').hide();
        
        if (errors.length > 0) {
            $('#compliance_error_text').text(errors.join(' '));
            $('#compliance_errors').show();
        } else if (warnings.length > 0) {
            $('#compliance_warning_text').text(warnings.join(' '));
            $('#compliance_warnings').show();
        }
        
        return errors.length === 0;
    }
	$(document).ready(function(){
        $('.select2').select2({
            width:"100%",
            placeholder:"Please Select Here"
        })
        
        // Compliance validation handlers
        $('#is_perishable').change(function(){
            if($(this).is(':checked')){
                $('#perishable_fields').show();
            } else {
                $('#perishable_fields').hide();
            }
        });
        
        $('#is_hazardous').change(function(){
            if($(this).is(':checked')){
                $('#hazardous_fields').show();
            } else {
                $('#hazardous_fields').hide();
            }
        });
        
        // Show/hide fields based on current state
        if($('#is_perishable').is(':checked')){
            $('#perishable_fields').show();
        }
        if($('#is_hazardous').is(':checked')){
            $('#hazardous_fields').show();
        }
        
        // Real-time compliance validation
        $('#weight_kg, #length_cm, #width_cm, #height_cm').on('input', function(){
            validateCompliance();
        });
        
        $('#add_item').click(function(){
            var item = $($('noscript#cargo-item-clone').html()).clone()
            $('#cargo-item-list').append(item)
            item.find('.select2').select2({
                width:"100%",
                placeholder:"Please Select Here"
            })
            item.find("[name='cargo_type_id[]']").change(function(){
                var id = $(this).val();
                change_price(item, id)
                validateCompliance();
            })
            item.find('[name="weight[]"]').on('input',function(){
                console.log('test')
                calc()
                validateCompliance();
            })
        })
        $("[name='cargo_type_id[]']").change(function(){
            var id = $(this).val();
            change_price(item, id)
            validateCompliance();
        })
        $('[name="weight[]"]').on('input',function(){
            console.log('test')
            calc()
            validateCompliance();
        })
        $('#shipping_type').change(function(){
            $('#cargo-item-list .cargo-item').each(function(){
                var id = $(this).find('[name="cargo_type_id[]"]').val()
                change_price($(this), id)
            })
            validateCompliance();
        })
		$('#cargo-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			 
			// Validate compliance before submission
			if (!validateCompliance()) {
				alert_toast("Please resolve compliance issues before submitting", 'error');
				return false;
			}
			
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_cargo",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.replace("./?page=transactions/view_transaction&id="+resp.cid);
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                    }else{
						alert_toast("An error occured",'error');
                        console.log(resp)
					}
					end_loader();
				}
			})
		})

	})
</script>