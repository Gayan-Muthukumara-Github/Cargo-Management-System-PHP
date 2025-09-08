
<style>
    /* Modern Trace Results Styles */
    .trace-results-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .trace-results-hero::before {
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
    
    .tracking-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow-xl);
        border: none;
        overflow: hidden;
        margin-top: 50px;
        position: relative;
        z-index: 3;
    }
    
    .tracking-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .tracking-body {
        padding: 3rem;
    }
    
    .ref-code-display {
        background: var(--light-bg);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-left: 4px solid var(--primary-color);
    }
    
    .timeline {
        position: relative;
        padding-left: 2rem;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, var(--primary-color), var(--primary-dark));
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .timeline-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -2.5rem;
        top: 1.5rem;
        width: 12px;
        height: 12px;
        background: var(--primary-color);
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 3px var(--primary-color);
    }
    
    .timeline-item:last-child::before {
        background: var(--success-color);
        box-shadow: 0 0 0 3px var(--success-color);
    }
    
    .timeline-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .timeline-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
    }
    
    .timeline-body {
        padding: 1.5rem;
    }
    
    .timeline-description {
        color: var(--text-muted);
        margin-bottom: 1rem;
        line-height: 1.6;
    }
    
    .timeline-date {
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .no-results {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow-md);
    }
    
    .no-results-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border-radius: 50%;
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
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-active {
        background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
        color: white;
    }
    
    .status-pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .status-completed {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
    }
    
    @media (max-width: 768px) {
        .tracking-body {
            padding: 2rem 1.5rem;
        }
        
        .trace-results-hero {
            padding: 2rem 0;
        }
        
        .banner-slide {
            height: 40vh;
            min-height: 300px;
        }
        
        .timeline {
            padding-left: 1.5rem;
        }
        
        .timeline-item::before {
            left: -1.75rem;
        }
    }
</style>
<?php
extract($_GET);
$qry = $conn->query("SELECT * from `cargo_list` where ref_code = '{$ref_code}' ");
if($qry->num_rows > 0){
    foreach($qry->fetch_assoc() as $k => $v){
        $$k=$v;
    }
}
?>
<!-- Modern Banner Carousel -->

<?php if(isset($id)): ?>


<!-- Tracking Results Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="tracking-card">
                    <div class="tracking-header">
                        <h3 class="mb-0">
                            <i class="fas fa-search me-2"></i>Tracking Information
                        </h3>
                        <p class="mb-0 mt-2 opacity-75">Complete shipment tracking history</p>
                    </div>
                    <div class="tracking-body">
                        <!-- Reference Code Display -->
                        <div class="ref-code-display">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="mb-2">
                                        <i class="fas fa-barcode me-2"></i>Shipment Reference Code
                                    </h5>
                                    <h3 class="text-primary fw-bold mb-0"><?= isset($ref_code) ? $ref_code : "" ?></h3>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <span class="status-badge status-active">
                                        <i class="fas fa-circle me-1"></i>Active
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tracking Timeline -->
                        <div class="timeline">
                            <?php 
                            $tracks = $conn->query("SELECT * FROM `tracking_list` where cargo_id = '{$id}' order by unix_timestamp(date_added) desc");
                            $track_count = 0;
                            while($row = $tracks->fetch_assoc()):
                                $track_count++;
                                $is_last = $track_count === 1; // Most recent is last in timeline
                            ?>
                            <div class="timeline-item <?= $is_last ? 'timeline-current' : '' ?>">
                                <div class="timeline-header">
                                    <h5 class="timeline-title">
                                        <i class="fas fa-<?= $is_last ? 'check-circle' : 'clock' ?> me-2"></i>
                                        <?= $row['title'] ?>
                                    </h5>
                                </div>
                                <div class="timeline-body">
                                    <p class="timeline-description"><?= $row['description'] ?></p>
                                    <div class="timeline-date">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?= date("F d, Y h:i A", strtotime($row['date_added'])) ?>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="text-center mt-4">
                            <a href="./?p=trace_form" class="btn btn-modern me-3">
                                <i class="fas fa-search me-2"></i>Track Another Shipment
                            </a>
                            <a href="./" class="btn btn-outline-primary">
                                <i class="fas fa-home me-2"></i>Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php else: ?>
<!-- No Results Hero Section -->
<section class="trace-results-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center trace-content">
                <h1 class="display-4 fw-bold mb-4">
                    <i class="fas fa-exclamation-triangle me-3"></i>Shipment Not Found
                </h1>
                <p class="lead mb-0">
                    The shipment reference code you entered could not be found in our system.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- No Results Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="tracking-card">
                    <div class="tracking-body">
                        <div class="no-results">
                            <div class="no-results-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="fw-bold mb-3">Shipment Not Found</h3>
                            <p class="text-muted mb-4">
                                The reference code <strong><?= isset($ref_code) ? $ref_code : "" ?></strong> could not be found in our tracking system. 
                                Please verify the code and try again.
                            </p>
                            <div class="d-flex gap-3 justify-content-center flex-wrap">
                                <a href="./?p=trace_form" class="btn btn-modern">
                                    <i class="fas fa-search me-2"></i>Try Again
                                </a>
                                <a href="./" class="btn btn-outline-primary">
                                    <i class="fas fa-home me-2"></i>Back to Home
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
    $(function(){
        // Enhanced Carousel Functionality
        $('#traceResultsCarousel').on('slide.bs.carousel', function (e) {
            // Smooth carousel transitions
        });
        
        // Pause carousel on hover
        $('#traceResultsCarousel').hover(
            function() {
                $(this).carousel('pause');
            },
            function() {
                $(this).carousel('cycle');
            }
        );
        
        // Add animations on scroll
        $(window).scroll(function() {
            $('.timeline-item').each(function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('fade-in');
                }
            });
        });
        
        // Add hover effects to timeline items
        $('.timeline-item').hover(
            function() {
                $(this).find('.timeline-title').addClass('animate__animated animate__pulse');
            },
            function() {
                $(this).find('.timeline-title').removeClass('animate__animated animate__pulse');
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
        
        // Add loading animation to buttons
        $('.btn-modern, .btn-outline-primary').click(function() {
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Loading...');
            $btn.prop('disabled', true);
            
            // Re-enable after a short delay (for demo purposes)
            setTimeout(function() {
                $btn.html(originalText);
                $btn.prop('disabled', false);
            }, 2000);
        });
    });
</script>