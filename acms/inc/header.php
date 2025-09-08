<?php
  // require_once('sess_auth.php');
  
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<title><?php echo $_settings->info('title') != false ? $_settings->info('title').' | ' : '' ?><?php echo $_settings->info('name') ?></title>
    <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />
    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
      <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
   <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.css">
    <link rel="stylesheet" href="<?php echo base_url ?>dist/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url ?>assets/css/styles.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.css">
     <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <style type="text/css">/* Chart.js */
      @keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}
    </style>
    
    <!-- Custom Modern Styles -->
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #64748b;
            --accent-color: #f59e0b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-bg: #f8fafc;
            --dark-bg: #1e293b;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: var(--light-bg);
        }
        
        .modern-navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .navbar-brand img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            box-shadow: var(--shadow-md);
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }
        
        .admin-btn {
            background: linear-gradient(135deg, var(--accent-color) 0%, #d97706 100%);
            color: white !important;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
            border: none;
        }
        
        .admin-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
            color: white !important;
        }
        
        /* Modern Banner Carousel Styles */
        .banner-section {
            position: relative;
            overflow: hidden;
            margin-top: 3px;
        }
        
        .banner-slide {
            height: 70vh;
            min-height: 500px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }
        
        /* Carousel Controls */
        .carousel-control-prev,
        .carousel-control-next {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-50%) scale(1.1);
        }
        
        .carousel-control-prev {
            left: 30px;
        }
        
        .carousel-control-next {
            right: 30px;
        }
        
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 20px;
            height: 20px;
        }
        
        /* Carousel Indicators */
        .carousel-indicators {
            bottom: 30px;
            margin-bottom: 0;
        }
        
        .carousel-indicators li {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: none;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        
        .carousel-indicators li.active {
            background: white;
            transform: scale(1.2);
        }
        
        .carousel-indicators li:hover {
            background: rgba(255, 255, 255, 0.8);
        }
        
        /* Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Responsive Banner */
        @media (max-width: 768px) {
            .banner-slide {
                height: 60vh;
                min-height: 400px;
            }
            
            .carousel-control-prev,
            .carousel-control-next {
                width: 50px;
                height: 50px;
            }
            
            .carousel-control-prev {
                left: 15px;
            }
            
            .carousel-control-next {
                right: 15px;
            }
            
            .carousel-indicators {
                bottom: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .banner-slide {
                height: 50vh;
                min-height: 350px;
            }
            
            .banner-content h1 {
                font-size: 2rem !important;
            }
            
            .banner-content .lead {
                font-size: 1rem !important;
            }
        }
        
        .card-modern {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        .card-modern:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }
        
        .btn-modern {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }
        
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }
        
        .section-padding {
            padding: 4rem 0;
        }
        
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-md);
        }
        
        .footer-modern {
            background: var(--dark-bg);
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .footer-modern h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .footer-modern a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-modern a:hover {
            color: white;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
        }
        
        /* Additional Modern Styles */
        .bg-light {
            background-color: #f8fafc !important;
        }
        
        .text-muted {
            color: #64748b !important;
        }
        
        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
        }
        
        .sticky-top {
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        
        .display-4 {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
        }
        
        .display-5 {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
        }
        
        .lead {
            font-size: 1.25rem;
            font-weight: 400;
            line-height: 1.6;
        }
        
        .fw-bold {
            font-weight: 700 !important;
        }
        
        .rounded-4 {
            border-radius: 1rem !important;
        }
        
        .gap-3 {
            gap: 1rem !important;
        }
        
        .g-4 {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 1.5rem;
        }
        
        .g-4 > * {
            padding-right: calc(var(--bs-gutter-x) * 0.5);
            padding-left: calc(var(--bs-gutter-x) * 0.5);
            margin-top: var(--bs-gutter-y);
        }
        
        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }
        
        .slide-up {
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Hover Effects */
        .card-modern {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-modern:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .feature-icon {
            transition: all 0.3s ease;
        }
        
        .card-modern:hover .feature-icon {
            transform: scale(1.1);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 0;
            }
            
            .section-padding {
                padding: 2rem 0;
            }
            
            .display-4 {
                font-size: 2.5rem;
            }
            
            .display-5 {
                font-size: 2rem;
            }
            
            .lead {
                font-size: 1.1rem;
            }
            
            .navbar-brand {
                font-size: 1.25rem;
            }
            
            .navbar-brand img {
                width: 32px;
                height: 32px;
            }
        }
        
        @media (max-width: 576px) {
            .display-4 {
                font-size: 2rem;
            }
            
            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }
            
            .d-flex.gap-3 {
                flex-direction: column;
                gap: 0.75rem !important;
            }
        }
    </style>

     <!-- jQuery -->
    <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?php echo base_url ?>plugins/toastr/toastr.min.js"></script>
    <script>
        var _base_url_ = '<?php echo base_url ?>';
    </script>
    <script src="<?php echo base_url ?>dist/js/script.js"></script>
    <script src="<?php echo base_url ?>assets/js/scripts.js"></script>
    <style>
    /* Legacy header styles - keeping for compatibility */
    #main-header{
        position:relative;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
    }
    #main-header:before{
        content:"";
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-image:url(<?php echo base_url.$_settings->info('cover') ?>);
        background-repeat: no-repeat;
        background-size: cover;
        filter: drop-shadow(0px 7px 6px black);
        z-index:-1;
        opacity: 0.3;
    }
    </style>
  </head>