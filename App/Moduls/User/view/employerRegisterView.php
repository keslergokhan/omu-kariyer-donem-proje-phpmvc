<!DOCTYPE html>
<html>
<head>
    <title></title>
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



    <form id="isveren_kait_form" method="POST" action="isverenKayit" class="form-signin user-register-form">
        <div class="text-center">
            <img class="mb-4" src="Public/images/1200px-OMÜ_logo.png" alt="" width="90" height="90">
            <h1 class="h6 mb-3 font-weight-normal text-muted">OMÜ KARİYER <strong class="text-color-red">İŞ VEREN</strong> KAYIT </h1>
        </div>

        <?php if (isset($_GET["error"]) && isset($_GET["message"])){ ?>
            <div class="alert alert-<?php echo $_GET["status"]=="1" ? "success":"danger"  ?>">
                <?php echo $_GET["message"] ?>
            </div>
        <?php } ?>

        <div class="form-label-group mb-3">
            <div class="row">
                <div class="col-6">
                    <input type="text" id="employer_name" name="employer_name" class="form-control" placeholder="Ad" required="" autofocus="">
                </div>
                <div class="col-6">
                    <input type="text" id="employer_surname" name="employer_surname" class="form-control" placeholder="Soyad" required="" autofocus="">
                </div>
            </div>
        </div>

        <div class="form-label-group mb-3">
            <input type="text" id="employer_company" name="employer_company" class="form-control" placeholder="Şirket İsmi" required="">
        </div>

        <div class="form-label-group mb-3">
            <input type="text" id="employer_eposta" name="employer_eposta" class="form-control" placeholder="E-posta" required="">
        </div>

        <div class="form-label-group mb-3">
            <input type="text" id="employer_phone" name="employer_phone" class="form-control" placeholder="Telefon" required="" >
        </div>

        <div class="form-label-group mb-3">
            <input type="password" id="employer_password" name="employer_password" class="form-control" placeholder="Şifre" required="">
        </div>

        <div class="form-label-group mb-3">
            <input type="password" id="employer_passwordcontrol" name="employer_passwordcontrol" class="form-control" placeholder="Şifre Tekrar" required="">
        </div>

        <div class="checkbox mb-2">
            <label>
                <input type="checkbox" id="sozlesme" name="sozlesme"> Kullanım Şartlarımızı ve Gizlilik Politikamızı kabul ediyorum.
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block btn-color-red" type="submit">Kayıt Ol</button>
        <ul class="ul-list mx-auto" style="max-width: 160px;">
            <li><a href="anasayfa">Anasayfa</a></li>
            <li><a href="giris">Üye Giriş</a></li>
        </ul>
        <p class="mt-2 text-muted text-center">© 2021 OMUKARİYER</p>

    </form>
</section>



</body>
<script type="text/javascript">
    $(document).ready(function(){
        $("#isveren_kait_form").validate({
            rules:{
                employer_name:{
                    required : true,
                    minlength: 3,
                    maxlength:50
                },
                employer_surname:{
                    required : true,
                    minlength: 2,
                    maxlength:50
                },
                employer_company:{
                    required:true,
                    minlength : 1,
                    maxlength:50
                },
                employer_eposta:{
                    required : true,
                    email : true,
                    maxlength:50
                },
                employer_phone : {
                    required : {
                        depends : function(value){
                            return $("#employer_eposta").val() == ''
                        }
                    },
                    number : true,
                    maxlength:25
                },
                employer_password:{
                    required:true,
                    minlength: 6,
                    maxlength:25
                },
                employer_passwordcontrol : {
                    required:true,
                    minlength: 6,
                    equalTo : "#employer_password",
                    maxlength:25
                },
                sozlesme:{
                    required:true
                }

            },messages : {
                employer_name:{
                    required:"<span class='alert-danger'>Lütfen bu alanı boş geçmeyiniz</span>",
                    minlength:"<span class='alert-danger'>En az üç karakter olabilir !</span>",
                    maxlength:"<span class='alert-danger'>Lütfen 50 karakteri aşmayınız !</span"
                },
                employer_surname:{
                    required:"<span class='alert-danger'>Lütfen bu alanı boş geçmeyiniz</span>",
                    minlength:"<span class='alert-danger'>En az iki karakter olabilir !</span>",
                    maxlength:"<span class='alert-danger'>Lütfen 50 karakteri aşmayınız !</span"
                },
                employer_company:{
                    required:"<span class='alert-danger'>Lütfen bu alanı boş geçmeyiniz</span>",
                    minlength:"<span class='alert-danger'>En az bir karakter olabilir !</span>",
                    maxlength:"<span class='alert-danger'>Lütfen 50 karakteri aşmayınız !</span"
                },
                employer_eposta:{
                    required : "<span class='alert-danger'>Lütfen bu alanı boş geçmeyiniz</span>",
                    email : "<span class='alert-danger'>Email doğrulanamadı !</span>",
                    maxlength:"<span class='alert-danger'>Lütfen 50 karakteri aşmayınız !</span"
                },
                employer_phone:{
                    required : "<span class='alert-danger'>E-posta veya telefon girilmesi zorunludur !</span>",
                    number : "<span class='alert-danger'>Sadece sayı giriniz ! (0123456789)</span>"
                    ,maxlength:"<span class='alert-danger'>Lütfen 50 karakteri aşmayınız !</span"
                },
                employer_passwordcontrol:{
                    required:"<span class='alert-danger'>Bu alan boş bırakılamaz !</span>",
                    minlength : "<span class='alert-danger'>En az 6 karakter kullanılmalı !</span>",
                    equalTo : "<span class='alert-danger'>Şifre uyuşmuyor !</span>",
                    maxlength:"<span class='alert-danger'>Lütfen 50 karakteri aşmayınız !</span"
                },
                employer_password:{
                    required:"<span class='alert-danger'>Bu alan boş bırakılamaz !</span>",
                    minlength : "<span class='alert-danger'>En az 6 karakter kullanılmalı !</span>",
                    equalTo : "<span class='alert-danger'>Şifre uyuşmuyor !</span>",
                    maxlength:"<span class='alert-danger'>Lütfen 50 karakteri aşmayınız !</span"
                },
                sozlesme:{
                    required:"<span class='alert-danger'>Kayıt olmanız için sözleşmeyi kabul etmeniz gerek !</span><br>",
                }


            }
        });
    });
</script>
</html>