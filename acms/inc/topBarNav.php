<nav class="navbar navbar-expand-lg modern-navbar sticky-top">
            <div class="container px-4 px-lg-5">
                <button class="navbar-toggler btn btn-sm border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="./">
                    <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Logo" loading="lazy">
                    <span><?php echo $_settings->info('short_name') ?></span>
                </a>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./">
                                <i class="fas fa-home me-2"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./?p=trace_form">
                                <i class="fas fa-search me-2"></i>Trace Shipment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./?p=about">
                                <i class="fas fa-info-circle me-2"></i>About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./?p=contact">
                                <i class="fas fa-envelope me-2"></i>Contact
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="./?p=trace_form" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-search me-1"></i>Quick Trace
                    </a>
                    <a href="./admin" class="admin-btn">
                        <i class="fas fa-cog me-1"></i>Admin Panel
                    </a>
                </div>
            </div>
        </nav>
<script>
  $(function(){
    $('#login-btn').click(function(){
      uni_modal("","login.php")
    })
    $('#navbarResponsive').on('show.bs.collapse', function () {
        $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function () {
        if($('body').offset.top == 0)
          $('#mainNav').removeClass('navbar-shrink')
    })
  })

  $('#search-form').submit(function(e){
    e.preventDefault()
     var sTxt = $('[name="search"]').val()
     if(sTxt != '')
      location.href = './?p=products&search='+sTxt;
  })
</script>