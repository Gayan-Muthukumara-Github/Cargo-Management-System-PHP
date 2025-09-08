<style>
    /* Modern Dashboard Styles */
    .dashboard-hero {
        background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
        border-radius: var(--admin-radius-lg);
        position: relative;
        overflow: hidden;
    }
    
    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="300" fill="url(%23a)"/><circle cx="800" cy="300" r="200" fill="url(%23a)"/><circle cx="400" cy="700" r="250" fill="url(%23a)"/></svg>');
        opacity: 0.3;
    }
    
    .dashboard-hero-content {
        position: relative;
        z-index: 2;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: var(--admin-radius-lg);
        padding: 2rem;
        box-shadow: var(--admin-shadow);
        position: relative;
        overflow: hidden;
        border: none;
    }
    
    .stat-card:hover {
        box-shadow: var(--admin-shadow-lg);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
    }
    
    .stat-card.primary::before {
        background: linear-gradient(90deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
    }
    
    .stat-card.success::before {
        background: linear-gradient(90deg, var(--admin-success) 0%, #059669 100%);
    }
    
    .stat-card.warning::before {
        background: linear-gradient(90deg, var(--admin-warning) 0%, #d97706 100%);
    }
    
    .stat-card.info::before {
        background: linear-gradient(90deg, var(--admin-info) 0%, #0891b2 100%);
    }
    
    .stat-card.danger::before {
        background: linear-gradient(90deg, var(--admin-danger) 0%, #dc2626 100%);
    }
    
    .stat-card.secondary::before {
        background: var(--admin-secondary);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: var(--admin-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: var(--admin-shadow);
    }
    
    .stat-icon.primary {
        background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
    }
    
    .stat-icon.success {
        background: linear-gradient(135deg, var(--admin-success) 0%, #059669 100%);
    }
    
    .stat-icon.warning {
        background: linear-gradient(135deg, var(--admin-warning) 0%, #d97706 100%);
    }
    
    .stat-icon.info {
        background: linear-gradient(135deg, var(--admin-info) 0%, #0891b2 100%);
    }
    
    .stat-icon.danger {
        background: linear-gradient(135deg, var(--admin-danger) 0%, #dc2626 100%);
    }
    
    .stat-icon.secondary {
        background: var(--admin-secondary);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--admin-dark);
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: var(--admin-secondary);
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .stat-change {
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .stat-change.positive {
        color: var(--admin-success);
    }
    
    .stat-change.negative {
        color: var(--admin-danger);
    }
    
    .banner-carousel {
        border-radius: var(--admin-radius-lg);
        overflow: hidden;
        box-shadow: var(--admin-shadow);
        margin-top: 2rem;
    }
    
    .banner-carousel .carousel-item img {
        height: 300px;
        object-fit: cover;
        width: 100%;
    }
    
    .banner-carousel .carousel-control-prev,
    .banner-carousel .carousel-control-next {
        width: 50px;
        height: 50px;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        top: 50%;
    }
    
    .banner-carousel .carousel-control-prev:hover,
    .banner-carousel .carousel-control-next:hover {
        background: rgba(0, 0, 0, 0.7);
    }
    
    .banner-carousel .carousel-control-prev {
        left: 20px;
    }
    
    .banner-carousel .carousel-control-next {
        right: 20px;
    }
    
    .banner-carousel .carousel-indicators {
        bottom: 20px;
    }
    
    .banner-carousel .carousel-indicators li {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        border: none;
    }
    
    .banner-carousel .carousel-indicators li.active {
        background: white;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .quick-action-btn {
        background: white;
        border: 2px solid var(--admin-border);
        border-radius: var(--admin-radius);
        padding: 1.5rem;
        text-align: center;
        text-decoration: none;
        color: var(--admin-dark);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
    
    .quick-action-btn:hover {
        border-color: var(--admin-primary);
        color: var(--admin-primary);
        box-shadow: var(--admin-shadow);
        text-decoration: none;
    }
    
    .quick-action-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .dashboard-hero {
            padding: 2rem 0;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .stat-card {
            padding: 1.5rem;
        }
        
        .stat-number {
            font-size: 2rem;
        }
        
        .banner-carousel .carousel-item img {
            height: 200px;
        }
        
        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- Dashboard Hero Section -->
<div class="dashboard-hero">
    <div class="container-fluid">
        <div class="dashboard-hero-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                    </h1>
                    <p class="lead mb-0">
                        Welcome back! Here's an overview of your cargo management system.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex align-items-center justify-content-lg-end gap-3">
                        <div class="text-end">
                            <div class="fw-bold"><?php echo date('l, F j, Y') ?></div>
                            <div class="opacity-75"><?php echo date('g:i A') ?></div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Grid -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-icon primary">
            <i class="fas fa-list"></i>
        </div>
        <div class="stat-number">
                  <?php 
                    $cargo_type = $conn->query("SELECT * FROM cargo_type_list where delete_flag = 0")->num_rows;
                    echo format_num($cargo_type);
                  ?>
              </div>
        <div class="stat-label">Total Cargo Types</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>Active</span>
            </div>
          </div>
    
    <div class="stat-card warning">
        <div class="stat-icon warning">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-number">
                  <?php 
                    $cargo = $conn->query("SELECT * FROM cargo_list where `status` = 0 ")->num_rows;
                    echo format_num($cargo);
                  ?>
              </div>
        <div class="stat-label">Pending Shipment</div>
        <div class="stat-change">
            <i class="fas fa-exclamation-circle"></i>
            <span>Awaiting</span>
            </div>
          </div>
    
    <div class="stat-card info">
        <div class="stat-icon info">
            <i class="fas fa-truck"></i>
        </div>
        <div class="stat-number">
                  <?php 
                    $cargo = $conn->query("SELECT * FROM cargo_list where `status` = 1 ")->num_rows;
                    echo format_num($cargo);
                  ?>
              </div>
        <div class="stat-label">In-Transit</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>Moving</span>
            </div>
          </div>
    
    <div class="stat-card secondary">
        <div class="stat-icon secondary">
            <i class="fas fa-building"></i>
        </div>
        <div class="stat-number">
                  <?php 
                    $cargo = $conn->query("SELECT * FROM cargo_list where `status` = 2 ")->num_rows;
                    echo format_num($cargo);
                  ?>
              </div>
        <div class="stat-label">At Station</div>
        <div class="stat-change">
            <i class="fas fa-pause"></i>
            <span>Arrived</span>
            </div>
          </div>
    
    <div class="stat-card primary">
        <div class="stat-icon primary">
            <i class="fas fa-shipping-fast"></i>
        </div>
        <div class="stat-number">
                  <?php 
                    $cargo = $conn->query("SELECT * FROM cargo_list where `status` = 3 ")->num_rows;
                    echo format_num($cargo);
                  ?>
              </div>
        <div class="stat-label">Out for Delivery</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>Delivering</span>
            </div>
          </div>
    
    <div class="stat-card success">
        <div class="stat-icon success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-number">
                  <?php 
                    $cargo = $conn->query("SELECT * FROM cargo_list where `status` = 4 ")->num_rows;
                    echo format_num($cargo);
                  ?>
              </div>
        <div class="stat-label">Delivered</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>Completed</span>
            </div>
          </div>
        </div>

<!-- Quick Actions -->
<div class="quick-actions">
    <a href="?page=transactions/manage_transaction" class="quick-action-btn">
        <i class="fas fa-plus quick-action-icon"></i>
        <span class="fw-bold">Add New Shipment</span>
    </a>
    <a href="?page=transactions" class="quick-action-btn">
        <i class="fas fa-list quick-action-icon"></i>
        <span class="fw-bold">View All Shipments</span>
    </a>
    <a href="?page=cargo_types" class="quick-action-btn">
        <i class="fas fa-th-list quick-action-icon"></i>
        <span class="fw-bold">Manage Cargo Types</span>
    </a>
    <a href="?page=user/list" class="quick-action-btn">
        <i class="fas fa-users quick-action-icon"></i>
        <span class="fw-bold">Manage Users</span>
    </a>
</div>
<!-- Banner Carousel Section -->
<div class="container-fluid">
  <?php 
    $files = array();
      $fopen = scandir(base_app.'uploads/banner');
      foreach($fopen as $fname){
        if(in_array($fname,array('.','..')))
          continue;
        $files[]= validate_image('uploads/banner/'.$fname);
      }
  ?>
    <?php if(!empty($files)): ?>
    <div id="adminCarousel" class="carousel slide banner-carousel" data-ride="carousel" data-interval="3000">
        <div class="carousel-inner">
          <?php foreach($files as $k => $img): ?>
            <div class="carousel-item <?php echo $k == 0? 'active': '' ?>">
                <img class="d-block w-100" src="<?php echo $img ?>" alt="Banner <?php echo $k + 1 ?>">
          </div>
          <?php endforeach; ?>
      </div>
        <a class="carousel-control-prev" href="#adminCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
      </a>
        <a class="carousel-control-next" href="#adminCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
      </a>
        <ol class="carousel-indicators">
            <?php foreach($files as $k => $img): ?>
            <li data-target="#adminCarousel" data-slide-to="<?php echo $k ?>" class="<?php echo $k == 0? 'active': '' ?>"></li>
            <?php endforeach; ?>
        </ol>
  </div>
    <?php endif; ?>
</div>

<script>
    $(function(){
        // Scroll handlers
        
        // Stat card handlers
        
        // Enhanced Carousel Functionality
        $('#adminCarousel').on('slide.bs.carousel', function (e) {
            // Smooth carousel transitions
        });
        
        // Pause carousel on hover
        $('#adminCarousel').hover(
            function() {
                $(this).carousel('pause');
            },
            function() {
                $(this).carousel('cycle');
            }
        );
        
        // Quick action button handlers
        
        // Stat number handlers
    });
</script>
