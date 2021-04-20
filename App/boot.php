<?php
	session_start();
	require_once("config.php");//Web sayfa ayarları
    require_once("Helpers/helpersBoot.php");
    require_once("Core/Core.php");//Mvc çekirdek yapısı, route de girilen bilgilere göre sayfa içeriklerini dahil etme
    require_once("Core/CoreRoute.php"); //route ve route tanımlama işlemleri
    require_once("Core/CoreCreateModuls.php");
    require_once("Core/CoreView.php"); // Tasarımları controller içinde gösterme işlmei
    require_once("Core/CorePieceView.php"); // Parça yapıarı çalıştırma
    require_once("Core/CoreController.php"); // CoreView kullanım 
    require_once("Core/CoreModel.php");
    require_once("Library/libraryBoot.php");
    require_once("route.php");  //Yol haritası

   
spl_autoload_register(function ($class_name) {
    // new yaptığımız Class tespit edilir ve class adı parametre olarak gelir.
    
    $modul = explode("Model", $class_name);
    $inc = DIRECTORY . "/Moduls/".Core::$MODULS."/model/$class_name.php";

    if (file_exists($inc)) {
        require_once($inc);
    }
    //üzerinde çalıştığımız modelin sınıfını getirdi
});