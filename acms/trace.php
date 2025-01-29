
<style>
    .carousel-item>img{
        object-fit:fill !important;
    }
    #carouselExampleControls .carousel-inner{
        height:280px !important;
    }
    .mob-img{
        width:100%;
        max-height:20vh;
        object-fit:scale-down;
        object-position:center center;
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
               <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                        <?php if(isset($id)): ?>
                        <h4><span class="text-muted">Shipment Ref. Code:</span> <b><?= isset($ref_code) ? $ref_code : "" ?></b></h4>
                        <div id="history" class="border-left border-3 pl-3">
                            <?php 
                            $tracks = $conn->query("SELECT * FROM `tracking_list` where cargo_id = '{$id}' order by unix_timestamp(date_added) desc");
                            while($row = $tracks->fetch_assoc()):
                            ?>
                            <div class="card card-default shadow rounded-0">
                                <div class="card-header py-1">
                                    <h5 class="card-title"><b><?= $row['title'] ?></b></h5>
                                </div>
                                <div class="card-body">
                                    <div class="card-text"><?= $row['description'] ?></div>
                                    <div class="clear-fix"></div>
                                    <div class="text-right"><small class="text-muted"><em><?= date("F d, Y h:i A", strtotime($row['date_added'])) ?></em></small></div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                        <?php else: ?>
                            <h4 class="text-ceter"><em>Unkown Cargo/Shipment Reference Code</em></h4>
                        <?php endif; ?>
                    </div>
               </div>

            </div>
    </div>
    </div>
</section>