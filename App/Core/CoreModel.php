<?php 
/**
 * 
 */
class Model
{
	public $db;
	public $crud;
	
	function __construct()
	{
		try {
			
	        $this->db = new PDO("mysql:host=". DBHOST .";dbname=". DBNAME .";charset=utf8",DBUSER, DBPWD);
	        $this->crud = new Crud($this->db);

	    } catch (Exception $e) {
	        die("Servere bağlantı başarısız...:" . $e->getMessage());

	    }

	}
}