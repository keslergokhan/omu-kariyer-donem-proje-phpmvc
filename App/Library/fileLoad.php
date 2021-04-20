<?php
	require_once(__DIR__.'/SimpleImage-edit.php');

	/*
		->fromFile('image.jpg')                     // load image.jpg
	    ->autoOrient()                              // adjust orientation based on exif data
	    ->resize(320, 200)                          // resize to 320x200 pixels
	    ->flip('x')                                 // flip horizontally
	    ->colorize('DarkBlue')                      // tint dark blue
	    ->border('black', 10)                       // add a 10 pixel black border
	    ->overlay('watermark.png', 'bottom right')  // add a watermark image
	    ->toFile('new-image.png', 'image/png')      // convert to PNG and save a copy to new-image.png
	    ->toScreen();                               // output to the screen
	*/

class fileLoad extends claviska\SimpleImage_edit
{
	
	private $_FILE;
	public $_BASE_URI = "Public/dimg/";
	public static $_UPLOAD_STATUS = [];
	private static $_FILE_URI;

	private $_phpFileUploadErrors = array(
	    0 => '‎Hata yok, dosya başarı ile yüklendi‎',
	    1 => '‎Yüklenen dosya boyutu form Upload sınırını aşıyor!',
	    2 => '‎Yüklenen dosya, HTML formunda belirtilen MAX_FILE_SIZE yönergesini aşıyor‎',
	    3 => '‎Yüklenen dosya yalnızca kısmen yüklendi‎',
	    4 => '‎Dosya yüklenmiyor',
	    6 => '‎Geçici bir klasör eksik‎',
	    7 => '‎Diske dosya yazılamamış.‎',
	    8 => '‎Bir PHP uzantısı dosya yüklemesini durdurdu.‎',
	);

	public function setFile($FILE){
		$this->_FILE = $FILE;
		return $this;
	}

	public function fileDeleteStart(){
		//Eğer herhangi bir hata çıkar ise yüklenen dosyaları sil.
		if(count(self::$_UPLOAD_STATUS) > 0){ //Eğer bir değer var ise
			foreach (self::$_UPLOAD_STATUS as $value) { //Yüklenmiş olan dosyaların dizisini sıraladık
				if($value[0]){//Eğer dosya başarılı yüklenmiş ise
					if(file_exists($this->_BASE_URI.self::$_FILE_URI.'/'.$value[1])) unlink($this->_BASE_URI.self::$_FILE_URI.'/'.$value[1]); //Yosyaya ulaş ve sil
				}
			}
		}
	}

	public function fileDelete($file,$file_uri=null,$update=false){
		
		if (empty($file_uri) && $file_uri=null) {
			$file_uri = $this->_BASE_URI.self::$_FILE_URI;
		}else{
			$file_uri = $this->_BASE_URI.self::$_FILE_URI.$file_uri."/";
		}

		if($update){ //Eğer gönderilen işlem örnek bir form upload işlemi ise ve form içerisinde setting[delete_file] tanımlı ise
			$i = 0;
			foreach ($this->_FILE["tmp_name"] as $input => $tmp_name) {
				if( !empty($this->_FILE["name"][$input]) ){
					if(file_exists($file_uri.$file[$i])) unlink($file_uri.$file[$i]); //Yosyaya ulaş ve sil
					if(file_exists($file_uri."xs-".$file[$i])) unlink($file_uri."xs-".$file[$i]); //Yosyaya ulaş ve sil
				}
				$i++;
			}
		}else{
			if(is_array($file)){
				foreach ($file as $value) {
					if(file_exists($file_uri.$value)) unlink($file_uri.$value); //Yosyaya ulaş ve sil
					if(file_exists($file_uri."xs-".$value)) unlink($file_uri."xs-".$value); //Yosyaya ulaş ve sil
				}
			}else{
				if(file_exists($file_uri.$file)) unlink($file_uri.$file); //Yosyaya ulaş ve sil
				if(file_exists($file_uri."xs-".$file)) unlink($file_uri."xs-".$file); //Yosyaya ulaş ve sil
			}
		}
	}


	public function formFileInputValue ($form){

		//Form içerinse eklenen resimlerimlerin input name ile dosya adlarını ekledik veritabanına kayıt için

		if(count(self::$_UPLOAD_STATUS) > 0){

			foreach (self::$_UPLOAD_STATUS as $value) {
				if(isset($value[2]) || !empty($value[2])){
					$form += [$value[2]=>$value[1]];
				}
			}

			return $form;

		}else{
			return $form;
		}

	}

	public function imageLoadStart($file_uri,$img_name=null,$width=null,$height=null,$img_xs=false){

		try {
			
			self::$_FILE_URI = $file_uri;

			foreach ($this->_FILE["tmp_name"] as $input => $tmp_name) {
				//Gönderilen tüm dosyaları döngü içinde bakıyoruz

				

				//Resim seçilmişmi seçilmemişmi, input değeri boşmu kontrolettik
				if( !empty($this->_FILE["name"][$input]) ){

						//İsimlendirme 
						//Resmin ismi defaultmu belirlensin yoksa gönderilen isimmi olsun
						$file_name_path = pathinfo($this->_FILE["name"][$input]); // Resim ismi ve uzantı parçaladık.

	                	//Seo fonksiyonu ile gelen ismin veya gönderilen simi temizledik => ornek-metin-haline-getirdik
	                	$pat_filter_name = empty($img_name) ? helper::seo($file_name_path["filename"]) : helper::seo($img_name);

	                	$pat_filter_exten = $file_name_path["extension"];//sadece dosya uzantısını aldık...

	                	//Resmin adı.
	                	$IMG_NAME = $pat_filter_name."-" . rand(0, 1000) . "." . $pat_filter_exten; //Aynı resmi kayıt etmemesi açısından sayı ataması yaptık


						$this->fromFile($tmp_name);
						$this->autoOrient();//Telefon ile çekilmiş ise bazı durumlarda yatay olabiliyor onu düzelttik.

						//Girilen boyutlandırma değerlerine göre boyutlandırdık,alternarif koşullar değerledirildi
						if ($height == NULL && $width != NULL) {
		                    $this->fitToWidth($width);
		                } elseif ($height == NULL && $width==NULL) {
		                    $this->fitToWidth($this->getWidth());
		                } elseif ($height != NULL && $width!=NULL) {
		                    $this->resize($width, $height);
		                } elseif ($height != NULL && $width == NULL) {
		                    $this->fitToHeight($height);
		                }

						$this->toFile(
							$this->_BASE_URI.$file_uri.'/'.$IMG_NAME,
							$this->_FILE["type"][$input]
						);

						//Daha küçük bir versyonunu kayıt ettik.
						if($img_xs){
							if($this->getWidth()>300){
								$this->fitToWidth(125);
								$this->toFile(
									$this->_BASE_URI.$file_uri.'/'."xs-".$IMG_NAME,
									$this->_FILE["type"][$input]
								);
							}
						}

						// $_FILES error kontrolu, form gönderme işleminde bir hata oluştumu kontrol ettik
						if($this->_FILE["error"][$input] != 0){
							throw new Exception($this->_FILE["name"][$input]. $this->_phpFileUploadErrors[$this->_FILE["error"][$input]]);
						}

						if(file_exists($this->_BASE_URI.$file_uri.'/'.$IMG_NAME)){
							self::$_UPLOAD_STATUS[] = [true,$IMG_NAME,$input];
							if($img_xs){
								self::$_UPLOAD_STATUS[] = [true,"xs-".$IMG_NAME];
							}
						}else{
							throw new Exception($this->_FILE["name"][$input]." Resim ".$file_uri." klasör içeriside bulunamadı !");
						}

					}

				}

				
			return self::$_UPLOAD_STATUS;

		} catch (Exception $e) {

			$this->fileDeleteStart();//Eğer herhangi bir hata oluştuysa daha öncesinde yüklenmiş olan tüm dosyaları sil
			return helper::catchReturn(0,$e->getMessage());

		}

	}

	public function fileLoadStart($file_uri,$file_name=null){
		try {
			
			foreach ($this->_FILE["tmp_name"] as $input => $tmp_name) {

				if(!empty($this->_FILE["name"][$input])){
						if($this->_FILE["tmp_name"][$input] <= 20971520){ 

							//Gönderilen tüm dosyaları döngü içinde bakıyoruz
							self::$_FILE_URI = $file_uri;

							//İsimlendirme 
							//Dosya ismi defaultmu belirlensin yoksa gönderilen isimmi olsun
							$file_name_path = pathinfo($this->_FILE["name"][$input]); // Dosya ismi ve uzantı parçaladık.

				        	//Seo fonksiyonu ile gelen ismin veya gönderilen simi temizledik => ornek-metin-haline-getirdik
				        	$pat_filter_name = empty($file_name) ? helper::seo($file_name_path["filename"]) : helper::seo($file_name);

				        	$pat_filter_exten = $file_name_path["extension"];//sadece dosya uzantısını aldık...

				        	//Dosya adı.
				        	$FILE_NAME = $pat_filter_name."-" . rand(0, 1000) . "." . $pat_filter_exten; //Aynı resmi kayıt etmemesi açısından sayı ataması yaptık

				        	// $_FILES error kontrolu, form gönderme işleminde bir hata oluştumu kontrol ettik
							if($this->_FILE["error"][$input] != 0){
								throw new Exception($this->_FILE["name"][$input]." ".$this->_phpFileUploadErrors[$this->_FILE["error"][$input]]);
							}

							$kontrol = move_uploaded_file($this->_FILE["tmp_name"][$input], $this->_BASE_URI.$file_uri.'/'.$FILE_NAME);
							//Dosya yükleme işlemi başarılı oldumu kontrol yaptık
		                    if ($kontrol){ 
		                    	//Yüklenen dosya klasör içinde varmı kontrol ettik.
		                    	if(file_exists($this->_BASE_URI.$file_uri.'/'.$FILE_NAME)){
		                    		self::$_UPLOAD_STATUS[] = [true,$FILE_NAME,$input];
								}else{
									throw new Exception($this->_FILE["name"][$input]." Resim ".$file_uri." klasör içeriside bulunamadı !");
								}
		                    }else{
		                        throw new Exception("Dosya yükleme işlemi başarısız !");
		                    }

		                    

						}else{
							throw new Exception(" Dosya boyutu 20 MG üstünde !", 1);
						}//Size if
					}//Name if
				}//Foreach

				
			
			return self::$_UPLOAD_STATUS;

		} catch (Exception $e) {
			$this->fileDeleteStart();//Eğer herhangi bir hata oluştuysa daha öncesinde yüklenmiş olan tüm dosyaları sil
			return helper::catchReturn(0,$e->getMessage());
		}
	}
}
