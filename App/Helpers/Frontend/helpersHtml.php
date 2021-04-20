<?php

class helpersHtml{
    public static function show($status,$html=null){

        if(is_array($html) && !empty($html))
        {
            if($status){
                echo isset($html["true"]) ? $html["true"] : '<span style="color: red">$html["true"] = degeri boş !</span>';
            }elseif(!$status){
                echo isset($html["false"]) ? $html["false"] : '<span style="color: red">$html["false"] = degeri boş</span>';
            }else{
                echo isset($html["error"]) ? $html["error"] : '<span style="color: red">$html["error"] = degeri boş</span>';
            }

        }else{
            if($html==null){
                if($status){
                    echo 'style=display:none';
                }else{
                    echo 'style=display:none';
                }
            }else{
                if($status){
                    echo $html;
                }else{
                    echo "";
                }
            }

        }

    }
}