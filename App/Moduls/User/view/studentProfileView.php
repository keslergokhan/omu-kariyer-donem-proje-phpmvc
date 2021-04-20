<?php extract($data); ?>
<?php
//Profil sahibi giriş kontrolu
$USER_CONTROL = isset($_SESSION["USER"]["STUDENT"]) && $_SESSION["USER"]["STUDENT"]["student_id"] == $student["student_id"] ? 1 : 0;
?>
<section>
    <div class="thme-header-bc">
        <div class="container">
            <div class="page-route-ctn">
                <h1 class="h3"><strong> Omu
                        Kariyer </strong> <?php echo $student["student_name"] . " " . $student["student_surname"] ?>
                    Profili</h1>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row m-y-2">
        <div class="col-lg-2 text-xs-center">
            <img src="Public/dimg/student/<?php echo $student["student_img"]?>" id="resim" class="m-x-auto img-fluid img-circle" alt="avatar">
            <?php if($USER_CONTROL){?>
                <button style="margin-top: 10px" type="button" class="btn btn-secondary btn-color-blue" onclick="$('#student_img').trigger('click')">Yeni resim <i class="fas fa-image"></i></button>
            <?php } ?>
        </div>
        <div class="col-lg-10">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profil</a>
                </li>
                <li class="nav-item">
                    <a href="" data-target="#messages" id="refcol" data-toggle="tab" class="nav-link">Referanslar</a>
                </li>
            </ul>
            <div class="tab-content p-b-3">
                <div class="tab-pane active" id="profile">
                    <form action="studentProfileUpdate" id="studentProfileUpdate" method="POST" enctype="multipart/form-data">

                        <?php if($USER_CONTROL){?>
                            <input hidden type="text" name="setting[delete_file]" value="<?php echo $student["student_img"]?>">
                            <input hidden type="text" name="setting[file_name_input]" value="<?php echo $student["student_nickname"]?>">
                        <?php }?>

                        <input type="file" hidden id="student_img" name="images[student_img]" class="form-control-file" onchange="$('#resim')[0].src = window.URL.createObjectURL(this.files[0]);$('#resim')[0].style.opacity  = '1';" >

                        <h4 class="m-y-2">Hakkında</h4>
                        <div class="row">
                            <div class="col-md-9">

                                <?php if($USER_CONTROL){?>
                                    <textarea class="form-control" id="student_about" name="student_about" rows="10"><?php echo $student["student_about"]?></textarea>
                                <?php }else{ ?>
                                    <p><?php echo $student["student_about"]?><p/>
                                <?php }?>

                            </div>
                            <div class="col-md-3">
                                <h6>İlgili Bölüm</h6>
                                <?php if($USER_CONTROL){?>
                                    <input type="text" id="student_episode" class="form-control form-control-sm" name="student_episode" value="<?php echo $student["student_episode"]?>">
                                <?php }else{ ?>
                                    <strong><?php echo $student["student_episode"]?></strong>
                                <?php } ?>
                                <strong></strong>
                                <h6>Aranan iş pozisyonları</h6>
                                <?php if($USER_CONTROL){?>
                                    Örnek : Bilgisayar, muhasebe
                                    <textarea  class="form-control" id="student_businesskey" name="student_businesskey" rows="3"><?php echo $student["student_businesskey"]?></textarea>
                                <?php }else{ ?>
                                    <a href="" class="tag tag-default tag-pill"><?php echo $student["student_businesskey"]?></a>
                                <?php } ?>

                                <hr>
                                <span class="tag tag-danger"><i class="fa fa-eye"></i> 245 Ziyaret</span>
                                <?php if(isset($_GET["message"]) && isset($_GET["error"]) && $_GET["error"] == "profileUpdate"){ ?><br>
                                    <div class="alert alert-<?php echo $_GET["status"]=="1" ? "success":"danger"  ?>">
                                        <?php echo $_GET["message"] ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-12">
                                <h4 class="m-t-2"><span class="fa fa-clock-o ion-clock pull-xs-right"></span> İletişim
                                    Bilgileri</h4>
                                <table class="table table-hover table-striped">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <?php if($USER_CONTROL){?>
                                                <i class="fas fa-mobile-alt"></i> <strong>Telefon :</strong>  <input class="form-control form-control-sm" id="student_phone" name="student_phone" type="text" placeholder=".form-control-sm" value="<?php echo $student["student_phone"]?>">
                                            <?php }else{ ?>
                                                <i class="fas fa-mobile-alt"></i> <strong>Telefon :</strong> <?php echo $student["student_phone"]?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <i class="far fa-envelope"></i> <strong>E-posta :</strong>
                                            gkhnkslr34@gmail.com
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php if($USER_CONTROL){?>
                                            <i class="fab fa-facebook-square"></i> <strong>Facabook : <input class="form-control form-control-sm" id="student_facebook" name="student_facebook" type="text" value="<?php echo $student["student_facebook"] ?>">
                                            <?php }else{ ?>
                                                <i class="fab fa-facebook-square"></i> <strong><a class="text-dark" href="<?php echo $student["student_facebook"] ?>" target="_blank">Facabook</a> </strong>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php if($USER_CONTROL){?>
                                            <i class="fab fa-instagram"></i> <strong>Instagram : <input class="form-control form-control-sm" id="student_instagram" name="student_instagram" type="text" value="<?php echo $student["student_instagram"]?>">
                                            <?php }else{ ?>
                                                <i class="fab fa-instagram"></i> <strong><a class="text-dark" href="<?php echo $student["student_instagram"] ?>" target="_blank">Instagram</a> </strong>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php if($USER_CONTROL){?>
                                            <i class="fab fa-linkedin"></i> <strong>linkedin : <input class="form-control form-control-sm" id="student_linkedin" name="student_linkedin" type="text" value="<?php echo $student["student_linkedin"]?>">
                                            <?php }else{ ?>
                                                <i class="fab fa-linkedin"></i> <strong><a class="text-dark" href="<?php echo $student["student_linkedin"]?>" target="_blank">linkedin</a> </strong>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                                <?php helpersHtml::show($USER_CONTROL, '<button class="btn btn-primary btn-color-red font-weight-bold">Kaydet <i class="fas fa-save"></i></button>'); ?>
                            </div>
                        </div>
                    </form>

                    <!--/row-->
                </div>
                <div class="tab-pane" id="messages">
                    <h4 class="m-y-2">Referanslar</h4>

                    <div>
                        <?php if(isset($_GET["message"]) && isset($_GET["error"]) && $_GET["error"] == "studentReference"){ ?><br>
                            <div class="alert alert-<?php echo $_GET["status"]=="1" ? "success":"danger"  ?>">
                                <?php echo $_GET["message"] ?>
                                <script>
                                    document.getElementById("refcol").click();
                                </script>
                            </div>
                        <?php } ?>

                        <?php if(count($student_reference)>0){ ?>
                            <?php foreach ($student_reference as $ref) { ?>
                                <div class="card">
                                    <div class="card-header">
                                        <?php echo $ref["reference_name"] ?>
                                    </div>
                                    <div class="card-body">
                                        <blockquote class="blockquote mb-0">
                                            <p><?php echo $ref["reference_explanation"] ?></p>
                                            <a href="Public/dimg/reference/<?php echo $ref["reference_file"] ?>" class="btn btn-primary btn-color-red" download="">Dosyayı indir <i class="fas fa-download"></i></a>
                                        </blockquote>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if (isset($_SESSION["USER"]["STUDENT"])){?>
                        <form style="margin-top: 50px" action="studentReferanceAddP" id="studentReferanceAddP" METHOD="POST" enctype="multipart/form-data">
                            <input type="text" hidden name="setting[file_name_input]" value="reference_name">
                            <div class="col-12">
                                <h4 class="m-y-2">Yeni referanslar ekle</h4>
                                <div class="alert alert-info alert-dismissable">
                                    Yeni bir referanslar ekle
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">Adı</label>
                                        <input type="text" class="form-control" required id="reference_name" name="reference_name" placeholder="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleFormControlFile1">Bir dosya seçmek için tıklayın</label>
                                        <input type="file" name="file[reference_file]" id="reference_file" class="form-control-file" style="border: solid 1px #ced4da;border-radius: 4px">
                                    </div>
                                    <div class="col-md-12" style="margin-top: 20px">
                                        <label for="exampleInputEmail1">Açıklama</label>
                                        <textarea  class="form-control" id="reference_explanation" name="reference_explanation" rows="3"></textarea>
                                        <div class="text-right">
                                            <button style="margin-top: 10px" type="submit" class="btn btn-secondary btn-color-blue" >Ekle <i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    <?php
        $alertHtml = function ($message){
            echo "<span class='alert-danger'>{$message}</span>";
        }
    ?>
    $(document).ready(function(){
        $("#studentReferanceAddP").validate({
            rules: {
                reference_file: {
                    extension: "docx|rar|doc|pdf|png|jpg"
                },
                reference_name:{
                    required:true
                }
            },messages: {
                reference_file: {
                    extension: "Lütfen geçerli dosya uzantısı giriniz (.docx,.rar,.doc,.pdf,.png,.jpg) !"
                },
                reference_name:{
                    extension:"Lütfen boş geçmeyiniz !"
                }
            },errorElement: "span",
            errorClass:"alert-danger"
        });

        $("#studentProfileUpdate").validate({
            rules:{
                student_about:{
                    maxlength: 1500,
                },
                student_phone:{
                    maxlength: 12,
                },
                student_businesskey:{
                    maxlength:350,
                    required: true
                },
                student_facebook:{
                    maxlength:350
                },
                student_instagram:{
                    maxlength:350
                },
                student_linkedin:{
                    maxlength:350
                },
                student_episode:{
                    maxlength:200,
                    required: true
                }
            },messages:{
                student_about:{
                    maxlength:"Lütfen 1500 karakteri geçmeyin !",
                },
                student_phone:{
                    maxlength:"Lütfen 12 karakteri geçmeyin !",
                },
                student_businesskey:{
                    maxlength:"Lütfen 350 karakteri geçmeyin !",
                },
                student_facebook:{
                    maxlength:"Lütfen 350 karakteri geçmeyin !",
                },
                student_instagram:{
                    maxlength:"Lütfen 350 karakteri geçmeyin !",
                },
                student_linkedin:{
                    maxlength:"Lütfen 350 karakteri geçmeyin !",
                },
                student_episode:{
                    maxlength:"Lütfen 200 karakteri geçmeyin !",
                    required: "Lütfen boş bırakmayın !"
                }
            },errorElement: "span",
            errorClass:"alert-danger"
        });
    });
</script>

