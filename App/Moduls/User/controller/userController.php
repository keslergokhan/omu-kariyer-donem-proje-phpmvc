
<?php 
class userController extends Controller
{

	public function login()
	{
	    seo::setTitle("Omu kariyer kullanıcı giriş");
        $this->view("User/userLogin");
	}

	public function userLoginP(){
	    //Boş değer varmı kontrol ettik.
	    $control = helper::emptyControl($_POST);

	    if($control["status"]){
	        //Boşlukları temizledim
	        $_POST = helper::trimControl($_POST);
            $model = new userModel();
            $control = $model->userLoginPModel($_POST);
            helper::headerReturn([BASE."anasayfa",BASE."giris"],$control);
        }else{
	        helper::header($_SERVER["HTTP_REFERER"],"?status=0&error=userLogin&Lütfen boş değer girmeyiniz !");
        }

    }

    public function logout(){
        if(isset($_SESSION["USER"])) unset($_SESSION["USER"]);
        helper::header(BASE."anasayfa","?status=1&error=logout&message=Çıkış yapıldı 1");
    }

}
			