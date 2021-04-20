
<?php 
class studentController extends Controller
{

	public function profile($studentNickName,$id){

        $model = new studentModel();
	    $data = $model->profileModel($studentNickName,$id);
        seo::setDesTit("Omu kariye {$studentNickName} profil","Ondokuz Mayıs Üniversitesi kariyer profili");

        if(isset($data["status"]) && $data["status"]==0){
            helper::header(BASE."hata","?title=Üzgünüm !&message={$data["message"]}");
        }else{
            $this->layoutView("Frontend/Home","User/studentProfile",$data);
        }
	}

	public function profileUpdate(){
        if(isset($_SESSION["USER"]["STUDENT"])){
            $model = new studentModel();
            $control = $model->profileUpdateModel($_POST);
            helper::headerReturn(BASE."ogrenciProfil/{$_SESSION["USER"]["STUDENT"]["student_nickname"]}/{$_SESSION["USER"]["STUDENT"]["student_id"]}",$control);
        }else{
            helper::header(BASE."anasayfa","?status=0&error=profileUpdate&message=Erişim engellendi");
        }
    }

	public function register()
	{	
		//Öğrenci kayıt sayfası
		$this->view("User/studentRegister");
	}
	public function registerAddP(){
		//Öğrenci kayıt post

		//Gönderilenler arasında boş değer varmı kontrol ettik.
		$return = helper::emptyControl($_POST,["student_phone"]);

		if($return["status"]){
			//Başında ve sonunda boşlukları kaldırdık.
			$_POST = helper::trimControl($_POST);
            $model = new studentModel();
            $control = $model->registerAddPModel($_POST);
            helper::headerReturn(BASE."ogrenciProfil/{$_SESSION["USER"]["STUDENT"]["student_nickname"]}",$control);

		}else{
		    //Eğer boş değer var ise;
		    helper::header($_SERVER["HTTP_REFERER"]);
        }
	}

	public function referenceAddP(){

	    if(!isset($_SESSION["USER"]["STUDENT"])){
            helper::header($_SERVER["HTTP_REFERER"]);
        }

        $model = new studentModel();
        $control = $model->referenceAddPModel($_POST);
        helper::headerReturn(BASE."ogrenciProfil/".$_SESSION["USER"]["STUDENT"]["student_nickname"],$control);

    }
}
