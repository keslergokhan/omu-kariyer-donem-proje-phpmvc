<?php 

	/**
	 * 
	 * CorePieceView
	 * 
	 * Tasarımı daha dinamik daha parçalı bir hale getirmek için bölümler oluşturmamıza yarar
	 * Örnek : Leyaut alanında slider,menü gibi alanları bu şekilde daha dinamik ve daha parçalı bir yapı halibe getirebiliriz
	 * 
	 * Parametreler
	 * $path = Moduls/Controller@method  şeklinde değer giriş yaptığımızda uzantı da bulunan function çalışır
	 * 
	 * 
	 */
	class Piece
	{
		public static function view($path){

			try {

				if(is_string($path)){
					//String ifade girilmiş mi kontrol ettik

				
					$modulPath = explode("@", $path);
					//Moduls / Controller @ method bilgisi için ilk olarka @ ikiye ayırdık

					$path = explode("/", $modulPath[0]);
					// @ öncesi Moduls/Controller ve @sonrası methodu Olacak şekilde ayarladık

					$path = array_merge($modulPath,$path);
					array_shift($path);


					if(count($path) <= 3 && count($path) > 2){
						//Eksik veya fazla değer girilmişmi kontrol ettik.

						list($METHOD,$MODULS,$CONTROLLER) = $path;
						$CONTROLLER .= "Controller";
						Core::$MODULS = $MODULS; //boot.php alanında model klasörünü eklemek için hangi dosyada olduğumuzu belirttik
						//Bilgileri değişkenlere aktardık.

						$file = DIRECTORY . "/Moduls/{$MODULS}/";
                        $fileController = DIRECTORY . "/Moduls/{$MODULS}/controller/{$CONTROLLER}.php";

						if(is_dir($file)){
                            //Moduls içerisinde klasör kontrol edildi

                            if(file_exists($fileController)){
                                //controller/ içinde .php dosyası varmı kontrol ettik.
                                require_once($fileController);

                                if(class_exists($CONTROLLER)){
                                    // .php içerisinde class varmı kontrol ettik.

                                    $class = new $CONTROLLER;

                                    if(method_exists($class, $METHOD)){
                                        //Class içerisinde method varmı kontroller ettik.

                                        return call_user_func([$class,$METHOD]);
                                        //Methoda parametreleri gönderdik

                                    }else{
                                        throw new Exception("{$CONTROLLER}.php / Class / <span style='color:red'> public function {$METHOD} </span> Bulunamadı ! <br>");
                                    }

                                }else{
                                    throw new Exception("Controller / {$CONTROLLER}.php / <span style='color:red'>Class {$CONTROLLER}</span> Bulunamadı ! <br>");
                                }

                            }else{
                               throw new Exception("Moduls / {$MODULS} / Controller / <span style='color:red'>{$CONTROLLER}.php</span> Bulunamadı ! <br>");
                            }
                            
                        }else{
                           throw new Exception("Moduls / <span style='color:red'>{$MODULS}</span> / Bulunamadı ! <br>");
                        }

					}else{
						throw new Exception('<span style="color:red">$viewPath veya $controllerPath fazla veya eksik değer girdiniz.</span> Örnek > $viewPath = "Moduls/fila" ve $controllerPath = "Moduls/controller@method"');
					}


				}else{
					throw new Exception('<span style="color:red"> $viewPath veya $controllerPath parametre yanlış değer girilmiş </span>, lütfen dosya yolunu giriniz Örnek > $viewPath = "default/index" & $controllerPath = "Controller/dosya@method"');
				}

			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}
 ?>