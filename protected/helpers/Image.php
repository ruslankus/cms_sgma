<?php
class Image {
    
    
    public static function tag($arr ,$params = array()){
        
        $option_string = "";
        foreach($params as $key => $value){
            $option_string .= "{$key}='{$value}' ";         
        }
        
        $src = '/uploads/images/'.$arr['filename'];         
        $alt = $arr['caption'];
        
        return "<img  src='{$src}' {$option_string} alt='{$alt}' />";
    }//tag
    
    
}//Image

?>