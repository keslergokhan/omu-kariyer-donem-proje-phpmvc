
<?php 
class employerController extends Controller
{

	public function profile($employerNickName,$id)
	{
	    seo::setTitle("Omu kariyer {$employerNickName} profil");
	    $model = new employerModel();
	    $data = $model->profileModel($employerNickName,$id);

	    if(isset($data["status"]) && $data["status"]==0){
            helper::header(BASE."hata","?title=Üzgünüm&message='{$employerNickName}' aradığınız şirket bulunamadı !");
        }else{
            $this->layoutView("Frontend/Home","User/employerProfile",$data);
        }

    }

    public function employerProfileUpdateP(){
	    if(isset($_SESSION["USER"]["EMPLOYER"])){
            $model = new employerModel();
            $control = $model->employerProfileUpdatePModel($_POST);

            helper::headerReturn(BASE."profil/".$_SESSION["USER"]["EMPLOYER"]["employer_nickname"]."/".$_SESSION["USER"]["EMPLOYER"]["employer_id"],$control);

        }else{
	        helper::header($_SERVER["HTTP_REFERER"]);
        }
    }

	public function register(){
	    $this->view("user/employerRegister");
    }

    public function  registerAddP(){
        //İş veren kayıt

        //Boş değer varmı kontrol ettik.
	    $return = helper::emptyControl($_POST,["employer_phone"]);

	    if($return["status"]){
	        //Gelen verilerin başı ve sonunda boşlukları temizledik
            $_POST = helper::trimControl($_POST);
            $model = new employerModel();

            $control = $model->registerAddPModel($_POST);
            helper::headerReturn(BASE."isverenKayit",$control);

        }else{
            helper::header($_SERVER["HTTP_REFERER"]);
        }

    }

    public function adverties(){
	    if(isset($_SESSION["USER"]["EMPLOYER"])){
	        $this->layoutView("Frontend/Home","User/advertiesAdd");
        }else{
	        helper::header(BASE."isverenKayit","?status=0&error=adverties&message=<i class='fas fa-exclamation-triangle'></i> İlan vermeniz için kayıtlı olmanız gerek !");
        }
    }

    public function advertiesAddP(){

	    if(isset($_SESSION["USER"]["EMPLOYER"])){
	        $model = new employerModel();
            $control = $model->advertiesAddPModel($_POST);
            helper::headerReturn(BASE."ilanver",$control);
        }else{
	        helper::header(BASE."ilanver");
        }
    }

    public function advertiesUpdate($id){
        if(isset($_SESSION["USER"]["EMPLOYER"])){
            $model = new employerModel();
            $data = $model->advertiesUpdateModel($id);

            if(isset($data["status"]) && $data["status"]==0){
                helper::header(BASE."hata","?title= Üzgünüm&message= Bu ilanı düzenleme yetkiniz yok !");
            }else{
                $this->layoutView("Frontend/Home","User/advertiesUpdate",$data);
            }

        }else{
            helper::header(BASE."isverenKayit","?status=0&error=adverties&message=<i class='fas fa-exclamation-triangle'></i> Lütfen daha sonra tekrar deneyin !");
        }
    }

    public function advertiesUpdateP(){
        if(isset($_SESSION["USER"]["EMPLOYER"])){
            $model = new employerModel();
            $control = $model->advertiesUpdatePModel($_POST);

            helper::headerReturn(BASE."ilanverGuncelle",$control);

        }else{
            helper::header(BASE."ilanverGuncelle","?status=0&error=adverties&message=<i class='fas fa-exclamation-triangle'></i> Lütfen daha sonra tekrar deneyin !");
        }
    }

    public function advertiesRemove($id){
        if(isset($_SESSION["USER"]["EMPLOYER"])){
            $model = new employerModel();
            $control = $model->advertiesRemove($id);

            helper::headerReturn(BASE."profil/{$_SESSION["USER"]["EMPLOYER"]["employer_nickname"]}/{$_SESSION["USER"]["EMPLOYER"]["employer_id"]}",$control);
        }else{
            helper::header($_SERVER["HTTP_REFERER"]);
        }
    }

}
			