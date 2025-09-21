<style>
    /* Modern Contact Page Styles */
    .contact-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="300" fill="url(%23a)"/><circle cx="800" cy="300" r="200" fill="url(%23a)"/><circle cx="400" cy="700" r="250" fill="url(%23a)"/></svg>');
        opacity: 0.3;
    }
    
    .contact-content {
        position: relative;
        z-index: 2;
    }
    
    .contact-form-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow-xl);
        border: none;
        overflow: hidden;
        margin-top: 50px;
        position: relative;
        z-index: 3;
    }
    
    .contact-form-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .contact-form-body {
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
    
    .form-control-modern.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .btn-contact {
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
    
    .btn-contact:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        color: white;
    }
    
    .contact-info-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .contact-info-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .contact-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-md);
    }
    
    .contact-details {
        background: var(--light-bg);
        padding: 4rem 0;
    }
    
    .map-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        height: 400px;
    }
    
    .map-placeholder {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 1.1rem;
    }
    
    .social-links {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }
    
    .social-link {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
    }
    
    .social-link:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        color: white;
        text-decoration: none;
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
        .contact-form-body {
            padding: 2rem 1.5rem;
        }
        
        .contact-hero {
            padding: 2rem 0;
        }
        
        .banner-slide {
            height: 40vh;
            min-height: 300px;
        }
        
        .social-links {
            flex-wrap: wrap;
        }
    }
</style>

<!-- Contact Form Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="contact-form-card">
                    <div class="contact-form-header">
                        <h3 class="mb-0">
                            <i class="fas fa-paper-plane me-2"></i>Send us a Message
                        </h3>
                        <p class="mb-0 mt-2 opacity-75">We'll get back to you within 24 hours</p>
                    </div>
                    <div class="contact-form-body">
                        <form id="contact-form">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label fw-bold mb-2">
                                            <i class="fas fa-user me-2"></i>Full Name *
                                        </label>
                                        <input type="text" 
                                               class="form-control form-control-modern" 
                                               name="name" 
                                               id="name"
                                               placeholder="Enter your full name"
                                               required>
                                        <div class="invalid-feedback">
                                            Please provide a valid name.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label fw-bold mb-2">
                                            <i class="fas fa-envelope me-2"></i>Email Address *
                                        </label>
                                        <input type="email" 
                                               class="form-control form-control-modern" 
                                               name="email" 
                                               id="email"
                                               placeholder="Enter your email address"
                                               required>
                                        <div class="invalid-feedback">
                                            Please provide a valid email address.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label fw-bold mb-2">
                                            <i class="fas fa-phone me-2"></i>Phone Number
                                        </label>
                                        <input type="tel" 
                                               class="form-control form-control-modern" 
                                               name="phone" 
                                               id="phone"
                                               placeholder="Enter your phone number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject" class="form-label fw-bold mb-2">
                                            <i class="fas fa-tag me-2"></i>Subject *
                                        </label>
                                        <input type="text" 
                                               class="form-control form-control-modern" 
                                               name="subject" 
                                               id="subject"
                                               placeholder="Enter your subject"
                                               required>
                                        <div class="invalid-feedback">
                                            Please provide a subject.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="message" class="form-label fw-bold mb-2">
                                            <i class="fas fa-comment me-2"></i>Message *
                                        </label>
                                        <textarea class="form-control form-control-modern" 
                                                  name="message" 
                                                  id="message" 
                                                  rows="5"
                                                  placeholder="Tell us how we can help you..."
                                                  required></textarea>
                                        <div class="invalid-feedback">
                                            Please provide a message.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-contact">
                                        <i class="fas fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information Section -->
<section class="contact-details">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-3">Get in Touch</h2>
                <p class="lead text-muted">Choose your preferred way to contact us</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="contact-info-card text-center">
                    <div class="contact-icon mx-auto">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Visit Our Office</h5>
                    <p class="text-muted mb-3">
                        123 Business District<br>
                        City, State 12345<br>
                        United States
                    </p>
                    <a href="#" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-directions me-1"></i>Get Directions
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact-info-card text-center">
                    <div class="contact-icon mx-auto">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Call Us</h5>
                    <p class="text-muted mb-3">
                        <strong>Main Office:</strong><br>
                        +1 (555) 123-4567<br>
                        <strong>Support:</strong><br>
                        +1 (555) 123-4568
                    </p>
                    <a href="tel:+15551234567" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-phone me-1"></i>Call Now
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact-info-card text-center">
                    <div class="contact-icon mx-auto">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Email Us</h5>
                    <p class="text-muted mb-3">
                        <strong>General:</strong><br>
                        info@acms.com<br>
                        <strong>Support:</strong><br>
                        support@acms.com
                    </p>
                    <a href="mailto:info@acms.com" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-envelope me-1"></i>Send Email
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Business Hours -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <div class="contact-info-card">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <div class="contact-icon mx-auto">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h5 class="fw-bold mb-3">Business Hours</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="mb-2"><strong>Monday - Friday:</strong><br>8:00 AM - 6:00 PM</p>
                                    <p class="mb-2"><strong>Saturday:</strong><br>9:00 AM - 4:00 PM</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="mb-2"><strong>Sunday:</strong><br>Closed</p>
                                    <p class="mb-0"><strong>Emergency:</strong><br>24/7 Support Available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-3">Find Us</h2>
                <p class="lead text-muted">Visit our office location</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="map-container">
                    <div class="map-placeholder">
                        <div class="text-center">
                            <i class="fas fa-map-marked-alt fa-3x mb-3 text-primary"></i>
                            <h5>Interactive Map</h5>
                            <p class="mb-0">Map integration can be added here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Social Media Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-3">Follow Us</h2>
                <p class="lead text-muted mb-4">Stay connected with us on social media for updates and news</p>
                <div class="social-links">
                    <a href="#" class="social-link">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(function(){
        // Contact form validation and submission
        $('#contact-form').submit(function(e){
            e.preventDefault();
            
            var isValid = true;
            var form = $(this);
            
            // Reset previous validation states
            form.find('.form-control-modern').removeClass('is-invalid');
            form.find('.invalid-feedback').hide();
            
            // Validate required fields
            form.find('[required]').each(function(){
                var field = $(this);
                var value = field.val().trim();
                
                if(value === '') {
                    field.addClass('is-invalid');
                    field.siblings('.invalid-feedback').show();
                    isValid = false;
                }
            });
            
            // Validate email format
            var email = $('#email').val().trim();
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(email && !emailRegex.test(email)) {
                $('#email').addClass('is-invalid');
                $('#email').siblings('.invalid-feedback').text('Please provide a valid email address.').show();
                isValid = false;
            }
            
            if(isValid) {
                // Add loading state to button
                var $btn = $('.btn-contact');
                var originalText = $btn.html();
                $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Sending...');
                $btn.prop('disabled', true);
                
                // Get form data
                var formData = {
                    name: $('#name').val().trim(),
                    email: $('#email').val().trim(),
                    phone: $('#phone').val().trim(),
                    subject: $('#subject').val().trim(),
                    message: $('#message').val().trim()
                };
                
                // Send AJAX request
                $.ajax({
                    url: 'contact_handler.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if(response.success) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Message Sent!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });
                            
                            // Reset form
                            form[0].reset();
                        } else {
                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to send message. Please try again later.',
                            confirmButtonText: 'OK'
                        });
                    },
                    complete: function() {
                        // Reset button state
                        $btn.html(originalText);
                        $btn.prop('disabled', false);
                    }
                });
            }
        });
        
        // Real-time validation
        $('#contact-form .form-control-modern').on('blur', function(){
            var field = $(this);
            var value = field.val().trim();
            
            if(field.prop('required') && value === '') {
                field.addClass('is-invalid');
                field.siblings('.invalid-feedback').show();
            } else {
                field.removeClass('is-invalid');
                field.siblings('.invalid-feedback').hide();
            }
        });
        
        // Enhanced Carousel Functionality
        $('#contactCarousel').on('slide.bs.carousel', function (e) {
            // Smooth carousel transitions
        });
        
        // Pause carousel on hover
        $('#contactCarousel').hover(
            function() {
                $(this).carousel('pause');
            },
            function() {
                $(this).carousel('cycle');
            }
        );
        
        // Add animations on scroll
        $(window).scroll(function() {
            $('.contact-info-card').each(function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('fade-in');
                }
            });
        });
        
        // Add hover effects to contact cards
        $('.contact-info-card').hover(
            function() {
                $(this).find('.contact-icon').addClass('animate__animated animate__pulse');
            },
            function() {
                $(this).find('.contact-icon').removeClass('animate__animated animate__pulse');
            }
        );
        
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
    });
</script>
