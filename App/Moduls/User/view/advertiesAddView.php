<form action="ilanverEkle" method="post">
    <section class="jumbotron text-center">
        <div class="container">
            <div class="py-1 text-center">

                <?php if (!empty($_SESSION["USER"]["EMPLOYER"]["employer_img"])) { ?>
                    <img class="d-block mx-auto mb-3" id="resim" src="Public/dimg/employer/<?php echo $_SESSION["USER"]["EMPLOYER"]["employer_img"] ?>"
                         alt="" width="100">
                <?php } ?>
                <h1><?php echo $_SESSION["USER"]["EMPLOYER"]["employer_company"] ?> <span class="h3 text-color-red">Yen bir ilan oluştur</span></h1>
            </div>
        </div>
    </section>

    <section class="container">
        <?php if(isset($_GET["message"]) && isset($_GET["error"]) && $_GET["error"] == "add"){ ?><br>
            <div class="alert alert-<?php echo $_GET["status"]=="1" ? "success":"danger"  ?>">
                <?php echo $_GET["message"] ?>
            </div>
        <?php } ?>
        <div class="form-group">
            <label for="email">Başlık</label>
            <input class="form-control" id="adverties_title" name="adverties_title" required type="text" placeholder="">
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Çalışma Şekli</label>
            <select class="form-control" id="adverties_type" name="adverties_type" required>
                <option selected>Sürekli / Tam zamanlı</option>
                <option>Dönemsel / Proje bazlı</option>
                <option>Stajyer</option>
                <option>Yarı zamanlı / Part Time</option>
                <option>Serbest Zamanlı</option>
            </select>
        </div>
        <div class="form-group">
            <label for="email">İş hakkında açıklama</label>
            <textarea class="form-control mb-3" required id="adverties_about" name="adverties_about" rows="5"></textarea>
        </div>
        <div class="form-group">
            <div class="alert alert-warning" role="alert">
                <i class="fas fa-exclamation-triangle"></i> İş ilanınız hangi kelimeler arandığında üst sıralara çıksın, anahtar kelimeleri virgül şeklinde doldurunuz.
                <br> Örnek = Muhasebe,Ön muhasebe
            </div>
            <label for="email">Pozisyon</label>
            <input class="form-control" id="adverties_position" name="adverties_position" required type="text" placeholder="Örnek:Yazılım,Web tasarım,IT">

            <div class="text-right mt-3">
                <button class="btn btn-primary btn-color-red font-weight-bold">Oluştur <i class="fas fa-plus"></i></button>
            </div>
        </div>
    </section>
</form>