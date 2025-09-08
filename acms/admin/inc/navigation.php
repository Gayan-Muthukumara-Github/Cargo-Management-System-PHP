<style>
  /* Modern Admin Sidebar */
  .main-sidebar {
    background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1028;
    transition: var(--admin-transition);
    width: 250px;
  }
  
  .brand-link {
    background: rgba(255, 255, 255, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
  }
  
  .brand-link:hover {
    background: rgba(255, 255, 255, 0.15);
    text-decoration: none;
  }
  
  .brand-image {
    width: 40px;
    height: 40px;
    border-radius: var(--admin-radius);
    box-shadow: var(--admin-shadow);
  }
  
  .brand-text {
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
  }
  
  .sidebar {
    height: calc(100vh - 80px);
    overflow-y: auto;
    padding: 1rem 0;
  }
  
  .sidebar::-webkit-scrollbar {
    width: 4px;
  }
  
  .sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
  }
  
  .sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
  }
  
  .nav-sidebar {
    padding: 0 1rem;
  }
  
  .nav-item {
    margin-bottom: 0.25rem;
  }
  
  .nav-link {
    color: rgba(255, 255, 255, 0.8);
    padding: 0.75rem 1rem;
    border-radius: var(--admin-radius);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    position: relative;
    overflow: hidden;
  }
  
  
  .nav-link:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
    text-decoration: none;
  }
  
  .nav-link.active {
    color: white;
    background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
  }
  
  
  .nav-icon {
    font-size: 1.1rem;
    width: 20px;
    text-align: center;
  }
  
  .nav-link p {
    margin: 0;
    font-weight: 500;
  }
  
  .nav-header {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 1rem 1rem 0.5rem;
    margin-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
  }
  
  /* Sidebar collapse animation */
  .sidebar-collapse .main-sidebar {
    display: none;
  }
  
  @media (max-width: 768px) {
    .main-sidebar {
      display: none;
    }
    
    .sidebar-open .main-sidebar {
      display: block;
    }
  }
  
  /* Sidebar overlay for mobile */
  .sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1027;
    display: none;
  }
  
  .sidebar-open .sidebar-overlay {
    display: block;
  }
</style>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo base_url ?>admin" class="brand-link">
    <img src="<?php echo validate_image($_settings->info('logo'))?>" 
         alt="Admin Logo" 
         class="brand-image">
    <span class="brand-text"><?php echo $_settings->info('short_name') ?></span>
  </a>
  
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="./" class="nav-link nav-home">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo base_url ?>admin/?page=warehouse" class="nav-link nav-warehouse">
            <i class="nav-icon fas fa-warehouse"></i>
            <p>Warehouse</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo base_url ?>admin/?page=transactions/manage_transaction" class="nav-link nav-transactions_manage_transaction">
            <i class="nav-icon fas fa-plus"></i>
            <p>Add New Shipment</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo base_url ?>admin/?page=transactions" class="nav-link nav-transactions">
            <i class="nav-icon fas fa-truck-loading"></i>
            <p>Shipment List</p>
          </a>
        </li>
        
        <?php if($_settings->userdata('type') == 1): ?>
        <li class="nav-header">Maintenance</li>
        <li class="nav-item">
          <a href="<?php echo base_url ?>admin/?page=analytics" class="nav-link nav-analytics">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>Analytics & Reports</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo base_url ?>admin/?page=cargo_types" class="nav-link nav-cargo_types">
            <i class="nav-icon fas fa-th-list"></i>
            <p>Cargo Types</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Users</p>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Settings</p>
          </a>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</aside>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay"></div>
<script>
$(document).ready(function(){
  var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
  page = page.replace(/\//g,'_');
  console.log(page)

  if($('.nav-link.nav-'+page).length > 0){
    $('.nav-link.nav-'+page).addClass('active')
    if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
      $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
      $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
    }
    if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
      $('.nav-link.nav-'+page).parent().addClass('menu-open')
    }
  }
  
  // Nav link handlers
  
  // Nav link click handlers
  
  // Mobile sidebar toggle
  $('[data-widget="pushmenu"]').click(function() {
    $('body').toggleClass('sidebar-open');
  });
  
  // Close sidebar when clicking overlay
  $('.sidebar-overlay').click(function() {
    $('body').removeClass('sidebar-open');
  });
  
  // Close sidebar when clicking outside on mobile
  $(document).click(function(e) {
    if($(window).width() <= 768) {
      if(!$(e.target).closest('.main-sidebar, [data-widget="pushmenu"]').length) {
        $('body').removeClass('sidebar-open');
      }
    }
  });
});
</script>