
<?php 
class HomeController extends Controller
{

	public function index()
	{
	    seo::setTitle("Omü Kariyer Anasayfa");
	    $model = new HomeModel();
	    $data = $model->indexModel();
		$this->layoutView("Frontend/Home","Home/HomeIndex",$data);
	}

	public function notFound(){
        $this->layoutView("Frontend/Home","Home/notFound");
    }

    public function adverties($title,$id){
	    $model = new HomeModel();
	    $data = $model->advertiesModel($id);
	    if($data != false){
            $this->layoutView("Frontend/Home","Home/Adverties",$data);
        }else{
            helper::header(BASE."hata","?status=0&title=Üzgünüm bulamadım !&message=Aradığınız ilan bulunamadı, kaldırılmış olabilir. <br>");
        }
    }

    //Arama sayfası parça tasarım
    public function SearchFormTheme(){
        $this->view("Home/SearchFormTheme");
    }

    public function AdvertiesSearchList($page){
	    $model = new HomeModel();
	    isset($_GET["qa"]) && !empty($_GET["qa"]) ? $key = $_GET["qa"]:$key=null;
	    $data = $model->AdvertiesSearchListModel($page,$key);

	    if(count($data["adverties"])==0 || empty($data["adverties"])){
            helper::header(BASE."hata","?title=Bulunamadı!&message='{$key}' aranılan kelimede iş bulunamadı !");
        }else{
            $this->layoutView("Frontend/Home","Home/AdvertiesSearchList",$data);
        }

    }




}
			