<?php extract($data); ?>

<?php
    //Profil sahibi giriş kontrolu
    $USER_CONTROL = isset($_SESSION["USER"]["EMPLOYER"]) && $_SESSION["USER"]["EMPLOYER"]["employer_id"] == $employer["employer_id"] ? 1 : 0;
?>
<form action="employerProfileUpdateP" id="employerProfileUpdateP" METHOD="post" enctype="multipart/form-data">

    <section class="jumbotron text-center">
        <div class="container">
            <div class="py-1 text-center">
                <?php if (!empty($employer["employer_img"])) { ?>
                    <img class="d-block mx-auto mb-3" id="resim" src="Public/dimg/employer/<?php echo $employer["employer_img"] ?>"
                         alt="" width="100">
                <?php } ?>

                <?php if($USER_CONTROL){?>
                    <input hidden type="file" name="images[employer_img]" id="employer_img" onchange="$('#resim')[0].src = window.URL.createObjectURL(this.files[0]);$('#resim')[0].style.opacity  = '1';">
                    <button type="button" class="btn btn-secondary btn-color-blue mb-2 mt-1" onclick="$('#employer_img').trigger('click')">Yeni resim <i class="fas fa-image"></i></button>
                <?php } ?>

                <?php if($USER_CONTROL) {?>
                    <input class="form-control form-control-lg" required type="text" placeholder="Şirket ismi" id="employer_company" name="employer_company" value="<?php echo $employer["employer_company"]?>">
                <?php }else{ ?>
                    <h1><?php echo $employer["employer_company"] ?></h1>
                <?php } ?>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-3 order-md-2 mb-3">
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Profil sahibi</h6>
                                <?php if ($USER_CONTROL) { ?>
                                    <div class="row">
                                        <input class="col-6 form-control form-control-sm mt-1" id="employer_name" required name="employer_name" placeholder="Ad" type="text" value="<?php echo $employer["employer_name"] ?>">
                                        <input class="col-6 form-control form-control-sm mt-1" id="employer_surname" required name="employer_surname" placeholder="Soyad" type="text" value="<?php echo $employer["employer_surname"] ?>">
                                    </div>
                                <?php } else { ?>
                                    <small class="text-muted"><?php echo $employer["employer_name"] ?><?php echo $employer["employer_surname"] ?></small>
                                <?php } ?>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Sektör</h6>
                                <?php if ($USER_CONTROL) { ?>
                                    <input class="form-control form-control-sm mt-1" required id="employer_sector"
                                           name="employer_sector" placeholder="Sektör giriniz" type="text"
                                           value="<?php echo $employer["employer_sector"] ?>">
                                <?php } else { ?>
                                    <small class="text-muted"><?php echo $employer["employer_sector"] ?></small>
                                <?php } ?>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Web sitesi</h6>
                                <?php if ($USER_CONTROL) { ?>
                                    <input class="form-control form-control-sm mt-1" id="employer_website"
                                           name="employer_website" placeholder="Web sitesi" type="text"
                                           value="<?php echo $employer["employer_website"] ?>">
                                <?php } else { ?>
                                    <small class="text-muted"><a href="<?php echo $employer["employer_website"] ?>"
                                                                 target="_blank">Git-></a></small>
                                <?php } ?>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Kuruluş yılı</h6>
                                <?php if ($USER_CONTROL) { ?>
                                    <input class="form-control form-control-sm mt-1" id="employer_history"
                                           name="employer_history" placeholder="Web sitesi" type="date"
                                           value="<?php echo $employer["employer_history"] ?>">
                                <?php } else { ?>
                                    <small class="text-muted"><?php echo helper::date($employer["employer_history"], "/") ?></small>
                                <?php } ?>
                            </div>
                        </li>
                    </ul>
                    <?php if(isset($_GET["message"]) && isset($_GET["error"]) && $_GET["error"] == "profileUpdate"){ ?><br>
                        <div class="alert alert-<?php echo $_GET["status"]=="1" ? "success":"danger"  ?>">
                            <?php echo $_GET["message"] ?>
                            <script>
                                document.getElementById("refcol").click();
                            </script>
                        </div>
                    <?php } ?>
                    <?php if(isset($_GET["message"]) && isset($_GET["error"]) && $_GET["error"] == "remove"){ ?><br>
                        <div class="alert alert-<?php echo $_GET["status"]=="1" ? "success":"danger"  ?>">
                            <?php echo $_GET["message"] ?>
                            <script>
                                document.getElementById("refcol").click();
                            </script>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-9">
                    <h4 class="mb-3 m">Hakkında</h4>
                    <?php if ($USER_CONTROL) { ?>
                        <textarea class="form-control mb-3" id="employer_about" name="employer_about"
                                  rows="3"><?php echo $employer["employer_about"] ?></textarea>
                    <?php } else { ?>
                        <p><?php echo $employer["employer_about"] ?></p>
                    <?php } ?>
                    <div class="">
                        <table class="table table-hover table-striped">
                            <tbody>
                            <tr>
                                <td>
                                    <i class="fas fa-mobile-alt"></i> <strong>Telefon :</strong>
                                    <?php if ($USER_CONTROL) { ?>
                                        <input class="form-control form-control-sm" id="employer_phone" name="employer_phone" type="text" value="<?php echo $employer["employer_phone"] ?>">
                                    <?php } else { ?>
                                        <a href="tel:<?php echo $employer["employer_phone"] ?>"><?php echo $employer["employer_phone"] ?></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="far fa-envelope"></i> <strong>E-posta :</strong>
                                    <?php if ($USER_CONTROL) { ?>
                                        <input class="form-control form-control-sm" id="employer_eposta" name="employer_eposta" type="text" value="<?php echo $employer["employer_eposta"] ?>">
                                    <?php } else { ?>
                                        <a href="tel:<?php echo $employer["employer_eposta"] ?>"><?php echo $employer["employer_eposta"] ?></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php if ($USER_CONTROL) { ?>
                                        <i class="fab fa-facebook-square"></i> <strong>Facabook :</strong>
                                        <input class="form-control form-control-sm" id="employer_facebook" name="employer_facebook" type="text" value="<?php echo $employer["employer_facebook"] ?>">
                                    <?php } else { ?>
                                        <i class="fab fa-facebook-square"></i> <strong><a class="text-dark" href="<?php echo $employer["employer_facebook"] ?>" target="_blank">Facabook</a>
                                        </strong>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php if ($USER_CONTROL) { ?>
                                        <i class="fab fa-instagram"></i> <strong>Instagram :</strong>
                                        <input class="form-control form-control-sm" id="employer_instagram"
                                               name="employer_instagram" type="text"
                                               value="<?php echo $employer["employer_instagram"] ?>">
                                    <?php } else { ?>
                                        <i class="fab fa-instagram"></i> <strong><a class="text-dark" href="<?php echo $employer["employer_instagram"] ?>" target="_blank">Instagram</a>
                                        </strong>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php if ($USER_CONTROL) { ?>
                                        <i class="fab fa-linkedin"></i> <strong>Instagram :</strong>
                                        <input class="form-control form-control-sm" id="employer_linkedin"
                                               name="employer_linkedin" type="text"
                                               value="<?php echo $employer["employer_linkedin"] ?>">
                                    <?php } else { ?>
                                        <i class="fab fa-linkedin"></i> <strong><a class="text-dark" href="<?php echo $employer["employer_linkedin"] ?>" target="_blank">linkedin</a>
                                        </strong>
                                    <?php } ?>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <?php helpersHtml::show($USER_CONTROL, '<button class="btn btn-primary btn-color-red font-weight-bold">Kaydet <i class="fas fa-save"></i></button>'); ?>
                    </div>
                    <div>
                        <table class="table table-hover table-striped mt-5">
                            <tbody>
                                <?php foreach ($adverties as $ad) {?>
                                    <tr class="">
                                        <td>
                                            <div class="row">
                                                <div class="col-8"> <span class="font-weight-bold h5">
                                                    <?php echo $ad["adverties_title"] ?><br>  <span class="h6 font-weight-italik"><?php echo $ad["adverties_type"] ?></span> </span>
                                                    <p><?php echo helper::str_max($ad["adverties_about"],100)?></p>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <a href="ilanverGuncelle/<?php echo $ad["adverties_id"] ?>" class="btn btn-primary btn-color-blue font-weight-bold"> <i class="far fa-trash-alt"></i> Güncelle </a>
                                                    <a href="ilanverSil/<?php echo $ad["adverties_id"] ?>" class="btn btn-primary btn-color-red font-weight-bold"><i class="fas fa-pencil-alt"></i> Sil</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>

</form>
<script type="text/javascript">

    $(document).ready(function() {
        $("#employerProfileUpdateP").validate({
            rules:{
                employer_company:{
                  required:true
                },
                employer_about:{
                    maxlength:2500
                },
                employer_phone:{
                    maxlength:12
                },
                employer_eposta:{
                    maxlength:50
                },
                employer_facebook:{
                    maxlength:200
                },
                employer_instagram:{
                    maxlength:200
                },
                employer_linkedin:{
                    maxlength:200
                },
                employer_name:{
                    reference:true,
                    maxlength:100,
                }
                employer_surname:{
                    reference:true,
                    maxlength:100,
                }

            },
            messages:{
                employer_company:{
                    required: "Lütfen boş bırakmayınız !"
                },
                employer_about:{
                    maxlength:"Lütfen 2500 karakteri geçmeyin !"
                },
                employer_phone:{
                    maxlength:"Lütfen 12 karakteri geçmeyin !"
                },
                employer_eposta:{
                    maxlength:"Lütfen 50 karakteri geçmeyin !"
                },
                employer_facebook:{
                    maxlength:"Lütfen 200 karakteri geçmeyin !"
                },
                employer_instagram:{
                    maxlength:"Lütfen 200 karakteri geçmeyin !"
                },
                employer_linkedin:{
                    maxlength:"Lütfen 200 karakteri geçmeyin !"
                },
                employer_name:{
                    required: "Lütfen boş bırakmayınız !"
                    maxlength:"Lütfen 100 karakteri geçmeyin !"
                }
                employer_surname:{
                    required: "Lütfen boş bırakmayınız !"
                    maxlength:"Lütfen 100 karakteri geçmeyin !"
                }
            },
            errorClass:"alert-danger",
            errorElement:"span"
        });
    });
</script>