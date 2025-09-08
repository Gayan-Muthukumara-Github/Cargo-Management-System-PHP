<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  <style>
    /* Modern Admin Login Styles */
    :root {
      --admin-primary: #2563eb;
      --admin-primary-dark: #1d4ed8;
      --admin-secondary: #64748b;
      --admin-success: #10b981;
      --admin-warning: #f59e0b;
      --admin-danger: #ef4444;
      --admin-info: #06b6d4;
      --admin-light: #f8fafc;
      --admin-dark: #1e293b;
      --admin-border: #e2e8f0;
      --admin-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --admin-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --admin-shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      --admin-radius: 12px;
      --admin-radius-lg: 16px;
      --admin-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    body {
      background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      background-blend-mode: overlay;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }
    
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(37, 99, 235, 0.8) 0%, rgba(29, 78, 216, 0.9) 100%);
      z-index: 1;
    }
    
    .login-container {
      position: relative;
      z-index: 2;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }
    
    .login-card {
      background: white;
      border-radius: var(--admin-radius-lg);
      box-shadow: var(--admin-shadow-xl);
      overflow: hidden;
      width: 100%;
      max-width: 400px;
      position: relative;
    }
    
    
    .login-header {
      background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
      color: white;
      padding: 2rem;
      text-align: center;
      position: relative;
    }
    
    .login-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="300" fill="url(%23a)"/><circle cx="800" cy="300" r="200" fill="url(%23a)"/><circle cx="400" cy="700" r="250" fill="url(%23a)"/></svg>');
      opacity: 0.3;
    }
    
    .login-header-content {
      position: relative;
      z-index: 2;
    }
    
    .login-logo {
      width: 80px;
      height: 80px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: var(--admin-radius-lg);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      backdrop-filter: blur(10px);
      box-shadow: var(--admin-shadow);
    }
    
    .login-logo i {
      font-size: 2rem;
    }
    
    .login-title {
      font-size: 1.75rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }
    
    .login-subtitle {
      opacity: 0.9;
      font-size: 1rem;
    }
    
    .login-body {
      padding: 2rem;
    }
    
    .form-group-modern {
      margin-bottom: 1.5rem;
    }
    
    .form-control-modern {
      border: 2px solid var(--admin-border);
      border-radius: var(--admin-radius);
      padding: 1rem 1.5rem;
      font-size: 1rem;
      background: var(--admin-light);
    }
    
    .form-control-modern:focus {
      border-color: var(--admin-primary);
      box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
      background: white;
    }
    
    .input-group-modern {
      position: relative;
    }
    
    .input-group-modern .form-control-modern {
      padding-left: 3rem;
    }
    
    .input-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      color: var(--admin-secondary);
      z-index: 3;
    }
    
    .btn-login {
      background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
      color: white;
      border: none;
      padding: 1rem 2rem;
      border-radius: var(--admin-radius);
      font-weight: 600;
      font-size: 1rem;
      box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
      width: 100%;
      position: relative;
      overflow: hidden;
    }
    
    
    .btn-login:hover {
      box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
      color: white;
    }
    
    .btn-login:active {
    }
    
    .login-footer {
      text-align: center;
      padding: 1rem 2rem 2rem;
      border-top: 1px solid var(--admin-border);
    }
    
    .login-link {
      color: var(--admin-primary);
      text-decoration: none;
      font-weight: 500;
    }
    
    .login-link:hover {
      color: var(--admin-primary-dark);
      text-decoration: none;
    }
    
    .floating-shapes {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      pointer-events: none;
      z-index: 1;
    }
    
    .shape {
      position: absolute;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
    }
    
    .shape:nth-child(1) {
      width: 80px;
      height: 80px;
      top: 20%;
      left: 10%;
    }
    
    .shape:nth-child(2) {
      width: 120px;
      height: 120px;
      top: 60%;
      right: 10%;
    }
    
    .shape:nth-child(3) {
      width: 60px;
      height: 60px;
      bottom: 20%;
      left: 20%;
    }
    
    
    .focused .form-control-modern {
      border-color: var(--admin-primary);
      box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
    }
    
    @media (max-width: 768px) {
      .login-container {
        padding: 1rem;
      }
      
      .login-card {
        max-width: 100%;
      }
      
      .login-header {
        padding: 1.5rem;
      }
      
      .login-body {
        padding: 1.5rem;
      }
    }
  </style>
  
  <div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
  </div>
  
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <div class="login-header-content">
          <div class="login-logo">
            <i class="fas fa-shield-alt"></i>
            </div>
          <h1 class="login-title"><?php echo $_settings->info('name') ?></h1>
          <p class="login-subtitle">Admin Panel Access</p>
          </div>
        </div>
      
      <div class="login-body">
        <form id="login-frm" action="" method="post">
          <div class="form-group-modern">
            <div class="input-group-modern">
              <i class="fas fa-user input-icon"></i>
              <input type="text" 
                     class="form-control form-control-modern" 
                     name="username" 
                     autofocus 
                     placeholder="Enter your username"
                     required>
            </div>
          </div>
          
          <div class="form-group-modern">
            <div class="input-group-modern">
              <i class="fas fa-lock input-icon"></i>
              <input type="password" 
                     class="form-control form-control-modern" 
                     name="password" 
                     placeholder="Enter your password"
                     required>
        </div>
          </div>
          
          <button type="submit" class="btn btn-login">
            <i class="fas fa-sign-in-alt me-2"></i>Sign In
          </button>
        </form>
        </div>
      
      <div class="login-footer">
        <a href="<?php echo base_url ?>" class="login-link">
          <i class="fas fa-arrow-left me-1"></i>Back to Website
        </a>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function(){
    end_loader();
    
    // Login form handler
    $('#login-frm').submit(function(e){
      var $btn = $('.btn-login');
      var originalText = $btn.html();
      $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Signing In...');
      $btn.prop('disabled', true);
    });
    
    // Add focus effects to form inputs
    $('.form-control-modern').on('focus', function(){
      $(this).parent().addClass('focused');
    }).on('blur', function(){
      if($(this).val() === '') {
        $(this).parent().removeClass('focused');
      }
    });
    
    // Add floating label effect
    $('.form-control-modern').each(function(){
      if($(this).val() !== '') {
        $(this).parent().addClass('focused');
      }
    });
    
    // Login button handler
    
    // Login validation
    
  });
</script>
</body>
</html>