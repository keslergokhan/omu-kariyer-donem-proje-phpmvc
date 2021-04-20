<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo BASE ?>">
	<title><?php seo::getTitle();?></title>
    <meta name="description" content="<?php seo::getDescription(); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="Public/node_modules/jquery/dist/jquery.min.js"></script>
	<script src="Public/js/jquery.validate.min.js"></script>
    <script src="Public/js/additional-methods.js"></script>
	<link rel="stylesheet" type="text/css" href="Public/node_modules/bootstrap/dist/css/bootstrap.min.css">
	<script src="Public/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="Public/css/PStyle.css">
	<link rel="stylesheet" type="text/css" href="Public/css/PStyleMoil.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light menu-container container">
			<a class="navbar-brand text-center" href="#">
				<img src="Public/images/logo.png" alt="OMÜ KARİYER LOGO" title="OMÜ KARİYER LOGO">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<ul class="navbar-menu-left">
					<li><a href="#">Anasayfa</a></li>
					<li><a href="#">Öğrenciler</a></li>
					<li><a href="#">Tüm iş ilanları</a></li>
				</ul>

			</div>
			<div class="navbar-menu-right">

                <?php if(isset($_SESSION["USER"])) {?>
                    <a href="<?php echo isset($_SESSION["USER"]["STUDENT"]) ? "ogrenciProfil/".$_SESSION["USER"]["STUDENT"]["student_nickname"]."/".$_SESSION["USER"]["STUDENT"]["student_id"] : "profil/".$_SESSION["USER"]["EMPLOYER"]["employer_nickname"]."/".$_SESSION["USER"]["EMPLOYER"]["employer_id"]; ?>" type="button" class="btn btn-primary btn-color-red font-weight-bold">Profil <i class="fas fa-user-plus"></i></a>
                    <a href="guvenliCikis" type="button" class="btn btn-primary btn-color-red font-weight-bold"> Güvenli Çıkış <i class="fas fa-sign-in-alt"></i></a>
                    <?php helpersHtml::show(isset($_SESSION["USER"]["EMPLOYER"]),'<a href="ilanver" type="button" class="btn btn-primary btn-color-blue font-weight-bold">İlan Ver <i class="fas fa-toolbox"></i></a>'); ?>
                <?php }else{ ?>
                    <a href="ogrenciKayit" type="button" class="btn btn-primary btn-color-red font-weight-bold">Üye Ol <i class="fas fa-user-plus"></i></a>
                    <a href="giris" type="button" class="btn btn-primary btn-color-red font-weight-bold">Üye Giriş <i class="fas fa-sign-in-alt"></i></a>
                    <a href="ilanver" class="btn btn-primary btn-color-blue font-weight-bold">İlan Ver <i class="fas fa-toolbox"></i></a>
                <?php } ?>

			</div>
		</nav>

	</header>

	<main>
		<?php echo $data["VIEW"]; ?>
	</main>
	<br><br>

	<footer class="py-4">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md">
					<img src="Public/images/1200px-OMÜ_logo.png" height="150">
					<small class="d-block mb-3 text-muted">© 2021</small>
				</div>
				<div class="col-6 col-md">
					<h5>Menü</h5>
					<ul class="list-unstyled text-small">
						<li><a class="text-muted" href="#">Anasayfa</a></li>
						<li><a class="text-muted" href="#">Öğrenciler</a></li>
						<li><a class="text-muted" href="#">Bölümler</a></li>
					</ul>
				</div>
				<div class="col-6 col-md">
					<h5>Kurumsal</h5>
					<ul class="list-unstyled text-small">
						<li><a class="text-muted" href="#">Hakkımızda</a></li>
						<li><a class="text-muted" href="#">Yardım</a></li>
						<li><a class="text-muted" href="#">Reklam Verin</a></li>
					</ul>
				</div>
				<div class="col-6 col-md">
					<h5>Sosyal Medya</h5>
					<ul class="list-unstyled text-small">
						<a class="text-muted" href="#"><i class="fab fa-facebook-square"></i></a>
						<a class="text-muted" href="#"><i class="fab fa-instagram"></i></a>
						<a class="text-muted" href="#"><i class="fab fa-twitter-square"></i></a>
					</ul>
				</div>
				<div class="col-6 col-md">
					<h5>About</h5>
					<ul class="list-unstyled text-small">
						<li><a class="text-muted" href="#"><i class="fas fa-phone-volume"></i> 0530 503 81 29</a></li>
						<li><a class="text-muted" href="#"><i class="far fa-envelope"></i> gkhnksr34@gmal.com</a></li>
					</ul>
				</div>
			</div>
		</div>

	</footer>
    <?php Script::get(); ?>
</body>
</html>