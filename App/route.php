<?php

	//Url den parametre alma ([0-9a-zA-Z-_]+) = Sayı ve harf , ([0-9_]+) = sayi
	//Route::getCreate("hakkimizda","default/default@index");
	//Route::crudCreate("menu","menu/menu@index");

    //Tasarım işleri
	Route::getCreate("anasayfa","Home/Home@index");
	Route::getCreate("hata","Home/Home@notFound");
	Route::getCreate("ilan/([0-9a-zA-Z-_]+)/([0-9_]+)","Home/Home@adverties");

	Route::getCreate("isbul/([0-9_]+)","Home/Home@AdvertiesSearchList");

    //Öğrenci işleri
    Route::getCreate("ogrenciKayit","User/student@register");
    Route::getCreate("ogrenciProfil/([0-9a-zA-Z-_]+)/([0-9_]+)","User/student@profile");
    Route::postCreate("ogrenciKayit","user/student@registerAddP");
    Route::postCreate("studentProfileUpdate","User/student@profileUpdate","USER");
    Route::postCreate("studentReferanceAddP","User/student@referenceAddP","USER");

    //İşveren işleri
	Route::getCreate("profil/([0-9a-zA-Z-_]+)/([0-9_]+)","user/employer@profile");
	Route::getCreate("isverenKayit","User/employer@register");
	Route::postCreate("isverenKayit","User/employer@registerAddP");
	Route::postCreate("employerProfileUpdateP","User/employer@employerProfileUpdateP","USER");

	Route::getCreate("ilanver","User/employer@adverties","USER");
	Route::postCreate("ilanverEkle","User/employer@advertiesAddP","USER");
	Route::getCreate("ilanverGuncelle/([0-9_]+)","User/employer@advertiesUpdate","USER");
	Route::postCreate("ilanverGuncelleP","User/employer@advertiesUpdateP","USER");
	Route::getCreate("ilanverSil/([0-9_]+)","User/employer@advertiesRemove","USER");

	//Kullanıcı işlemleri(Öğrenci/İşveren)
    Route::getCreate("giris","User/user@login");
    Route::postCreate("giris","User/user@userLoginP");
    Route::getCreate("guvenliCikis","User/user@logout");









		

