<?php

/**
 *  Kullanımı
 *
 *  Web paneli kullanırken sağ üst köşede çıkan bildirim kutusunu dinamik olarak oluşturmak için kullanırız
 *
 *  Örnek olarak bir işlem yapıyoruz be bu işlemin sonucu olarak ekranda bilgilendirme mesajı vermemiz gerekiyor.
 *
 *  1.Kullanımı:
 *  Alerts::Control işlemi kullanırız, alt kısımda örneğimizde yaptığımız gibi $model->loginPModel($form) işlemini return ediyoruz
 *  $model->loginPModel($form) işlemi return olarak dizi halinde ["status"=>1,"message"=>"İşlem sonucu bilgilendirme mesajı"] burada status
 *  bildirim türünü belirtiyor başarılı(mavi onay tikli) veya başarısz(Kırmızı çarpı tikli) şeklinde ve dizi içerisinde message bildirmde içerisinde
 *  mesaj olarak gelecek alanı belirtir.
 *
 *  Alerts::Control(function(){
 *     $form = helper::formControl($_POST);
 *     $model = new adminModel();
 *     return $model->loginPModel($form);
 *   });
 *
 *
 *  Anlamak için bu şekilde kullanmanız yeterli olacaktır.
 *  Alerts::Control(function(){
 *     return ["status"=>0,"message"=>"başarılı işlem sonucu mesaj"];
 *  });
 *
 *   2.Kullanım
 *   Eğer return içerisnde sadece ["status"=>0] durumu belirtiliyor ise veya Dönen message içerinde daha farklı bir mesaj vermek istiyor isek
 *   parametre olarak gönderebiliriz, ayrıca parametre halinde göndermemiz mümkün
 *
 *   Alerts::Control(function(){
 *    return ["status"=>1];
 *   },"Başarılı işlem mesaj,Başarısız işlem mesaj"); İçerisinde virgün ile ayırdığımız alan eğer işlem başarılı ise virgülden önce eğer başarısız ise sonrası
 *   kullanılmaktadır.
 *
 *
 *   Ayrıca bildirimde yönlendirme için mesaj içinde link vermemiz de mümkün 2. ve 3. parametrelerde "link aderesi , link btn adı " girilebiir
 *   Alerts::Control(function(){
 *    return ["status"=>1];
 *   },"Başarılı işlem mesaj,Başarısız işlem mesaj","Başarılı işlem link,Link btn adı","Başarıl işlem link,Lin bt adı");
 *
 *
 */
class Alert
{

    public static function getDefaultScript()
    {

        if (isset($_SESSION["AlertMessage"])) {

            if ($_SESSION["AlertStatus"] == true) { //İşlem başarılı ise alert ona göre ayarla
                $status = "success";
                $title = "Başarılı !";
            } else {
                $status = "error";
                $title = "Hata !";
            }

            //Eğer link girililmiş ise.
            if (isset($_SESSION["AlertLink"]) && !empty($_SESSION["AlertLink"])) {
                $link = "<a class=\"badge badge-pill badge-light-warning mr-1\" href=\" " . $_SESSION["AlertLink"] . " \"> " . $_SESSION["AlertLinkTitle"] . "</a>";
            } else {
                $link = null;
            }

            echo "
            toastr['" . $status . "']('" . $_SESSION["AlertMessage"] . " <br><br> " . $link . " ', '" . $title . "', {
              closeButton: true,
              tapToDismiss: false,
              rtl: isRtl
              });
              ";

        }
        unset($_SESSION["AlertMessage"]);
    }

    public static function url($function,$url, $get = null)
    {
        //try catch alanından gelen thow mesajını get alanına girmemizi sağlar ?deneme=veri
        $return = $function();

        if (isset($return["status"]) && isset($return["message"])) {
            $get = "?status={$return["status"]}&{$return["message"]}";
        }

        if(is_array($url)){
            //Eğer iki değer var ise
            if(isset($return["status"]) && $return["status"]==ture){
                helper::header($url[0],$get);
            }else{
                helper::header($url[1],$get);
            }
        }else{
            helper::header($url, $get);
        }
    }


}//Class

/*
    // Info Type
  typeInfo.on('click', function () {
    toastr['info']('ğŸ‘‹ Chupa chups biscuit brownie gummi sugar plum caramels.', 'Info!', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  });

  // Warning Type
  typeWarning.on('click', function () {
    toastr['warning']('ğŸ‘‹ Icing cake pudding carrot cake jujubes tiramisu chocolate cake.', 'Warning!', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  });

  // Error Type
  typeError.on('click', function () {
    toastr['error']('ğŸ‘‹ Jelly-o marshmallow marshmallow cotton candy dessert candy.', 'Error!', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  });

  // Progress Bar
  progressBar.on('click', function () {
    toastr['success']('ğŸ‘‹ Chocolate oat cake jelly oat cake candy jelly beans pastry.', 'Progress Bar', {
      closeButton: true,
      tapToDismiss: false,
      progressBar: true,
      rtl: isRtl
    });
  });

  // Close Toast On Button Click
  clearToastBtn.on('click', function () {
    if (!clearToastObj) {
      clearToastObj = toastr['info'](
        'Ready for the vacation?<br /><br /><button type="button" class="btn btn-info btn-sm clear">Yes</button>',
        'Family Trip',
        {
          closeButton: true,
          timeOut: 0,
          extendedTimeOut: 0,
          tapToDismiss: false,
          rtl: isRtl
        }
      );
    }

    if (clearToastObj.find('.clear').length) {
      clearToastObj.delegate('.clear', 'click', function () {
        toastr.clear(clearToastObj, { force: true });
        clearToastObj = undefined;
      });
    }
  });

  // Position Top Left
  positionTopLeft.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Top Left!', {
      positionClass: 'toast-top-left',
      rtl: isRtl
    });
  });

  // Position Top Center
  positionTopCenter.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Top Center!', {
      positionClass: 'toast-top-center',
      rtl: isRtl
    });
  });

  // Position Top Right
  positionTopRight.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Top Right!', {
      positionClass: 'toast-top-right',
      rtl: isRtl
    });
  });

  // Position Top Full Width
  positionTopFull.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Top Full Width!', {
      positionClass: 'toast-top-full-width',
      rtl: isRtl
    });
  });

  // Position Bottom Left
  positionBottomLeft.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Bottom Left!', {
      positionClass: 'toast-bottom-left',
      rtl: isRtl
    });
  });

  // Position Bottom Center
  positionBottomCenter.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Bottom Center!', {
      positionClass: 'toast-bottom-center',
      rtl: isRtl
    });
  });

  // Position Bottom Right
  positionBottomRight.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Bottom Right!', {
      positionClass: 'toast-bottom-right',
      rtl: isRtl
    });
  });

  // Position Bottom Full Width
  positionBottomFull.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Bottom Full Width!', {
      positionClass: 'toast-bottom-full-width',
      rtl: isRtl
    });
  });

  // Fast Duration
  fastDuration.on('click', function () {
    toastr['success']('Have fun storming the castle!', 'Fast Duration', { showDuration: 500, rtl: isRtl });
  });

  // Slow Duration
  slowDuration.on('click', function () {
    toastr['warning']('Have fun storming the castle!', 'Slow Duration', { hideDuration: 3000, rtl: isRtl });
  });

  // Timeout
  toastrTimeout.on('click', function () {
    toastr['error']('I do not think that word means what you think it means.', 'Timeout!', {
      timeOut: 5000,
      rtl: isRtl
    });
  });

  // Sticky
  toastrSticky.on('click', function () {
    toastr['info']('I do not think that word means what you think it means.', 'Sticky!', { timeOut: 0, rtl: isRtl });
  });

  // Slide Down / Slide Up
  slideToast.on('click', function () {
    toastr['success']('I do not think that word means what you think it means.', 'Slide Down / Slide Up!', {
      showMethod: 'slideDown',
      hideMethod: 'slideUp',
      timeOut: 2000,
      rtl: isRtl
    });
  });

  // Fade In / Fade Out
  fadeToast.on('click', function () {
    toastr['success']('I do not think that word means what you think it means.', 'Slide Down / Slide Up!', {
      showMethod: 'fadeIn',
      hideMethod: 'fadeOut',
      timeOut: 2000,
      rtl: isRtl
    });
  });
  */