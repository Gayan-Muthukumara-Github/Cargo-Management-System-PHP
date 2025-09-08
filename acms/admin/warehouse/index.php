<?php require_once('../config.php'); ?>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-warehouse mr-2"></i>Warehouse Overview</h3>
            <div class="card-tools">
              <a href="<?php echo base_url ?>admin/?page=warehouse/manage_unit" class="btn btn-sm btn-light"><i class="fas fa-plus mr-1"></i>Add Storage Unit</a>
            </div>
          </div>
          <div class="card-body">
            <?php 
              $tot_capacity = 0; $tot_used = 0; $slots_total = 0; $slots_occ = 0;
              $units = $conn->query("SELECT su.*, w.name as warehouse_name FROM storage_units su INNER JOIN warehouses w ON w.id=su.warehouse_id WHERE su.status=1");
              while($u = $units->fetch_assoc()):
                $tot_capacity += (float)$u['capacity_weight'];
                $tot_used += (float)$u['occupied_weight'];
                $slots_total++;
                if((int)$u['is_occupied'] === 1) $slots_occ++;
              endwhile;
              $available_slots = $slots_total - $slots_occ;
              $free_weight = max(0, $tot_capacity - $tot_used);
            ?>
            <div class="row">
              <div class="col-md-3 col-sm-6">
                <div class="info-box">
                  <span class="info-box-icon bg-primary"><i class="fas fa-balance-scale"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Total Capacity (kg)</span>
                    <span class="info-box-number"><?php echo number_format($tot_capacity,2) ?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="info-box">
                  <span class="info-box-icon bg-info"><i class="fas fa-dolly"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Used (kg)</span>
                    <span class="info-box-number"><?php echo number_format($tot_used,2) ?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="info-box">
                  <span class="info-box-icon bg-success"><i class="fas fa-boxes"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Available (kg)</span>
                    <span class="info-box-number"><?php echo number_format($free_weight,2) ?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="info-box">
                  <span class="info-box-icon bg-warning"><i class="fas fa-th-large"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Slots (Free/Total)</span>
                    <span class="info-box-number"><?php echo $available_slots.' / '.$slots_total ?></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Warehouse</th>
                    <th>Zone</th>
                    <th>Unit Code</th>
                    <th>Type</th>
                    <th>Capacity (kg)</th>
                    <th>Used (kg)</th>
                    <th>Near Exit</th>
                    <th>Refrigerated</th>
                    <th>Hazardous Zone</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  $units = $conn->query("SELECT su.*, w.name as warehouse_name FROM storage_units su INNER JOIN warehouses w ON w.id=su.warehouse_id ORDER BY w.name, su.zone, su.unit_code");
                  while($u = $units->fetch_assoc()):
                ?>
                  <tr>
                    <td><?php echo $u['warehouse_name'] ?></td>
                    <td><?php echo $u['zone'] ?></td>
                    <td><?php echo $u['unit_code'] ?></td>
                    <td><span class="badge badge-info"><?php echo strtoupper($u['type_allowed']) ?></span></td>
                    <td><?php echo number_format($u['capacity_weight'],2) ?></td>
                    <td><?php echo number_format($u['occupied_weight'],2) ?></td>
                    <td><?php echo $u['near_exit'] ? 'Yes' : 'No' ?></td>
                    <td><?php echo $u['is_refrigerated'] ? 'Yes' : 'No' ?></td>
                    <td><?php echo $u['is_hazardous_zone'] ? 'Yes' : 'No' ?></td>
                    <td>
                      <?php if($u['status'] == 1): ?>
                        <span class="badge badge-success">Active</span>
                      <?php else: ?>
                        <span class="badge badge-secondary">Inactive</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


