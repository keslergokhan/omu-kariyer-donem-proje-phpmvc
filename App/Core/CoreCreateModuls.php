<?php 
	/**
	 * CoreCreateModuls
	 * 
	 * rote.php içerisinde bir url yolu ve bu url yoluna istek yapıldığında çalıştırılacak method ve bu methodun controlleri belirtilir
	 * Route::getCreate("iletisim","tasarim/contact@index",false,true);
	 * 
	 * Örnek de yapmış olduğumuz gibi iletisim sayfasında girildiğinde Moduls/tasarim klasörü içerisinde controller/contactController.php içerisinde de index methodu
	 * çalıştırılır.
	 * 
	 * Fakat bu işlemler eğer bu dosyalar var ise yapılır, dosyalar oluşturulmamış ise manuel olarak oluşturmamız gerekti işte burada bu sınıf devreye giriyor
	 * rote oluştururken 4.parametre olan $fileCreate=true yaptığımızda oluşturulmamış dosya sistemi otomatik oluşturulacaktır
	 * 
	 * Bu sınıf Core.php de otomatik olarak kullanılmaktadır.
	 * 
	 */
	class CoreCreateModuls
	{
		private $MODULS;
		private $METHOD;
		private $CONTROLLER;
		private $MODEL;
		private $DIRMODULS;
		private $PARAMS;

		public function __construct($moduls,$model_controller,$method,$params){
			$this->MODULS = $moduls;
			$this->METHOD = $method;
			$this->CONTROLLER = $model_controller."Controller";
			$this->MODEL = $model_controller."Model";
			$this->DIRMODULS = DIRECTORY."/Moduls/".$this->MODULS;
			$this->PARAMS = $params;
			//Değerleri parçaladık


			$this->start();
			//Fonksiyonları kullanarak klasör oluşturma işlemine başladık
		}

		public function start(){
			$this->createFolders($this->DIRMODULS);
			$this->createFolders($this->DIRMODULS."/controller");
			$this->createFolders($this->DIRMODULS."/model");
			$this->createFolders($this->DIRMODULS."/view");

			$this->fileWrite(
				$this->DIRMODULS."/controller/".$this->CONTROLLER.".php",
				$this->ModelClass($this->CONTROLLER,$this->METHOD,"Controller",$this->PARAMS)
			);
			$this->fileWrite(
				$this->DIRMODULS."/model/".$this->MODEL.".php",
				$this->ModelClass($this->MODEL,$this->METHOD."Model","Model"));
		}

		public function fileWrite($file,$text){

			try {
				if(!file_exists($file)){
					if($dosya = fopen($file, 'x')){
						if(!fwrite ($dosya, $text)){
							throw new Exception("<span style='color:red'>{$file} bir hata oluştu !</span> <br>");
						}
					}else{
						throw new Exception("<span style='color:red'>{$file} dosya açma işleminde bir hata oluştu !</span> <br>");
					}
				}else{
					throw new Exception("<span style='color:red'>{$file} zaten oluşturulmuş !</span> lütfen route.php içerisinde 4.Parametre = fileCreate = false yapınız<br>");
				}
				
				
				fclose($dosya);
			} catch (Exception $e) {
				echo $e->getMessage();	
			}
			
		}

		public function createFiles($files){
			try {
				if(is_array($files)){
					foreach ($files as $key => $value) {
						if(!file_exists($value))
							if(!touch($value)) throw new Exception("<span style='color:red'>{$view_file} Oluşturulamadı ! </span> <br>");
					}
				}else{
					if(!file_exists($files))
						if(!touch($files)) throw new Exception("<span style='color:red'>{$view_file} Oluşturulamadı ! </span> <br>");
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}


		public function createFolders($folders){
			//Birden fazla Klasörü oluşturma fonksiyonu

			try {

				if(is_array($folders)){
					foreach ($folders as $key => $value) {
						if(!is_dir($value))
							if(!mkdir($value)) throw new Exception("<span style='color:red'>{$view_file} Oluşturulamadı ! </span> <br>");
					}
				}else{
					if(!is_dir($folders))
						if(!mkdir($folders)) throw new Exception("<span style='color:red'>{$view_file} Oluşturulamadı ! </span> <br>");
				}
				
					

			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

		public function ModelClass($ClassName,$MethodName,$extends=null,$params=null){
			if(!empty($extends) && $extends != null){
				$extends = "extends ".$extends;
			}

			if(is_array($params)){
				//Eğer parametre var ise
				
				$sql = implode(",", array_map(function ($item) {
				    	return '$params'.$item;
				}, $params ));
				$params = $sql;
			}
			
			return "
<?php 
class {$ClassName} {$extends}
{

	public function {$MethodName}({$params})
	{	
		
	}

}
			";
		}


	}


 ?>
