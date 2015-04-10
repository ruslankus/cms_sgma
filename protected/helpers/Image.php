<?php
class Image {

    const UPLOAD_DIR = "uploads/images";
    const CACHED_DIR = "uploads/images/cached";
    const SYS_IMG_DIR = "images";

    public static function tag($arr ,$params = array()){
        
        $option_string = "";
        foreach($params as $key => $value){
            $option_string .= "{$key}='{$value}' ";         
        }
        
        $src = '/uploads/images/'.$arr['filename'];         
        $alt = $arr['caption'];
        
        return "<img  src='{$src}' {$option_string} alt='{$alt}' />";
    }//tag

    /**
     * Returns URL to file specified
     * @param $filename
     * @param bool $system
     * @return string
     */
    public static function getUrlOf($filename,$system = false)
    {
        $dir = $system ? self::SYS_IMG_DIR : self::UPLOAD_DIR;
        return Yii::app()->request->baseUrl.'/'.$dir.'/'.$filename;
    }

    /**
     * Returns local path to file specified
     * @param $filename
     * @param bool $system
     * @return string
     */
    public static function getPathOf($filename,$system = false)
    {
        $dir = $system ? self::SYS_IMG_DIR : self::UPLOAD_DIR;
        return Yii::app()->basePath.DS.$dir.DS.$filename;
    }

}//Image

?>