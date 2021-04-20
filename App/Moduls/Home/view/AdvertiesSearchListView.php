<?php Piece::view("Home/Home@SearchFormTheme"); ?>
<?php extract($data); ?>
<div class="album py-5">
    <div class="container">
        <div class="row">
            <?php foreach ($adverties as $index => $adv) {?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <?php if(!empty($adv["employer"]["employer_img"])){?>
                            <img class="card-img-top" alt="<?php echo $adv["adverties_title"] ?>" style="height: 225px; width: 100%; display: block;" src="Public/dimg/employer/<?php echo $adv["employer"]["employer_img"]?>" data-holder-rendered="true">
                        <?php }else{ ?>
                            <img class="card-img-top" alt="<?php echo $adv["adverties_title"] ?>" style="height: 225px; width: 100%; display: block;" src="Public/images/ondokuzmayis_universitesi_iha.jpg" data-holder-rendered="true">
                        <?php } ?>

                        <div class="card-body">
                            <span><?php echo helper::date($adv["adverties_date"],"/")  ?></span>
                            <p class="card-text">
                                <?php echo helper::str_max($adv["adverties_about"],100)?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="ilan/<?php echo helper::seo($adv["adverties_title"])?>/<?php echo $adv["adverties_id"]?>" class="btn btn-sm btn-color-red text-white">Gözat <i class="fas fa-search"></i></a>
                                <small class="text-muted text-color-red"><?php echo $adv["adverties_type"]?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>