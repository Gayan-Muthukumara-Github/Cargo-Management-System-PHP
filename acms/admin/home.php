<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
        <div class="col-12 col-sm-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-list"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Cargo Types</span>
                <span class="info-box-number">
                  <?php 
                    $cargo_type = $conn->query("SELECT * FROM cargo_type_list where delete_flag = 0")->num_rows;
                    echo format_num($cargo_type);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-secondary elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Shipment</span>
                <span class="info-box-number">
                  <?php 
                    $cargo = $conn->query("SELECT * FROM cargo_list where `status` = 0 ")->num_rows;
                    echo format_num($cargo);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">In-Transit Shipment</span>
                <span class="info-box-number">
                  <?php 
                    $cargo = $conn->query("SELECT * FROM cargo_list where `status` = 1 ")->num_rows;
                    echo format_num($cargo);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Arrived at Station</span>
                <span class="info-box-number">
                  <?php 
                    $cargo = $conn->query("SELECT * FROM cargo_list where `status` = 2 ")->num_rows;
                    echo format_num($cargo);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-light border elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Out for Delivery</span>
                <span class="info-box-number">
                  <?php 
                    $cargo = $conn->query("SELECT * FROM cargo_list where `status` = 3 ")->num_rows;
                    echo format_num($cargo);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-4 col-md-4 col-sm-12 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-truck-loading"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Delivered</span>
                <span class="info-box-number">
                  <?php 
                    $cargo = $conn->query("SELECT * FROM cargo_list where `status` = 4 ")->num_rows;
                    echo format_num($cargo);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
<div class="container">
  <?php 
    $files = array();
      $fopen = scandir(base_app.'uploads/banner');
      foreach($fopen as $fname){
        if(in_array($fname,array('.','..')))
          continue;
        $files[]= validate_image('uploads/banner/'.$fname);
      }
  ?>
  <div id="tourCarousel"  class="carousel slide" data-ride="carousel" data-interval="2500">
      <div class="carousel-inner h-100">
          <?php foreach($files as $k => $img): ?>
          <div class="carousel-item  h-100 <?php echo $k == 0? 'active': '' ?>">
              <img class="d-block w-100  h-100" style="object-fit:contain" src="<?php echo $img ?>" alt="">
          </div>
          <?php endforeach; ?>
      </div>
      <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
      </a>
  </div>
</div>
