
<style>
    .carousel-item>img{
        object-fit:fill !important;
    }
    #carouselExampleControls .carousel-inner{
        height:280px !important;
    }
    .mob-img{
        width:50px;
        height:100px;
        object-fit:scale-down;
        object-position:center center;
    }
    .mob-img-selected{
        width:50px;
        height:65px;
        object-fit:scale-down;
        object-position:center center;
    }
    span.select2-selection.select2-selection--single {
        height: auto !important;
    }
    span.select2-selection__arrow {
        top: 20% !important;
    }
</style>
<?php 
?>
<section class="py-0">
    <div class="container">
        <div class="col-lg-12 py-2">
            <div class="row">
                <div class="col-md-12">
                    <div id="carouselExampleControls" class="carousel slide bg-dark" data-ride="carousel" data-interval="2500">
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
                            <div class="carousel-item h-100 <?php echo $_i == 1 ? "active" : '' ?>">
                                <img src="<?php echo validate_image($upload_path.'/'.$img) ?>" class="d-block w-100  h-100" alt="<?php echo $img ?>">
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        </div>
                </div>
            </div>
            <div class="container px-4 px-lg-5 mt-5">
                <form action="" id="trace-frm">
                    <div class="card card-outline card-primary rounded-0 shadow">
                        <div class="card-body">
                            <fieldset>
                                <legend>Trace your Cargo</legend>
                                <div class="row align-items-end">
                                    <div class="form-group col-md-6">
                                        <label for="mobile1" class="control-label">Shipment Reference Code</label>
                                        <input type="text" class="form-control form-control-lg rounded-0" name="ref_code" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-default bg-gradient-primary btn-flat btn-lg text-light w-50">Trace Now</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
                <div class="clear-fix mb-3"></div>

            </div>
    </div>
    </div>
</section>
<script>
    $(function(){
        
        $('#trace-frm').submit(function(e){
            e.preventDefault();
            location.href="./?p=trace&"+$(this).serialize();
        })
    })

</script>