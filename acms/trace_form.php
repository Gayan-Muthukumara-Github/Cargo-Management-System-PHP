
<style>
    /* Modern Trace Form Styles */
    .trace-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .trace-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="300" fill="url(%23a)"/><circle cx="800" cy="300" r="200" fill="url(%23a)"/><circle cx="400" cy="700" r="250" fill="url(%23a)"/></svg>');
        opacity: 0.3;
    }
    
    .trace-content {
        position: relative;
        z-index: 2;
    }
    
    .trace-form-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow-xl);
        border: none;
        overflow: hidden;
        margin-top: 50px;
        position: relative;
        z-index: 3;
    }
    
    .trace-form-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .trace-form-body {
        padding: 3rem;
    }
    
    .form-control-modern {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    
    .form-control-modern:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        background: white;
    }
    
    .btn-trace {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
        width: 100%;
    }
    
    .btn-trace:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }
    
    .trace-features {
        background: var(--light-bg);
        padding: 4rem 0;
    }
    
    .feature-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .feature-icon-large {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        margin: 0 auto 1.5rem;
        box-shadow: var(--shadow-md);
    }
    
    .banner-slide {
        height: 50vh;
        min-height: 400px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }
    
    @media (max-width: 768px) {
        .trace-form-body {
            padding: 2rem 1.5rem;
        }
        
        .trace-hero {
            padding: 2rem 0;
        }
        
        .banner-slide {
            height: 40vh;
            min-height: 300px;
        }
    }
</style>
<?php 
?>


<!-- Trace Form Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="trace-form-card">
                    <div class="trace-form-header">
                        <h3 class="mb-0">
                            <i class="fas fa-shipping-fast me-2"></i>Shipment Tracking
                        </h3>
                        <p class="mb-0 mt-2 opacity-75">Enter your reference code below to track your cargo</p>
                    </div>
                    <div class="trace-form-body">
                        <form action="" id="trace-frm">
                            <div class="row g-4">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="ref_code" class="form-label fw-bold mb-2">
                                            <i class="fas fa-barcode me-2"></i>Shipment Reference Code
                                        </label>
                                        <input type="text" 
                                               class="form-control form-control-modern" 
                                               name="ref_code" 
                                               id="ref_code"
                                               placeholder="Enter your shipment reference code"
                                               required>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            You can find your reference code on your shipping receipt or confirmation email.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label mb-2">&nbsp;</label>
                                        <button type="submit" class="btn btn-trace">
                                            <i class="fas fa-search me-2"></i>Track Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="trace-features">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-3">Why Track With Us?</h2>
                <p class="lead text-muted">Experience the most comprehensive shipment tracking system available.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon-large">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Real-Time Updates</h5>
                    <p class="text-muted">Get instant notifications about your shipment's location and status changes as they happen.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon-large">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Location Tracking</h5>
                    <p class="text-muted">See exactly where your package is at any moment with our advanced GPS tracking technology.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon-large">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Smart Notifications</h5>
                    <p class="text-muted">Receive email and SMS alerts for important updates like delivery confirmations and delays.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
        // Trace form submission
        $('#trace-frm').submit(function(e){
            e.preventDefault();
            var refCode = $('#ref_code').val().trim();
            
            if(refCode === '') {
                // Add error styling
                $('#ref_code').addClass('is-invalid');
                return;
            }
            
            // Remove error styling
            $('#ref_code').removeClass('is-invalid');
            
            // Add loading state to button
            var $btn = $('.btn-trace');
            var originalText = $btn.html();
            $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Tracking...');
            $btn.prop('disabled', true);
            
            // Redirect to trace results
            setTimeout(function() {
                location.href = "./?p=trace&" + $(this).serialize();
            }.bind(this), 1000);
        });
        
        // Remove error styling on input
        $('#ref_code').on('input', function() {
            $(this).removeClass('is-invalid');
        });
        
        // Enhanced Carousel Functionality
        $('#traceCarousel').on('slide.bs.carousel', function (e) {
            // Smooth carousel transitions
        });
        
        // Pause carousel on hover
        $('#traceCarousel').hover(
            function() {
                $(this).carousel('pause');
            },
            function() {
                $(this).carousel('cycle');
            }
        );
        
        // Add animations on scroll
        $(window).scroll(function() {
            $('.feature-card').each(function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('fade-in');
                }
            });
        });
    });
</script>