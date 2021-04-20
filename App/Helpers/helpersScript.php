<?php
/**
 * 
 */
class Script
{
	
	private static $_script = null;

	public static function set($js){
		self::$_script = $js;
	}

	public static function get(){
		if(!empty(self::$_script)){
		    echo "<script type='text/javascript'>";
            echo self::$_script;
            echo "</script>";
		}
	}

}