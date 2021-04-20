<?php 

    define("BASE", "http://localhost/OKUL_PROJE/");

	define("DIRECTORY","App");
    define("ADMINLOGIN", "webadmin");
	
	define("DBHOST", "localhost");
    define("DBUSER", "root");
    define("DBPWD", "");
    define("DBNAME", "omukariyer");


	global $config;
	$config = [
		"REQUEST_URI"=>null,
		"DEFAULT_ROUTE"=>"Home/Home@Index"
	];
	
 ?>