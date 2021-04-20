<?php
class helper
{
	public static function array_pre($var)
    {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }

    public static function formControl($form){
        //Form içerisnde post/get edilen verileri başındaki boşlukları sildik ve içerisndeki karakterleri güvenlik için dönüştürdk
        foreach ($form as $index => $value) {
            $form[$index] = htmlspecialchars(trim($value));
        }

        return $form;
    }


    public static function header($uri,$get=null)
    {
        //Parametre var ise temizle öyle gönder.
        if (strstr($uri, "?")) {
            $new_uri = explode("?", $uri, -1);
            $Location = $new_uri[0];
        } else {
            $Location = $uri;
        }

        header("Location:{$Location}{$get}");
        exit();

    }

    public static function headerReturn($url,$return=null,$get=null)
    {
        if($return != null){
            if (isset($return["status"]) && isset($return["message"]) && $get==null) {
                $get = $return["message"];
            }
        }

        if(is_array($url)){
            //Eğer iki değer var ise
            if(isset($return["status"]) && $return["status"]==1){
                self::header($url[0],$get);
            }else{
                self::header($url[1],$get);
            }
        }else{
            helper::header($url, $get);
        }

    }


    public static function try($fun,$link=null){
        try {
            $fun();
        } catch (Exception $e) {
            return self::catchReturn(false,$e->getMessage());
        }
    }

    public static function tryR($fun,$link=null){
        try {
            return $fun();
        } catch (Exception $e) {
            return self::catchReturn(false,$e->getMessage());
        }
    }


    public static function tryParams($fun,$params=[]){
        try {
            return $fun(array_values($params));
        } catch (Exception $e) {
            return self::catchReturn(false,$e->getMessage());
        }
    }

    public static function catchReturn($status,$e=null){
        if($status == null) $status = 0;
        return ["status"=>$status,"message"=>$e];
    }

    public static function webSettings($webSettings = []){
        //Gönderilen diziyi web ayarları halinde session içinde tutmamızı sağlar
        foreach ($webSettings as $value) {
            $_SESSION["webSettings"][$value["web_settings_name"]] = $value["web_settings_value"];
        }
    }

    public static function emptyControl($form,$nex=null){
        //Gönderilen dizide boş değer varmı kontrol eder.
        
        try {

            foreach ($form as $key => $value) {

                if(empty($nex) && $nex==null){
                    if(empty($value)){
                        throw new Exception("Boş değer var !");
                    }   
                }else{
                    foreach ($nex as $name) {
                        if($key != $name ){
                            if(empty($value)){
                                throw new Exception("Boş değer var !");
                            } 
                        }
                    }
                }

            }
            
            return self::catchReturn(true);
        } catch (Exception $e) {
            return self::catchReturn(false,$e->getMessage());
        }
    }

    public static function trimControl($form){
        try {

            foreach ($form as $key => $value) {
                $form[$key] = trim($form[$key]);
            }

            return $form;
            
        } catch (Exception $e) {
            return self::catchReturn(false,$e->getMessage());
        }
    }


    public static function date($tarih, $karakter,$aylar=false)
    {
        $yeni_tarih = explode("-", $tarih);
        $yeni_tarih = array_reverse($yeni_tarih);
        $cikti = 0;
        $aylar_list = ["","Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"];
        foreach ($yeni_tarih as $index => $key) {

            if($aylar==true && $index  == 1){

                $cikti .= $aylar_list[$key]. $karakter;

            }else{
                $cikti .= $key . $karakter;
            }


        }
        echo substr($cikti, 1, -1);
    }

    public static function str_max($metin, $max)
    {
        $metin = strip_tags($metin);
        if (strlen($metin) >= $max) {
            return substr($metin, 0, $max) . "...";
        } else {
            return $metin;
        }
    }

    public static function seo($str, $options = array())
    {
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true
        );
        $options = array_merge($defaults, $options);
        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );
$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
if ($options['transliterate']) {
    $str = str_replace(array_keys($char_map), $char_map, $str);
}
$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
$str = trim($str, $options['delimiter']);
return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}
}