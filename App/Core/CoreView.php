<?php 
	/** 
	 * CoreView
	 *
	 * Controller içerisinde tasarımlarımız ekrana sergilemek için gerekli methodlar bulunmakta.
	 * 
	 * page -> Tek bir tasarımı ekrana basmamızı sağlar, iki parametre alır.
	 * 
	 * Parametreler
	 * $path = Sayfaya eklenecek olan tasarımın yolunu belirtmemiz gerekiyor, başlangıç noktası olarak Moduls dizisi sabit alınır
	 * Örnek = $path = "menu"/index" Girilen bu değerler sonucu -> Moduls/menu/view/index yolu şeklinde ayarlanır
	 * 
	 * $data = Sayfa yüklenirken ardından göndermek istediğimiz değerleri göndeririz.
	 * 
	 * viewLeyaut-> Belirli sabit bir tasarım içerisine bir parça tasarımı gömmemizi sağlar -
	 * 'Header ve footer sabit tasarımların arasına sürekli farklı bir sayfa çekmek', üç parametre alır
	 * 
	 * Parametreler
	 * $latoutPath = Sabit tasarımın yolunu belirtmemiz gerekiyor, başlangıç noktası olarak Layout dizisi sabit alınır
	 * Örnek = $latoutPath = "Frontend/index" -> Girilen bu değerler sonucu -> Layout/Frontend/indexLayout.php şeklinde ayarlanır.
	 * 
	 * $viewPath = Layout içerisine eklemek istediğimiz parça tasarımın yolunu girmemiz gerekiyor
	 * Örnek = $viewPath = "default/index" -> Girilen bu değerler sonucu -> Moduls/default/view/indexView.php şeklinde ayarlanır.
	 * 
	 * $data = Sayfa yüklenirken ardından göndermek istediğimiz değerleri göndeririz. 
	 * 
	 * 
	 * 
	 */




	class View
	{
		
		public static function page($path,$data){

			try {

				if (is_string($path)) {
					//String ifade girilmiş mi kontrol ettik

					$path = explode("/", $path);
					//Girilen değerleri parçaladık
					if(count($path) <= 2 && count($path) > 1){
						//Eksik veya fazla değer girilmişmi kontrol ettik.

						$MODULS = $path[0];
						$PAGE   = $path[1];
						//Modul ve sayfa adını aldık;

						if(file_exists($file = DIRECTORY . "/Moduls/{$MODULS}/view/{$PAGE}View.php")){
							//Dosya varmı kontrol ettik.

							if(isset($_SESSION["lan"])){
								//Dil dosyaları eklenmecek mi kontrol ettik
								if(file_exists($lan_file = DIRECTORY . "/Lang/{$_SESSION["lan"]}.php")){
									require_once $lan_file;
								}else{
									throw new Exception("<span style='color:red'> Lang/{$_SESSION["lan"]}.php bulunamadı ! </span>");
								}
							}

							require_once $file;
							
						}else{
							throw new Exception("<span style='color:red'> Moduls/{$MODULS}/view/{$PAGE}View.php bulunamadı ! </span>");
						}


					}else{
						throw new Exception('<span style="color:red">$path fazla veya eksik değer girdiniz.</span> Örnek > $path = "Moduls(Klasör)/View(php & html dosyası)" ');
					}


				}else{
					throw new Exception('<span style="color:red"> $path parametre yanlış değer girilmiş </span>, lütfen dosya yolunu giriniz Örnek > $path = "Moduls dosya/sayfa"');
				}
				

			} catch (Exception $e) {
				echo $e->getMessage();
			}

		}

		public static function viewLeyaut($latoutPath,$viewPath,$data){

			try {

				if(is_string($latoutPath) && is_string($viewPath)){
					//String ifade girilmiş mi kontrol ettik

					$latoutPath = explode("/", $latoutPath);
					$viewPath   = explode("/", $viewPath);
					if( (count($latoutPath) <= 2 && count($latoutPath) > 1) && (count($viewPath) <= 2 && count($viewPath) > 1) ){
						//Eksik veya fazla değer girilmişmi kontrol ettik.


						$LAYOUT     = $latoutPath[0];
						$LAYOUTPAGE = $latoutPath[1];

						$MODULS = $viewPath[0];
						$PAGE   = $viewPath[1];

						//Değerleri düzgün ifadelere atadık.

						if(file_exists($PAGE_FILE = DIRECTORY . "/Moduls/{$MODULS}/view/{$PAGE}View.php")){
							//Layout içine eklenecek dosyayı ekle.
							
							ob_start();
							//Çıktıyı değişkene almak için ob başlattık

							if(isset($_SESSION["lan"])){
								//Dil dosyaları eklenmecek mi kontrol ettik
								if(file_exists($lan_file = DIRECTORY . "/Lang/{$_SESSION["lan"]}.php")){
									require_once $lan_file;
								}else{
									throw new Exception("<span style='color:red'> Lang/{$_SESSION["lan"]}.php bulunamadı ! </span>");
								}
							}

							require_once $PAGE_FILE;
							//Tasarımı getirdik

							$data["VIEW"] = ob_get_contents();
							//Sayfayı tamponladık, Layout içine basmak için değişkene aldık.

							ob_end_clean();
							//Tamponlama, ob işlemini sonlandırdık.


							if(file_exists($LAYOUT_FILE = DIRECTORY . "/Layout/{$LAYOUT}/{$LAYOUTPAGE}Layout.php")){
								//Layout dosyası varmı kontrol ettik

								require_once $LAYOUT_FILE;

							}else{
								throw new Exception("<span style='color:red'> Layout/{$LAYOUT}/{$LAYOUTPAGE}Layout.php bulunamadı ! </span>");
							}

							//ob sonlandırıldı ve tasarımı değişkene aldık 

						}else{
							throw new Exception("<span style='color:red'> Moduls/{$MODULS}/view/{$PAGE}View.php bulunamadı ! </span>");
						}



					}else{
						throw new Exception('<span style="color:red">$latoutPath veya $viewPath fazla veya eksik değer girdiniz.</span> Örnek > $latoutPath = "Backend/View(php & html dosyası)" & $viewPath = "Moduls dosya/sayfa"');
					}


				}else{
					throw new Exception('<span style="color:red"> $latoutPath veya $viewPath parametre yanlış değer girilmiş </span>, lütfen dosya yolunu giriniz Örnek > $latoutPath = "Backend/index" & $viewPath = "Moduls dosya/sayfa"');
				}

			} catch (Exception $e) {
				echo $e->getMessage();
			}

		} 


	}


	/**
	 * 
	 */
	class seo
	{
		
		public static function setTitle($title_name){
			$_SESSION["viewbag"]["title"] = $title_name;
		}

		public static function setDescription($description_name){
			$_SESSION["viewbag"]["description"] = $title_name;
		}

		public static function setDesTit($title_name,$description_name){
			$_SESSION["viewbag"]["title"] = $title_name;
			$_SESSION["viewbag"]["description"] = $title_name;
		}

		public static function getTitle(){

			if( isset($_SESSION["viewbag"]["title"]) ){
				echo $_SESSION["viewbag"]["title"];
			}else{
				echo $_SESSION["viewbag"]["title"] = "Null";
			}

		}

		public static function getDescription(){
			if( isset($_SESSION["viewbag"]["description"]) ){
				echo $_SESSION["viewbag"]["description"];
			}else{
				echo $_SESSION["viewbag"]["description"] = "Null";
			}
		}

	}

