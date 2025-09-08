<?php require_once('../config.php'); ?>
 <!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
  <body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs text-sm" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
  
  <style>
    /* Modern Admin Panel Design System */
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
    }
    
    /* Global Admin Styles */
    .content-wrapper {
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      min-height: 100vh;
    }
    
    .content {
      background: transparent;
      padding: 0;
    }
    
    .container-fluid {
      padding: 1.5rem;
    }
    
    /* Modern Card System */
    .card {
      border: none;
      border-radius: var(--admin-radius-lg);
      box-shadow: var(--admin-shadow);
      background: white;
      overflow: hidden;
    }
    
   
    
    .card-header {
      background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
      color: white;
      border: none;
      padding: 1.5rem 2rem;
      border-radius: var(--admin-radius-lg) var(--admin-radius-lg) 0 0;
    }
    
    .card-title {
      font-weight: 600;
      font-size: 1.25rem;
      margin: 0;
    }
    
    .card-body {
      padding: 2rem;
    }
    
    .card-footer {
      background: var(--admin-light);
      border-top: 1px solid var(--admin-border);
      padding: 1.5rem 2rem;
      border-radius: 0 0 var(--admin-radius-lg) var(--admin-radius-lg);
    }
    
    /* Modern Button System */
    .btn {
      border-radius: var(--admin-radius);
      font-weight: 500;
      padding: 0.75rem 1.5rem;
      border: none;
      position: relative;
      overflow: hidden;
    }
    
    
    
    .btn-primary {
      background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
      color: white;
      box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }
    
    .btn-primary:hover {
      box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
      color: white;
    }
    
    .btn-secondary {
      background: var(--admin-secondary);
      color: white;
    }
    
    .btn-success {
      background: linear-gradient(135deg, var(--admin-success) 0%, #059669 100%);
      color: white;
    }
    
    .btn-warning {
      background: linear-gradient(135deg, var(--admin-warning) 0%, #d97706 100%);
      color: white;
    }
    
    .btn-danger {
      background: linear-gradient(135deg, var(--admin-danger) 0%, #dc2626 100%);
      color: white;
    }
    
    .btn-info {
      background: linear-gradient(135deg, var(--admin-info) 0%, #0891b2 100%);
      color: white;
    }
    
    .btn-light {
      background: var(--admin-light);
      color: var(--admin-dark);
      border: 1px solid var(--admin-border);
    }
    
    .btn-sm {
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
    }
    
    .btn-flat {
      box-shadow: none;
    }
    
    .btn-flat:hover {
      box-shadow: var(--admin-shadow);
    }
    
    /* Modern Form Controls */
    .form-control {
      border: 2px solid var(--admin-border);
      border-radius: var(--admin-radius);
      padding: 0.75rem 1rem;
      background: white;
    }
    
    .form-control:focus {
      border-color: var(--admin-primary);
      box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
      background: white;
    }
    
    .form-control-sm {
      padding: 0.25rem 0.75rem;
      font-size: 0.875rem;
    }
    
    .form-control-border {
      border: 2px solid var(--admin-border);
    }
    
    /* Modern Table System */
    .table {
      border-radius: var(--admin-radius);
      overflow: hidden;
      box-shadow: var(--admin-shadow);
    }
    
    .table thead th {
      background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
      color: white;
      border: none;
      font-weight: 600;
      padding: 1rem;
      text-transform: uppercase;
      font-size: 0.875rem;
      letter-spacing: 0.05em;
    }
    
    .table tbody td {
      border-color: var(--admin-border);
      padding: 1rem;
      vertical-align: middle;
      background: white;
    }
    
    
    .table tbody tr:hover {
      background-color: #f8fafc;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
      background-color: rgba(248, 250, 252, 0.5);
    }
    
    /* Modern Badge System */
    .badge {
      border-radius: 50px;
      padding: 0.5rem 1rem;
      font-weight: 500;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
    
    .badge-primary {
      background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
    }
    
    .badge-success {
      background: linear-gradient(135deg, var(--admin-success) 0%, #059669 100%);
    }
    
    .badge-warning {
      background: linear-gradient(135deg, var(--admin-warning) 0%, #d97706 100%);
    }
    
    .badge-danger {
      background: linear-gradient(135deg, var(--admin-danger) 0%, #dc2626 100%);
    }
    
    .badge-info {
      background: linear-gradient(135deg, var(--admin-info) 0%, #0891b2 100%);
    }
    
    .badge-secondary {
      background: var(--admin-secondary);
    }
    
    .badge-light {
      background: var(--admin-light);
      color: var(--admin-dark);
      border: 1px solid var(--admin-border);
    }
    
    /* Modern Modal System */
    .modal-content {
      border: none;
      border-radius: var(--admin-radius-lg);
      box-shadow: var(--admin-shadow-xl);
      overflow: hidden;
    }
    
    .modal-header {
      background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
      color: white;
      border: none;
      padding: 1.5rem 2rem;
    }
    
    .modal-title {
      font-weight: 600;
      font-size: 1.25rem;
    }
    
    .modal-body {
      padding: 2rem;
    }
    
    .modal-footer {
      background: var(--admin-light);
      border-top: 1px solid var(--admin-border);
      padding: 1.5rem 2rem;
    }
    
    /* Modern Alert System */
    .alert {
      border: none;
      border-radius: var(--admin-radius);
      padding: 1rem 1.5rem;
      margin-bottom: 1.5rem;
      font-weight: 500;
    }
    
    .alert-success {
      background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
      color: #065f46;
    }
    
    .alert-danger {
      background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
      color: #991b1b;
    }
    
    .alert-warning {
      background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
      color: #92400e;
    }
    
    .alert-info {
      background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
      color: #1e40af;
    }
    
    
    
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .container-fluid {
        padding: 1rem;
      }
      
      .card-body {
        padding: 1.5rem;
      }
      
      .modal-body {
        padding: 1.5rem;
      }
      
      .modal-footer {
        padding: 1rem 1.5rem;
      }
      
      .table-responsive {
        border-radius: var(--admin-radius);
      }
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }
    
    ::-webkit-scrollbar-track {
      background: var(--admin-light);
    }
    
    ::-webkit-scrollbar-thumb {
      background: var(--admin-border);
      border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: var(--admin-secondary);
    }
  </style>
  
    <div class="wrapper">
     <?php require_once('inc/topBarNav.php') ?>
     <?php require_once('inc/navigation.php') ?>
     <?php if($_settings->chk_flashdata('success')): ?>
    <script>
      alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
    </script>
    <?php endif;?>      
     <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home';  ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper  pt-3" style="min-height: 567.854px;">
     
        <!-- Main content -->
        <section class="content  text-dark">
          <div class="container-fluid">
            <?php 
              if(!file_exists($page.".php") && !is_dir($page)){
                  include '404.html';
              }else{
                if(is_dir($page))
                  include $page.'/index.php';
                else
                  include $page.'.php';

              }
            ?>
          </div>
        </section>
        <!-- /.content -->
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-flat btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-sm btn-flat btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-flat btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-sm btn-flat btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
      </div>
      <!-- /.content-wrapper -->
      <?php require_once('inc/footer.php') ?>
      
      <script>
         $(function(){
           // Content loaded
          
           // Button click handlers
          
           // Modal functionality
          
           // Table row interactions
          
          // Add smooth scrolling for anchor links
          $('a[href^="#"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if( target.length ) {
              event.preventDefault();
              $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
              }, 1000);
            }
          });
          
           // Button click handlers
          
          // Add focus effects to form controls
          $('.form-control').on('focus', function() {
            $(this).parent().addClass('focused');
          }).on('blur', function() {
            if($(this).val() === '') {
              $(this).parent().removeClass('focused');
            }
          });
          
          // Initialize tooltips and popovers
          $('[data-toggle="tooltip"]').tooltip();
          $('[data-toggle="popover"]').popover();
          
           // DataTables initialization
        });
        
      </script>
  </body>
</html>
