<?php 

	/**
	 * 
	 */
	class Viewpiece
	{
		
		public static function operationBtn($table,$where,$FalseView = []){

			$ThemeHTML = [];

			$ThemeHTML["Update"] = '
				<a class="dropdown-item" target="_blanks" href="'.ADMINLOGIN."/".$table.'Update/'.$where.'">
                    <i class="bi bi-pen"></i>
                    <span>Güncelle</span>
                </a>
			';
			$ThemeHTML["Delete"] = '
				<a class="dropdown-item" href="'.ADMINLOGIN."/".$table.'Delete/'.$where.'">
                    <i class="bi bi-trash"></i>
                    <span>Sil</span>
                </a>
			';
			$ThemeHTML["Status"] = '
				<a class="dropdown-item" href="'.ADMINLOGIN."/".$table.'Status/'.$where.'">
                    <i class="bi bi-eye"></i>
                    <span>Pasif</span>
                </a>
			';
			$ThemeHTML["Galery"] = '
				<a class="dropdown-item" href="'.ADMINLOGIN."/".$table.'Galeri/'.$where.'">
                    <i class="bi bi-images"></i>
                    <span>Galeri</span>
                </a>
			';

			echo '
			<div class="dropdown">
                <button type="button" class="btn btn-sm text-primary dropdown-toggle hide-arrow" data-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <div class="dropdown-menu">';

                foreach ($ThemeHTML as $key => $value) {
                	if(!is_integer(array_search($key, $FalseView))){
                		echo $value;
                	}
                }

			echo '
				</div>
            </div>';
		}
	}

 ?>


