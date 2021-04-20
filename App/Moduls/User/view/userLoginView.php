<!DOCTYPE html>
<html>
<head>
    <title><?php seo::getTitle();?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="Public/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="Public/js/jquery.validate.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Public/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="Public/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Public/css/PStyle.css">
    <link rel="stylesheet" type="text/css" href="Public/css/PStyleMoil.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>
</head>

<body class="user-register-form-body">
	<section class="user-register-form-container">

		<form id="kullaniciGiris" action="giris" method="post" class="form-signin user-register-form">
			<div class="text-center">
				<img class="mb-4" src="Public/images/1200px-OMÜ_logo.png" alt="" width="90" height="90">
				<h1 class="h6 mb-3 font-weight-normal text-muted">OMÜ KARİYER  GİRİŞ YAP</h1>
			</div>

            <?php if (isset($_GET["error"]) && isset($_GET["message"]) && $_GET["error"]=="userLogin"){ ?>
                <div class="alert alert-<?php echo $_GET["status"]=="1" ? "success":"danger"  ?>">
                    <?php echo $_GET["message"] ?>
                </div>
            <?php } ?>

			<div class="form-label-group">
				<input type="email" name="userEposta" id="userEposta" class="form-control" placeholder="E-posta" required="" autofocus="">
			</div>

			<div class="form-label-group mb-3">
				<input type="password" name="userPassword" id="userPassword" class="form-control" placeholder="Şifre" required="">
			</div>

		</div>
		<button class="btn btn-lg btn-primary btn-block btn-color-red" type="submit">Giriş</button>
		<ul class="ul-list mx-auto" style="max-width: 280px;">
			<li><a href="anasayfa">Anasayfa</a></li>
			<li><a href="ogrenciKayit">Öğrenci Kayıt</a></li>
            <li><a href="isverenKayit">İşveren Kayıt</a></li>
		</ul>
		<p class="mt-2 text-muted text-center">© 2021 OMUKARİYER</p>
	</form>
</section>

<script>
    $(document).ready(function (){
        $("#kullaniciGiris").validate({
            rules:{
                userEposta:{
                    required:true,
                    minLength:1,
                    email:true,
                    maxlength:50
                },
                userPassword:{
                    required:true,
                    minlength: 6,
                    maxlength:25
                }
            },
            messages:{
                userEposta:{
                    required : "<span class='alert-danger'>Lütfen bu alanı boş geçmeyiniz</span>",
                    email : "<span class='alert-danger'>Email doğrulanamadı !</span>",
                    maxlength:"<span class='alert-danger'>Lütfen 50 karakteri aşmayınız !</span"
                },
                userPassword:{
                    required:"<span class='alert-danger'>Bu alan boş bırakılamaz !</span>",
                    minlength : "<span class='alert-danger'>En az 6 karakter kullanılmalı !</span>",
                    maxlength:"<span class='alert-danger'>Lütfen 50 karakteri aşmayınız !</span"
                },
            }
        });
    });
</script>

</body>
</html>