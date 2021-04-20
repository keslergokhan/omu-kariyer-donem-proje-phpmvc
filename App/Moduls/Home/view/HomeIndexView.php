<?php extract($data); ?>
<?php Piece::view("Home/Home@SearchFormTheme"); ?>

<section class="container">
	<article>
		<span class="title">
			<h2 class="h5">ÖNE ÇIKAN <STRONG>İŞ İLANLARI</STRONG></h2>
		</span>
		<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
                <?php
                    $row = 0;
                ?>
                <?php foreach ($adverties as $index => $adv){ ?>

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

<section>
	<div class="main-slogan-container">
		<div class="row">
			<div class="col-md-6 main-slogan-title">
				<h3> Ondokuz Mayıs Üniversitesi <br> İş Bulma Platformu</h3>
				<span class="h5">#OMUKARIYER</span>
			</div>
			<div class="col-md-6 main-slogan-img text-center">
				<img src="Public/images/omu-kariyer.png" alt="Omü Kariyer İş Bulma Platformu" >
			</div>
		</div>
	</div>
</section>

<section class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div>
                <img src="Public/images/logo-student.png" width="30%">
                <span class="h5 text-color-red">
                    Bir birinden yetenekl <strong><?php echo count($student)?> öğrenci.</strong>
                </span>
            </div>
        </div>

        <div class="col-md-6">
            <span class="title">
                <h4 class="h5">İŞ ARAYAN ÖĞRENCİLER</h4>
            </span>
            <div id="carouselExampleControls2" class="carousel slide" data-ride="carousel1">
                <div class="carousel-inner">
                    <?php $srow = 0; ?>
                    <?php foreach ($student as $index => $stu) {?>
                        <?php if($srow==0){ ?>
                            <div class="carousel-item <?php echo $index==0 ? "active":"" ?>">
                            <ul class="list-group">
                        <?php }?>

                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div class="col-3 text-center" >
                                        <?php if(!empty($stu["student_img"])){?>
                                            <img class="rounded-circle" src="Public/dimg/student/<?php echo $stu["student_img"]?>" alt="<?php echo $stu["student_name"]?><?php echo $stu["student_surname"]?>" width="50px">
                                        <?php }else{ ?>
                                            <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="<?php echo $stu["student_name"]?><?php echo $stu["student_surname"]?>" width="50px">
                                        <?php } ?>

                                    </div>
                                    <div class="col-9" >
                                        <h6 class="my-0">
                                            <a style="color: black" class="ttext-muted text-decoration-none" href="ogrenciProfil/<?php echo $stu["student_nickname"]?>/<?php echo $stu["student_id"]?>">
                                                <?php echo $stu["student_name"]?><?php echo $stu["student_surname"]?>
                                            </a>
                                        </h6>
                                        <small class="text-muted text-color-red"><?php echo helper::str_max($stu["student_episode"],100)?></small>
                                    </div>
                                </li>

                        <?php if($srow==2){ ?>
                            </ul>
                            </div>
                        <?php }?>
                    <?php } ?>
                    <?php if($srow==1 || $srow ==2){ //Son kontrol ?>
                        </div>
                        </div>
                    <?php }?>
                </div>
                <div class="carousel-control-prev-next-carusel1">
                    <a class="carousel-control-prev" href="#carouselExampleControls2" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls2" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>