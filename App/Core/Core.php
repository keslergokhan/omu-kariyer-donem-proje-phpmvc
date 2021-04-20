<?php

    /*
     *
     * Core
     * Core/coreRoute içerisinde bulundan static methodlar ile $routes dizisi içerisine oluşturulmuş rotaları
     * kontrol eder.
     *
     *
     */

    class Core{

        protected $nowName;
        protected $nowPath;
        protected $nowMethod;
        protected $nowUrl;
        protected $nowBase;
        protected $nowProtocol;
        protected $defaultRoute;
        protected static $routes = [];

        public static $getParams = [];

        public static $MODULS;

        public function __construct($config)
        {
            $this->nowName = $_SERVER["SERVER_NAME"];
            // www.name.com

            $this->nowPath = $_SERVER["REQUEST_URI"];
            // /klasor/yapisi

            $this->nowBase = BASE;
            // config.php sayfa saf url

            $this->nowMethod = $_SERVER["REQUEST_METHOD"];
            // sayfaya get/post 

            $this->nowProtocol = stripos($_SERVER['REQUEST_SCHEME'], 'https') !== false ? 'https://' : 'http://';
            // https & http değeri

            $this->nowUrl = $this->nowProtocol.$this->nowName.$this->nowPath;
            //Tüm bilgiler birleştiğinde ortaya çıkan url yapısının hepsi

            
            Route::defaultRoute($this->defaultRoute = $config["DEFAULT_ROUTE"]);
            // Siteye ilk giriş anında varsayılan yol

            $this->startRouteControl();

            /*
            echo "<pre>";
            print_r(self::$routes);
            echo "</pre>";
            */
        }

        public function startRouteControl()
        {
            if (strstr($this->nowUrl,"?")){
                $link_kontrol = explode("?",$this->nowUrl,-1);
                list($this->nowUrl)=$link_kontrol;
                //Girilen url adresi ile route.php de oluşturulan url değerlerlerini kontrol etmemiz açısından temiz bir url yapısına ihtyacımız var ?deneme=deger gibi $_GET[] işlemlerini temizlememiz gerek
            }

            self::$getParams = array_reverse(explode("/", $this->nowUrl));

            //Url adresini parçaladık url adresindeki verilere erişebilmemiz için http://www.ornek.com/MVC-2021/webadmin/adminUpdate/1
            // Core::$getParams[0] ile url adresinde = 1
            // Core::$getParams[1] ile url adresinde = adminUpdate gibi

            $pageControl = true;
            foreach (self::$routes as $route){
                //$routes içine girilen adresleri döngü içinde konrol edeceğiz.

                list($method,$link,$path,$auto,$fileCreate) = $route;
                $link = $this->nowBase.$link;
                //$routes dizi içindeki değerleri sırası ile değişkenlere atadık

                $methodCheck = $this->nowMethod == $method;
                //Sayfaya yapılan ziyaret Post/Get ile route girilen değer eşleşiyormu kontrol ettik

                $pathCheck = preg_match("@^{$link}$@", $this->nowUrl, $params);
                // url girilen link ile route.php de belirtilen $link parametresi aynı ise kontrol

                array_shift($params);
                //İlk elemanı sildik gereksiz

                if ($methodCheck && $pathCheck) {
                    $pageControl = false;
                    // route de $routes dizisine gönderilen get veya post işlemi ile sayfa isteği aynımı kontrol ettik

                    $pathFilter = explode("@", $path);
                    $pathFilter = array_merge($pathFilter,explode("/", $pathFilter[0]));
                    //Moduls(klasör ismi), controller ve method isimlerini almak için $path parçaladık
                    array_shift($pathFilter);

                    if(count($pathFilter) == 3){
                        //Route içinde @method tanımlı ise
                        list($METHOD,$MODULS,$CONTROLLER) = $pathFilter;
                    }else{
                        list($MODULS,$CONTROLLER) = $pathFilter;
                        $METHOD = "index";
                        //Tanımlı değil ise varsayılan method index.
                    }
                    $CONTROLLER_MODEL = $CONTROLLER;
                    $CONTROLLER.="Controller";


                    self::$MODULS = $MODULS;
                    //boot.php sayfasından model dosyasını bulması için moduls static yaptık.

                    if(($auto == false && !is_string($auto)) || (is_string($auto) && isset($_SESSION[$auto]))){
                        //Giriş kontrolu yaptık false veya session tanımlı ve var ise

                        if($fileCreate == true){
                            //Klasör yapısını oluşturmamız isteniyor ise //
                            new CoreCreateModuls($MODULS,$CONTROLLER_MODEL,$METHOD,$params);
                        }

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

                                        return call_user_func_array([$class,$METHOD], array_values($params));
                                        //Methoda parametreleri gönderdik

                                    }else{
                                        echo "{$CONTROLLER}.php / Class / <span style='color:red'> public function {$METHOD} </span> Bulunamadı ! <br>";
                                        exit();
                                    }

                                }else{
                                    echo "Controller / {$CONTROLLER}.php / <span style='color:red'>Class {$CONTROLLER}</span> Bulunamadı ! <br>";
                                    exit();
                                }

                            }else{
                                echo "Moduls / {$MODULS} / Controller / <span style='color:red'>{$CONTROLLER}.php</span> Bulunamadı ! <br>";
                                exit();
                            }
                            
                        }else{
                            echo "Moduls / <span style='color:red'>{$MODULS}</span> / Bulunamadı ! <br>";
                            exit();
                        }


                    }else{
                        header("Location:{$this->nowBase}");
                        exit();
                    }

                    
                }

            }

            if($pageControl){
                echo "Sayfa bulunamadı";
            }
        }

    }
    ?>
