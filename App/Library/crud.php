<?php
class Crud
{
    public $_db;	
    public $_sql;    

    function __construct($db){
        $this->_db = $db;
    }

    public function sqlString($dizi)
    {

        $sql = implode(",", array_map(function ($item) {
            return $item . "=?";
        }, array_keys($dizi)));

        return $sql;
    }

    public function formDelete($form){
        
        /*
            <form> içerisinde değerlerini aldıktan sonra silmek istediğimiz post veya get değerleri olabilir.

            <input type="text" name="setting[form_delete]" value="ornek_input_name1,ornek_input_name2">
            Yukarıdaki settings input değerine silmek istediğiniz post/get değerlerini yukarıdaki gibi name isimlerini girniz

            setting[form_delete] var ise ve boş değilse
        */

        try {
            if(!isset($form["status"]) ){// name = setting[status] durum dönmüyor ise

                if(isset($form["setting"]["form_delete"])){
                    $delete = explode(",",$form["setting"]["form_delete"]); // ',' İle birden fazla değer gönderilmiş ise.
                    foreach ($delete as $value) { // setting[form_delete] içerisinde gönderilen intput name değerlerini sildik
                        unset($form[$value]);
                    }
                }

                //İşlemden farklı from içinde gönderdiğimiz genel taslakları sildik.
                $setting = ["setting","default","images","file"];
                foreach ($setting as $value) {
                    if(isset($form[$value])){
                        unset($form[$value]);
                    }
                }
                return $form;
            }else{
                return $form;
            }
        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }
        
    }

    public function formSeoSet($form){
        try {
            if(isset($form["setting"]["seo"])){
                $path = explode(",", $form["setting"]["seo"]);
                foreach ($path as $value) {
                    $form[$value] = helper::seo($form[$value]);
                }

                return $form;
            }else{
                return $form;
            }
        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }
    }

    public function formDefaultValue($form){
        /*
            Bazı input değerleri boş bırakılabilir. Boş bırakılan input değerlernin otomatik default bir değer ile doldurulmasını
            isteyebiliriz.

            <input type="text" id="contact-info-vertical" class="form-control" name="default[urun_resim_alt_tr]" placeholder="Resim alt">
            Yukarıda ki input bazı durumlarda boş geçilebilir, fakat alt etiketi seo için önemli olduğu için varsayılan bir değer atamamzı
            ve veritabanına null değilde değer girmemiz daha güzel olur.

            <input type="text" name="setting[default]" value="default_input_name">
            Yukarıdaki settings ayarı içerine default değerlerine atanmasını istediğinz ve asla boş geçilmeyen form input elemanın name değerini giriniz.
        
            Bu sayede name=default[input_name] şeklinde tanımladığınız bütün input değerleri boş geçilmiş olsa bile otomatik olarak  setting[default]
            içerisinde belirtilen input değeri atanır.


        */

        try {
            if(isset($form["default"]) && count($form["default"]) > 0 && !isset($form["status"])){
                $default_value = $form["setting"]["default"];
                foreach ($form["default"] as $name => $value) {

                    if(empty($value)){
                        $form += [$name=>$form[$default_value]];
                    }else{
                        $form += [$name=>$value];
                    }

                }
                return $form;
            }else{
                return $form;
            }

        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }
       
    }




    public function wliste($table, $where, $deger, $durum = null)
    {
        try {
            if (!empty($durum)) {
                $durum = "and durum='0'";
            }

            $sql = $this->_db->prepare("SELECT * FROM $table where $where=? {$durum}");
            $sql->execute([$deger]);

            return $sql;

        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }
    }

    /*LİST*/
    public function listFetchAll($table){
        
        try {
            
            $sql = $this->_db->prepare("SELECT * FROM {$table}");
            $status = $sql->execute();

            if($status){
                return $sql->fetchAll(PDO::FETCH_ASSOC);
            }else{
                throw new Exception("{$table} veri çekme sırasında bir hata oluştu !");
            }

        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }

    }

    public function list($table){
        try {

            $this->_sql = "SELECT * FROM {$table} %WHERE%";
            return $this;

        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }
    }

    public function column($table,$column){
        try {
            
            $this->_sql = "SELECT {$column} FROM {$table} %WHERE%";
            return $this;

        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }
    }

    public function exec($execute=null){
        try {
            $this->_sql = str_replace("%WHERE%", "", $this->_sql);
            $this->_sql = $this->_db->prepare("{$this->_sql}");
            if(is_array($execute) && !empty($execute)){
                $status = $this->_sql->execute(array_values($execute));
            }else{
                $status = $this->_sql->execute();
            }
            if($status){
                return $this;
            }else{
                throw new Exception("Execute işleminde bir hata oluştu.");
            }
        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }
    }

    public function where($where="",$execute=null){
        try {
            
            $this->_sql = $bodytag = str_replace("%WHERE%", $where, $this->_sql);
            $this->_sql = $this->_db->prepare("{$this->_sql}");

            if(is_array($execute) && !empty($execute)){
                $status = $this->_sql->execute(array_values($execute));
            }else{
                $status = $this->_sql->execute();
            }

            if($status){
                return $this;
            }else{
                throw new Exception("Execute işleminde bir hata oluştu.");
            }

        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }
    }

    public function get($fetch="All"){
        try {
            
            if($fetch == "All"){
                return $this->_sql->fetchAll(PDO::FETCH_ASSOC);
            }else if($fetch == "Row"){
                return $this->_sql->fetch(PDO::FETCH_ASSOC);
            }

        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }
    }

    /*list*/

   

    public function add($table,$form,$setting=null){

        try {

            $form = $this->formDefaultValue($form); 

            //Gönderilmiş bir dosya var ise

           $fileLoad = new fileLoad();
            if(isset($_FILES)){


                $file_name = null;
                if(isset($form["setting"]["file_name_input"])){
                    $file_name = $form[$form["setting"]["file_name_input"]];
                }else if(isset($form["setting"]["default"])){
                    $file_name = $form[$form["setting"]["default"]];
                }

                //Gönderilen resim ise
                if(isset($_FILES["images"])){
                    $width = $form["setting"]["height"] ?? null;
                    $height = $form["setting"]["width"] ?? null;

                    $return = $fileLoad->setFile($_FILES["images"])->imageLoadStart($table,$file_name,$width,$height,true);
                    if(isset($return["status"]) && $return["status"] == false){
                        return helper::catchReturn(false,$return["message"]);
                    }
                } 

                //Gönderilen dosya ise
                if(isset($_FILES["file"])) $fileLoad->setFile($_FILES["file"])->fileLoadStart($table,$file_name);

                $form = $fileLoad->formFileInputValue($form);
                // type file içerisindeki input değerler post/get içerisinde gitmediği için daha sonra eklenen resim adları ile beraber 
                // input name değerlerine eşleştrip form içerisine ekledik
            }

            $form = $this->formSeoSet($form);
            $form = $this->formDelete($form);//Form demizledik boş ve gereksiz değerleri sildik

            $sql = $this->_db->prepare("INSERT INTO {$table} set {$this->sqlString($form)}");
            $kontrol = $sql->execute(array_values($form));

            if($kontrol){
                return helper::catchReturn(true,"Ekleme İşlemi Başarılı !");
            }else{
                if(isset($_FILES)) $fileLoad->fileDeleteStart();//Veritabanı işlemi başarısız olursa eklenmiş dosyaları sildik
                throw new Exception("İşlem başarısız oldu lütfen tekrar deneyin !", 1);
            }
        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }
        

    }


    public function update($table,$where,$form,$setting=null){
        try {

            if(!isset($form[$where])){
                throw new Exception("Güncellenmek istenen {$table} nin {$where} degerine ulaşılamadı !");
            }

            //Güncelleme işlemi sonrası eski dosyaları silmek isteniyorsa
            $delete_file = null;
            if(isset($form["setting"]["delete_file"])){
                $delete_file = explode(",", $form["setting"]["delete_file"]);
            }

            $where_value = $form[$where] ?? null; // where değeri post içerisinde gönderiliyormu

            $form = $this->formDefaultValue($form);

            $fileLoad = new fileLoad();
            if(isset($_FILES)){

                $file_name = null;
                if(isset($form["setting"]["file_name_input"])){
                    $file_name = $form["setting"]["file_name_input"];
                }else{
                    if(isset($form["setting"]["default"])) $file_name = $form[$form["setting"]["default"]];
                }

                //Gönderilen resim ise
                if(isset($_FILES["images"])){
                    $width = $form["setting"]["height"] ?? null;
                    $height = $form["setting"]["width"] ?? null;
                    $return = $fileLoad->setFile($_FILES["images"])->imageLoadStart($table,$file_name,$width,$height,true);

                    if(isset($return["status"]) && $return["status"] == false){
                        return helper::catchReturn(false,$return["message"]);
                    }
                } 

                //Gönderilen dosya ise
                if(isset($_FILES["file"])) $fileLoad->setFile($_FILES["file"])->fileLoadStart($table,$file_name);

                $form = $fileLoad->formFileInputValue($form);
                // type file içerisindeki input değerler post/get içerisinde gitmediği için daha sonra eklenen resim adları ile beraber 
                // input name değerlerine eşleştrip form içerisine ekledik
            }

            $form = $this->formSeoSet($form);
            $form = $this->formDelete($form);//Form demizledik boş ve gereksiz değerleri sildik
            $sql = $this->_db->prepare("UPDATE $table set {$this->sqlString($form)} where $where={$where_value}");
            $kontrol = $sql->execute(array_values($form));


            if($kontrol){
                if(!empty($delete_file) && isset($_FILES)){
                    $fileLoad->fileDelete($delete_file,null,true);
                }
                return helper::catchReturn(true,"Güncelleme İşleme Başarılı !");
            }else{
                if(isset($_FILES)) $fileLoad->fileDeleteStart();//Veritabanı işlemi başarısız olursa eklenmiş dosyaları sildik
                throw new Exception("İşlem başarısız oldu lütfen tekrar deneyin !", 1);
            }


        } catch (Exception $e) {
            return helper::catchReturn(0,$e->getMessage());
        }
    }


    public function delete($table,$where,$value,$file=null){
        try {

            $sql = $this->_db->prepare("DELETE FROM $table where $where=?");
            $status = $sql->execute([$value]);

            if(!empty($file) && is_array($file)){
                $fileLoad = new fileLoad();
                $fileLoad->fileDelete($file,$table);
            }

            if($status){
                return helper::catchReturn(true,"Silme işlemi başarıyla tamamlandı !");
            }else{
                throw new Exception("Silme işleminde bir problem oluştu !");
            }
        } catch (Exception $e) {
            return helper::catchReturn(false,$e->getMessage());
        }
    }
    
    

}