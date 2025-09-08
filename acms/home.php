
<!-- Modern Banner Carousel -->
<section class="banner-section">
    <div id="modernCarousel" class="carousel slide" data-ride="carousel" data-interval="4000">
        <div class="carousel-inner">
            <?php 
                $upload_path = "uploads/banner";
                if(is_dir(base_app.$upload_path)): 
                $file= scandir(base_app.$upload_path);
                $_i = 0;
                    foreach($file as $img):
                        if(in_array($img,array('.','..')))
                            continue;
                $_i++;
            ?>
            <div class="carousel-item <?php echo $_i == 1 ? "active" : '' ?>">
                <div class="banner-slide" style="background-image: url('<?php echo validate_image($upload_path.'/'.$img) ?>');">
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-target="#modernCarousel" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#modernCarousel" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        
        <!-- Carousel Indicators -->
        <ol class="carousel-indicators">
            <?php 
            if(is_dir(base_app.$upload_path)): 
            $file= scandir(base_app.$upload_path);
            $_i = 0;
                foreach($file as $img):
                    if(in_array($img,array('.','..')))
                        continue;
            $_i++;
            ?>
            <li data-target="#modernCarousel" data-slide-to="<?php echo $_i-1 ?>" class="<?php echo $_i == 1 ? "active" : '' ?>"></li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ol>
    </div>
</section>

<!-- Features Section -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-3">Why Choose Our Platform?</h2>
                <p class="lead text-muted">Experience the future of cargo management with our cutting-edge features and reliable services.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card-modern h-100 text-center p-4">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-search"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Real-time Tracking</h5>
                    <p class="text-muted">Monitor your shipments in real-time with our advanced tracking system. Get instant updates on location and delivery status.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card-modern h-100 text-center p-4">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Secure & Safe</h5>
                    <p class="text-muted">Your cargo is protected with our comprehensive security measures and insurance coverage for peace of mind.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card-modern h-100 text-center p-4">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Fast Delivery</h5>
                    <p class="text-muted">Express delivery options ensure your packages reach their destination quickly and efficiently.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card-modern h-100 text-center p-4">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Global Network</h5>
                    <p class="text-muted">Connect with our worldwide network of partners for seamless international shipping and delivery.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card-modern h-100 text-center p-4">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Mobile Friendly</h5>
                    <p class="text-muted">Access all features on any device with our responsive design and mobile-optimized interface.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card-modern h-100 text-center p-4">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5 class="fw-bold mb-3">24/7 Support</h5>
                    <p class="text-muted">Round-the-clock customer support to assist you with any questions or concerns about your shipments.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-3">Our Services</h2>
                <p class="lead text-muted">Comprehensive cargo management solutions tailored to your needs.</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card-modern h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary rounded-circle p-3 me-3">
                                <i class="fas fa-city text-white"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">City to City</h5>
                        </div>
                        <p class="text-muted mb-3">Fast and reliable delivery within cities with same-day or next-day options.</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Same-day delivery</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Real-time tracking</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Secure handling</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-modern h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning rounded-circle p-3 me-3">
                                <i class="fas fa-map-marked-alt text-white"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">State to State</h5>
                        </div>
                        <p class="text-muted mb-3">Efficient interstate shipping with competitive rates and reliable delivery times.</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>2-3 day delivery</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Insurance included</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Status updates</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-modern h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success rounded-circle p-3 me-3">
                                <i class="fas fa-globe-americas text-white"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">International</h5>
                        </div>
                        <p class="text-muted mb-3">Global shipping solutions with customs handling and international tracking.</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Customs clearance</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Global tracking</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Documentation support</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section-padding bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">Ready to Ship Your Cargo?</h3>
                <p class="mb-0">Join thousands of satisfied customers who trust us with their shipments. Get started today!</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="./?p=trace_form" class="btn btn-light btn-lg">
                    <i class="fas fa-rocket me-2"></i>Get Started
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    $(function(){
        $('#search-frm').submit(function(e){
            e.preventDefault();
            location.href = "./?"+$(this).serialize()
        })
        
        // Add animations on scroll
        $(window).scroll(function() {
            $('.card-modern').each(function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('fade-in');
                }
            });
        });
        
        // Smooth scrolling for anchor links
        $('a[href^="#"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if( target.length ) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 80
                }, 1000);
            }
        });
        
        // Add hover effects to feature cards
        $('.card-modern').hover(
            function() {
                $(this).find('.feature-icon').addClass('animate__animated animate__pulse');
            },
            function() {
                $(this).find('.feature-icon').removeClass('animate__animated animate__pulse');
            }
        );
        
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Add loading animation to buttons
        $('.btn-modern, .admin-btn').click(function() {
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Loading...');
            $btn.prop('disabled', true);
            
            setTimeout(function() {
                $btn.html(originalText);
                $btn.prop('disabled', false);
            }, 2000);
        });
        
        // Enhanced Carousel Functionality
        $('#modernCarousel').on('slide.bs.carousel', function (e) {
            // Smooth carousel transitions
        });
        
        // Pause carousel on hover
        $('#modernCarousel').hover(
            function() {
                $(this).carousel('pause');
            },
            function() {
                $(this).carousel('cycle');
            }
        );
        
        // Add smooth transitions
        $('.carousel-item').each(function() {
            $(this).css('transition', 'all 0.6s ease-in-out');
        });
    });
</script>