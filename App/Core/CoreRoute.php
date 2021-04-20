<?php
	
	/*
	 * CoreRoute
	 * Sayfaların yollarını ve ile Controller,Model ve çalıştırılacak olan method Core içinde kontrol edilmesi için oluşturulur.
	 *
	 * Genel kullanımı 
	 * Route::getCreate("/anasayfa","Tasarim/anasayfa@index",false);
     *
	 * Parametreler
	 * $link = Url adresinde girilmesi istenen adres "www.ornek.com/anasayfa" 
	 * Route::getCreate("/anasayfa","Tasarim/anasayfa@index","user");	
	 *
	 * $path = $link ile gönderilen url adresine kullanıcı giriş yaptığı zaman yüklenecek olan controller ve bu controllerin içinde çalıştırılacak olan		
	 * method bütünü tanımlanır.		
	 * Route::getCreate("/anasayfa","Tasarim/anasayfa@index",false);
	 *								 Dosya  / Controller @ Method 
	 * 
	 * $auto = Url adresinde girilecek olan sayfanın tüm kullanıcıları açık olup olmadığını tanılarız eğer boş veya false gönderilir ise bu sayfaya 		
	 * tüm kullanıcılar girebilir. Kullanıcı kontrolu yapılmasını istiyorsanız $_SESSION["user"] adınız göndereceksiniz		
	 * Route::getCreate("/profil","Tasarim/anasayfa@index","user"); = "/profil" sayfasına sadece $_SESSION["user"] oluşturulmuş ise giriş yapılabilir	 
	 * Route::getCreate("/kayit","Tasarim/anasayfa@index",false);	= Bu sayfaya tüm ziyaretçiler girebilir.
	 *		
	 * $fileCreate = $path alanına girmiş olduğumuz dosyaları oluşturmasını istiyor iseniz True olarak işaretlemeniz yeterli. 		
	 * Route::getCreate("/anasayfa","Tasarim/anasayfa@index",false); Modul içerisinde Tasarım klasörü varmı kontrol yapar yok ise oluşturur daha sonra		
	 * anasayfaController.php kontrol edilir yok ise oluşturur.		
	 *		
	 *		
   * crudCreate()
   * Crud işlemleri için belirli post ve get yolları belirleriz. Örk menu,menuAdd,menuUpdate,menuAddPost,menuUpdatePost gibi
   * diğer fonksiyonlar
   * kullanılarak roote.php kalabalık bir hale sokmak yerine crudCreate işlemi ile menu uzantısını girerek tüm yolları otomatik
   * oluşturabiliriz.
   *
     * Route::crudCreate("menu","menu/menu@index","admin",false);		
	 * Boş bırakıldığı zaman crud işlemleri için tüm yolları otomatik oluşturur		
	 *		 http://localhost/MVC-2021/menuAdd
	 *		 http://localhost/MVC-2021/menuUpdate
	 *		 http://localhost/MVC-2021/menuDelete 
	 *		 GET/POST yolları ile örnekte olduğu gibi tüm yolları ve bunların dahilinde method yollarını da manuel oluşturur.
	 *
	 * Route::crudCreate("menu","menu/menu@index","admin",false,["A","U"]);		
	 * $AUD_operetion parametre olarak dizi halinde oluşturulacak sayfaların baş harfleri girildiği taktirde sadece bu sayfaları oluşturacaktır
	 * http://localhost/MVC-2021/menuAdd
	 * http://localhost/MVC-2021/menuDelete 
	 * GET/POST ile birlikte
	 *
	*/

    class Route extends Core {

    	public static function defaultRoute($defaultRoute){
    		self::getCreate("",$defaultRoute,false,false);
    	}

        public static function getCreate($link,$path,$auto=false,$fileCreate=false){
            self::$routes[] = ["GET",$link,$path,$auto,$fileCreate];
        }

        public static function postCreate($link,$path,$auto=false,$fileCreate=false){
            self::$routes[] = ["POST",$link,$path,$auto,$fileCreate];
        }

       	public static function crudCreate($link,$path,$auto=false,$AUD_operetion = [],$fileCreate=false){

       		if(strstr($path,"@")){
       			//$pasth içerisinde başlangıç methodu tanımlanmamış ise
       			self::$routes[] = ["GET",$link,$path,$auto,$fileCreate];
       			
       			$path = strstr($path,"@",true);
       			//Diğer yollar için $path @ öncesi alındı.

       		}else{
       			self::$routes[] = ["GET",$link,$path."@List",$auto,$fileCreate];
       		}

          $AUD_URL = [
            "A"=>"Add",
            "U"=>"Update/([0-9_]+)",
            "D"=>"Delete/([0-9_]+)"
          ];

       		$AUD_GET = [
       			"A"=>$link."Add",
       			"U"=>$link."Update",
       		 	"D"=>$link."Delete"
       		];

       		$AUD_POST = [
       			"A"=>$link."AddP",
       			"U"=>$link."UpdateP",
       		 	"D"=>$link."DeleteP"
       		];

       		if(!empty($AUD_operetion)){

       			foreach ($AUD_operetion as $key => $value) {
       				self::$routes[] = ["GET",$link.$AUD_URL[$value],$path."@".$AUD_GET[$value],$auto,$fileCreate];
       			}

       			foreach ($AUD_operetion as $key => $value) {
       				self::$routes[] = ["POST",$link.$AUD_POST[$key],$path."@".$AUD_POST[$value],$auto,$fileCreate];
       			}

       		}else{

       			foreach ($AUD_GET as $key => $value) {
       				self::$routes[] = ["GET",$link.$AUD_URL[$key],$path."@".$value,$auto,$fileCreate];
       			}

       			foreach ($AUD_POST as $key => $value) {
       				self::$routes[] = ["POST",$link.$AUD_POST[$key],$path."@".$value,$auto,$fileCreate];
       			}

       		}
       		

       	}

    }