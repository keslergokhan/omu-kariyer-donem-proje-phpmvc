<?php extract($data)?>
<section>
    <div class="thme-header-bc">
        <div class="container">
            <div class="page-route-ctn" style="margin-bottom: 10px">
                <h1 class="h3">
                    <strong><?php echo $adverties["adverties_title"] ?></strong>
                </h1>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <article>
            <div class="blog-post mt-4">
                <h2 class="mb-3"><?php echo $adverties["adverties_type"]?> <?php echo $adverties["adverties_title"] ?></h2>

                <div class="row">
                    <div class="col-md-9">
                        <?php echo $adverties["adverties_about"]?>

                        <div class="mt-3">
                        <table class="table table-hover table-striped">
                            <tbody>
                            <tr>
                                <td>
                                    <i class="fas fa-mobile-alt"></i> <strong>Telefon :</strong>
                                    <?php if(isset($_SESSION["USER"])){?>
                                        <a href="tel:<?php echo $employer["employer_phone"] ?>"><?php echo $employer["employer_phone"] ?></a>
                                    <?php }else{ ?>
                                        <a href="giris" class="text-color-red">Lütfen giriş yapın !</a>
                                    <?php }?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="far fa-envelope"></i> <strong>E-posta :</strong>
                                    <a href="tel:<?php echo $employer["employer_eposta"] ?>"><?php echo $employer["employer_eposta"] ?></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fas fa-globe"></i> <strong>Web Site :</strong>
                                    <a href="<?php echo $employer["employer_website"] ?>" target="_blank"><?php echo $employer["employer_website"] ?></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fab fa-facebook-square"></i> <strong><a class="text-dark" href="<?php echo $employer["employer_facebook"] ?>" target="_blank">Facabook</a>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fab fa-instagram"></i> <strong><a class="text-dark" href="<?php echo $employer["employer_instagram"] ?>" target="_blank">Instagram</a>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                    <i class="fab fa-linkedin"></i> <strong><a class="text-dark" href="<?php echo $employer["employer_linkedin"] ?>" target="_blank">linkedin</a>
                                    </strong>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="col-md-3 ">
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">İlanı sahibi</h6>
                                    <small class="text-muted"><?php echo $employer["employer_name"]?> <?php echo $employer["employer_surname"]?></small>
                                    <br>
                                    <a href="profil/<?php echo $employer["employer_nickname"]?>/<?php echo $employer["employer_id"]?>" target="_blank" class="text-color-red"><?php echo $employer["employer_company"]?> Profile git -></a>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">İlan tarihi</h6>
                                    <small class="text-muted"><?php echo helper::date($adverties["adverties_date"],"/")?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Pozisyon</h6>
                                    <small class="text-muted"><?php echo $adverties["adverties_position"]?></small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">Çalışma Tipi</h6>
                                    <small class="text-muted text-color-red"><?php echo $adverties["adverties_type"]?></small>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>


            </div>
        </article>

    </div>
</section>

<section class="container mt-5">
    <article>
		<span class="title">
			<h5 class="h5">ÖNE ÇIKAN <STRONG>İŞ İLANLARI</STRONG></h5>
		</span>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $row = 0;
                ?>
                <?php foreach ($adverties_all as $index => $adv){ ?>

                    <?php if ($row==0){ ?>
                        <div class="carousel-item <?php echo $index == 0 ? "active":""?>">
                        <div class="row">
                    <?php } ?>
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
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
                    <?php if($row==2){ ?>
                        </div>
                        </div>
                    <?php }?>
                    <?php $row == 2 ? $row = 0 : $row++; ?>

                <?php }//Foreah ?>

                <?php if($row==1 || $row==2){ //Son kontrol ?>
            </div>
        </div>
        <?php }?>
        </div>
        <div class="carousel-control-prev-next">
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        </div>
    </article>
</section>