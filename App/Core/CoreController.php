<?php 

	/**
	 * 
	 */
	class Controller
	{
		public function view($path,$data=null){
			return View::page($path,$data);
		}

		public function layoutView($latoutPath,$viewPath,$data=null){
			View::viewLeyaut($latoutPath,$viewPath,$data);
		}

	}

 ?>