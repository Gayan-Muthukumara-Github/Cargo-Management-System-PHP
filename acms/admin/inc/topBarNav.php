<style>
  /* Modern Admin Top Navigation */
  .main-header {
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: none;
    position: sticky;
    top: 0;
    z-index: 1030;
    backdrop-filter: blur(10px);
  }
  
  .navbar-nav .nav-link {
    color: var(--admin-dark);
    font-weight: 500;
    padding: 0.75rem 1rem;
  }
  
  .navbar-nav .nav-link:hover {
    color: var(--admin-primary);
    background: rgba(37, 99, 235, 0.1);
    border-radius: var(--admin-radius);
  }
  
  .navbar-brand {
    font-weight: 700;
    color: var(--admin-primary);
    font-size: 1.25rem;
  }
  
  .navbar-brand:hover {
    color: var(--admin-primary-dark);
  }
  
  .user-dropdown {
    position: relative;
  }
  
  .user-dropdown-btn {
    background: white;
    border: 2px solid var(--admin-border);
    border-radius: 50px;
    padding: 0.5rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: var(--admin-shadow);
  }
  
  .user-dropdown-btn:hover {
    border-color: var(--admin-primary);
    box-shadow: var(--admin-shadow-lg);
  }
  
  .user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--admin-primary);
  }
  
  .user-name {
    font-weight: 600;
    color: var(--admin-dark);
    font-size: 0.9rem;
  }
  
  .dropdown-menu {
    border: none;
    border-radius: var(--admin-radius-lg);
    box-shadow: var(--admin-shadow-xl);
    padding: 0.5rem 0;
    margin-top: 0.5rem;
    min-width: 200px;
  }
  
  
  .dropdown-item {
    padding: 0.75rem 1.5rem;
    color: var(--admin-dark);
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .dropdown-item:hover {
    background: var(--admin-light);
    color: var(--admin-primary);
  }
  
  .dropdown-divider {
    margin: 0.5rem 0;
    border-color: var(--admin-border);
  }
  
  .menu-toggle {
    background: none;
    border: none;
    color: var(--admin-dark);
    font-size: 1.25rem;
    padding: 0.5rem;
    border-radius: var(--admin-radius);
  }
  
  .menu-toggle:hover {
    background: var(--admin-light);
    color: var(--admin-primary);
  }
  
  .navbar-search {
    position: relative;
  }
  
  .search-input {
    border: 2px solid var(--admin-border);
    border-radius: 50px;
    padding: 0.5rem 1rem 0.5rem 2.5rem;
    background: var(--admin-light);
    width: 250px;
  }
  
  .search-input:focus {
    border-color: var(--admin-primary);
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
    background: white;
  }
  
  .search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    color: var(--admin-secondary);
  }
  
  @media (max-width: 768px) {
    .user-name {
      display: none;
    }
    
    .search-input {
      width: 200px;
    }
    
    .navbar-nav .nav-link {
      padding: 0.5rem;
    }
  }
</style>

<!-- Modern Admin Navbar -->
<nav class="main-header navbar navbar-expand navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <button class="menu-toggle" data-widget="pushmenu" type="button">
        <i class="fas fa-bars"></i>
      </button>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo base_url ?>" class="navbar-brand">
        <i class="fas fa-tachometer-alt me-2"></i>
        <?php echo (!isMobileDevice()) ? $_settings->info('name'):$_settings->info('short_name'); ?> - Admin
      </a>
    </li>
  </ul>
  

  
  <!-- Right navbar links -->
  <ul class="navbar-nav ms-auto">
    
    <!-- User Dropdown -->
    <li class="nav-item dropdown user-dropdown">
      <button class="user-dropdown-btn" data-toggle="dropdown" type="button">
        <img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" 
             class="user-avatar" 
             alt="User Avatar">
        <span class="user-name"><?php echo ucwords($_settings->userdata('firstname').' '.$_settings->userdata('lastname')) ?></span>
        <i class="fas fa-chevron-down"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-header text-center">
          <img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" 
               class="user-avatar mb-2" 
               alt="User Avatar">
          <h6 class="mb-0"><?php echo ucwords($_settings->userdata('firstname').' '.$_settings->userdata('lastname')) ?></h6>
          <small class="text-muted">Administrator</small>
        </div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo base_url.'admin/?page=user' ?>">
          <i class="fas fa-user me-2"></i> My Account
        </a>
        <a class="dropdown-item" href="<?php echo base_url.'admin/?page=system_info' ?>">
          <i class="fas fa-cog me-2"></i> Settings
        </a>
        <a class="dropdown-item" href="<?php echo base_url ?>">
          <i class="fas fa-globe me-2"></i> View Website
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?php echo base_url.'/classes/Login.php?f=logout' ?>">
          <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>

<script>
$(function(){
  // Global search functionality
  $('#globalSearch').on('keyup', function() {
    var searchTerm = $(this).val();
    if(searchTerm.length > 2) {
      // Implement search functionality here
      console.log('Searching for:', searchTerm);
    }
  });
  
  // Dropdown item handlers
  
  // Button click handlers
});
</script>