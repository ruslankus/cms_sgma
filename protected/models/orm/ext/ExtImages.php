<?php
/**
 * Class ExtImages
 * @property ImagesTrl $trl
 */
class ExtImages extends Images
{
    const UPLOAD_DIR = "uploads/images";
    const CACHED_DIR = "uploads/images/cached";
    const SYS_IMG_DIR = "images";

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    /**
     * Returns URL to file specified
     * @param $filename
     * @param bool $system
     * @return string
     */
    public function getUrlOf($filename,$system = false)
    {
        $dir = $system ? self::SYS_IMG_DIR : self::UPLOAD_DIR;
        return Yii::app()->request->baseUrl.'/'.$dir.'/'.$filename;
    }

    /**
     * Returns URL to file of this image
     * @param bool $system
     * @return string
     */
    public function getUrl($system = false)
    {
        return $this->getUrlOf($this->filename,$system);
    }

    /**
     * Checks if file for this image exist in site's storage dir
     * @param $system
     * @return bool
     */
    public function isFileExist($system = false)
    {
        return file_exists($this->getPath($system));
    }

    /**
     * Returns local path
     * @param bool $system
     * @return string
     */
    public function getPath($system = false)
    {
        $dir = $system ? self::SYS_IMG_DIR : self::UPLOAD_DIR;
        return Yii::app()->basePath.DS.$dir.DS.$this->filename;
    }

    /**
     * Save image for pages
     * @param $fileName
     * @param $page_id
     * @param $arrCaptions
     * @return bool
     */
    public function savePageFile($fileName, $page_id ,$arrCaptions){

        $con = $this->dbConnection;
        $transaction = $con->beginTransaction();
        try{
            $sql  = "INSERT INTO {$this->tableName()}(`filename`) ";
            $sql .= "VALUES(:filename)";

            $param1[':filename'] = $fileName;
            $con->createCommand($sql)->execute($param1);
            $imageId = $con->getLastInsertID('images');
            //adding relation
            $sql  = "INSERT INTO images_of_page(`page_id`, `image_id`) ";
            $sql .= "VALUES(:page_id, :image_id)";
            $param2[':page_id'] = $page_id;
            $param2[':image_id'] = $imageId;
            $con->createCommand($sql)->execute($param2);
            //adding translation
            $sql  = "INSERT INTO images_trl(`image_id`, `lng_id`, `caption`) ";
            $sql .= "VALUES ";
            $i=0;
            foreach($arrCaptions as $key => $value){
                if($i == 0){
                    $sql .= "({$imageId}, {$key}, '{$value}') ";
                }else{
                    $sql .= ",({$imageId}, {$key}, '{$value}') ";
                }
                $i++;
            }//foreach

            $con->createCommand($sql)->execute();
            $transaction->commit();
            return true;

        } catch (Exception $e) {
            $transaction->rollback();
            $msg = $e->getMessage();
            $code = $e->getCode();
            echo($msg."   ".$code);
            Debug::d();
            return false;
        }

    }//savePageFile

    /**
     * Save image for contact pages
     * @param $fileName
     * @param $page_id
     * @param $arrCaptions
     * @return bool
     */
    public function saveContactFile($fileName, $page_id ,$arrCaptions){

        $con = $this->dbConnection;
        $transaction = $con->beginTransaction();
        try{
            // limit for one image
            $sql_delete = "DELETE FROM images_of_contacts";
            $con->createCommand($sql_delete)->execute();;
            // end limit for one image
            $sql  = "INSERT INTO {$this->tableName()}(`filename`) ";
            $sql .= "VALUES(:filename)";

            $param1[':filename'] = $fileName;
            $con->createCommand($sql)->execute($param1);
            $imageId = $con->getLastInsertID('images');
            //adding relation
            $sql  = "INSERT INTO images_of_contacts(`contacts_id`, `image_id`) ";
            $sql .= "VALUES(:page_id, :image_id)";
            $param2[':page_id'] = $page_id;
            $param2[':image_id'] = $imageId;
            $con->createCommand($sql)->execute($param2);
            //adding translation
            $sql  = "INSERT INTO images_trl(`image_id`, `lng_id`, `caption`) ";
            $sql .= "VALUES ";
            $i=0;
            foreach($arrCaptions as $key => $value){
                if($i == 0){
                    $sql .= "({$imageId}, {$key}, '{$value}') ";
                }else{
                    $sql .= ",({$imageId}, {$key}, '{$value}') ";
                }
                $i++;
            }//foreach

            $con->createCommand($sql)->execute();
            $transaction->commit();
            return true;

        } catch (Exception $e) {
            $transaction->rollback();
            $msg = $e->getMessage();
            $code = $e->getCode();
            echo($msg."   ".$code);
            Debug::d();
            return false;
        }

    }// save contact file




    /**
     * Override, relate with extended models
     * @return array relational rules.
     */
    public function relations()
    {
        //get all relations from base class
        $relations = parent::relations();

        //pass through all
        foreach($relations as $name => $relation)
        {
            //if found extended file for this related class
            if(file_exists(dirname(__FILE__).DS.'Ext'.$relation[1].'.php'))
            {
                $relations[$name][1] = 'Ext'.$relation[1];
            }
        }

        //relate with translation
        $lng = Yii::app()->language;
        $relations['trl'] = array(self::HAS_ONE, 'ImagesTrl', 'image_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }

}