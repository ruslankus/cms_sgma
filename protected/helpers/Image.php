<?php
class Image {

    const UPLOAD_DIR = "uploads/images";
    const CACHED_DIR = "uploads/images/cached";
    const SYS_IMG_DIR = "images";

    const W = "_W_";
    const H = "_H_";
    const F= "_FIT";

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




    /****************************************** C A C H I N G  I M A G E S ********************************************/



    /**
     * Creates special filename for saving cached files (to easily get cached images by it's sizes)
     * @param $name
     * @param int $w
     * @param int $h
     * @param bool $fit
     * @return string
     */
    private static function createSpecialName($name, $w = 0, $h = 0, $fit = false)
    {
        $result = "";

        $dot = "."; //dot - extension name goes after this
        $nameParts = explode($dot,$name); //parts of name separated by dot
        $nameWithoutExt = $name; //name without extension (without last element of array)

        //get extension if possible
        $ext = count($nameParts) > 1 ? $nameParts[count($nameParts)-1] : '';

        //if extension not empty
        if(!empty($ext))
        {
            //remove extension part from array
            unset($nameParts[count($nameParts)-1]);
            //get the name without extension (without last element of array)
            $nameWithoutExt = implode(".",$nameParts);
        }
        //if extension empty
        else
        {
            //let dot be empty
            $dot = "";
        }

        //if specified only width
        if($w > 0 && $h == 0)
        {
            $result = $nameWithoutExt.self::W.$w.$dot.$ext;
        }

        //if specified only height
        if($w == 0 && $h > 0)
        {
            $result = $nameWithoutExt.self::H.$h.$dot.$ext;
        }

        //if specified both dimensions
        if($w > 0 && $h > 0)
        {
            if(!$fit)
            {
                $result = $nameWithoutExt.self::W.$w.self::H.$h.$dot.$ext;
            }
            else
            {
                $result = $nameWithoutExt.self::W.$w.self::H.$h.self::F.$dot.$ext;
            }
        }

        return $result;
    }

    /**
     * Checks if that image has been cached
     * @param $name
     * @param int $w
     * @param int $h
     * @param bool $fit
     * @return bool
     */
    public static function isCached($name, $w = 0, $h = 0, $fit = false)
    {
        $cachePath = self::CACHED_DIR.DS.self::createSpecialName($name,$w,$h,$fit);
        return file_exists($cachePath);
    }

    /**
     * Returns path to cached image
     * @param $name
     * @param int $w
     * @param int $h
     * @param bool $fit
     * @return string
     */
    public static function getCachedPath($name, $w = 0, $h = 0, $fit = false)
    {
        if(!self::isCached($name,$w,$h,$fit))
        {
            self::cache($name,$w,$h,$fit);
        }

        return self::CACHED_DIR.DS.self::createSpecialName($name,$w,$h,$fit);
    }

    /**
     * Get cached url
     * @param $name
     * @param int $w
     * @param int $h
     * @param bool $fit
     * @return string
     */
    public static function getCachedUrl($name, $w = 0, $h = 0, $fit = false)
    {
        if(!self::isCached($name,$w,$h,$fit))
        {
            self::cache($name,$w,$h,$fit);
        }

        return Yii::app()->request->baseUrl.'/'.self::CACHED_DIR.'/'.self::createSpecialName($name,$w,$h,$fit);
    }

    /**
     * Performs caching of uploaded image with specified size params (saves scaled image into cache directory)
     * @param $name
     * @param int $w
     * @param int $h
     * @param bool $fit
     */
    public static function cache($name, $w = 0, $h = 0, $fit = false)
    {
        $cachePath = self::CACHED_DIR.DS.self::createSpecialName($name,$w,$h,$fit);

        //if specified only width
        if($w > 0 && $h == 0)
        {
            //fit uploaded image by width and save to cached dir with special name
            $img = new SimpleImage(self::UPLOAD_DIR.DS.$name);
            $img -> fit_to_width($w);
            $img -> save($cachePath);
        }

        //if specified only height
        if($w == 0 && $h > 0)
        {
            //fit uploaded image by height and save to cached dir with special name
            $img = new SimpleImage(self::UPLOAD_DIR.DS.$name);
            $img -> fit_to_height($h);
            $img -> save($cachePath);
        }

        //if specified both dimensions
        if($w > 0 && $h > 0)
        {
            //if shouldn't fit
            if(!$fit)
            {
                //just resize our image and save to cached dir with special name
                $img = new SimpleImage(self::UPLOAD_DIR.DS.$name);
                $img -> resize($w,$h);
                $img -> save($cachePath);
            }
            //if should
            else
            {
                //fit image by both dimensions and save to cached dir with special name
                $img = new SimpleImage(self::UPLOAD_DIR.DS.$name);
                $img -> best_fit($w,$h);
                $img -> save($cachePath);
            }
        }
    }

}//Image

?>