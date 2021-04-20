<section>
    <div class="thme-header-bc">
        <div class="container">
            <div class="page-route-ctn">
            </div>
        </div>
    </div>
</section>
<div style="padding-bottom:100px;padding-top:100px;">
    <div class="container">
        <div class="alert alert-danger text-center" role="alert">

            <strong class="h2">
                <i class='fas fa-exclamation-triangle'></i>
                <?php echo  isset($_GET["title"]) ? $_GET["title"]:""?>
            </strong><br><br>
            <div class="h5">
                <?php echo  isset($_GET["message"]) ? $_GET["message"]:""?>
            </div>
        </div>
    </div>
</div>