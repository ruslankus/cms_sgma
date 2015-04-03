<?php
/**
 * Class ExtImages
 * @property ImagesTrl $trl
 */
class ExtImages extends Images
{
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }




    /**
     * TODO: Your extended methods here
     */


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
    
    
    public function savePageFile($fileName, $page_id ,$arrCapts){
        
        $con = $this->dbConnection;
        $transaction = $con->beginTransaction();
        try{
            $sql  = "INSERT INTO {$this->tableName()}(`filename`) ";
            $sql .= "VALUES(:filename)";
            
            $param1[':filename'] = $fileName;
            $con->createCommand($sql)->execute($param1);
            $imageId = $con->getLastInsertID('images');
            //addung relation
            $sql  = "INSERT INTO images_of_page(`page_id`, `image_id`) ";
            $sql .= "VALUES(:page_id, :image_id)";
            $param2[':page_id'] = $page_id;
            $param2[':image_id'] = $imageId;
            $con->createCommand($sql)->execute($param2);
            //adding tranlation
            $sql  = "INSERT INTO images_trl(`image_id`, `lng_id`, `caption`) ";
            $sql .= "VALUES ";
            $i=0;
            foreach($arrCapts as $key => $value){
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

    public function saveContactFile($fileName, $page_id ,$arrCapts){
        
        $con = $this->dbConnection;
        $transaction = $con->beginTransaction();
        try{
            $sql  = "INSERT INTO {$this->tableName()}(`filename`) ";
            $sql .= "VALUES(:filename)";
            
            $param1[':filename'] = $fileName;
            $con->createCommand($sql)->execute($param1);
            $imageId = $con->getLastInsertID('images');
            //addung relation
            $sql  = "INSERT INTO images_of_contacts(`contacts_id`, `image_id`) ";
            $sql .= "VALUES(:page_id, :image_id)";
            $param2[':page_id'] = $page_id;
            $param2[':image_id'] = $imageId;
            $con->createCommand($sql)->execute($param2);
            //adding tranlation
            $sql  = "INSERT INTO images_trl(`image_id`, `lng_id`, `caption`) ";
            $sql .= "VALUES ";
            $i=0;
            foreach($arrCapts as $key => $value){
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
}