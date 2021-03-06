<?php
/**
 * Class ExtPage
 * @property ExtMenuItem $menuItem
 * @property PageTrl $trl
 */
class ExtPageTrl extends PageTrl
{
    
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    
    public function setNewPage($label,$arrTitle = null){
        
        $con = $this->dbConnection;
        $transaction = $con->beginTransaction();
        try{
            
            $sql  = "INSERT INTO page(`label`) ";
            $sql .= "VALUES(:label)";
            
            $param[':label'] = $label;
            $con->createCommand($sql)->execute($param);
            $pageId = $con->getLastInsertID('page');
            //adding tranlation
            
            $sql  = "INSERT INTO ".$this->tableName()."(`page_id`, `lng_id`, `title`) ";
            $sql .= "VALUES ";
            $i=0;
            foreach($arrTitle as $key => $value){
                if($i == 0){
                    $sql .= "({$pageId}, {$key}, '{$value}') ";
                }else{
                     $sql .= ",({$pageId}, {$key}, '{$value}') ";
                } 
                $i++;   
            }
            
            $con->createCommand($sql)->execute();
            $transaction->commit();
            return true; 
        }catch(Exception $e){
            $transaction->rollback();
            $msg = $e->getMessage();
            $code = $e->getCode();
           // echo($msg."   ".$code);
           // Debug::d();
            return false;
        }
        
        
        
       

    }// setNewPage
    
    
    public function getPageWithImages($id = null){
        $currLngObj = SiteLng::lng()->getCurrLng();
        $prefix = $currLngObj->prefix;
        $lngId = $currLngObj->id;
        
        $con = $this->dbConnection;
        
        $sql  = "SELECT * FROM ".$this->tableName();
        $sql .= " WHERE page_id = ". (int)$id;
        $sql .= " AND lng_id =". (int)$lngId;
        $sql .= " LIMIT 1";
        
        $arrPage = $con->createCommand($sql)->queryRow();
        
        if(!empty($arrPage)){
            
            $sql  = "SELECT  t2.*,t1.id AS link_id, ";
            $sql .= "(" ;
            $sql .= "SELECT i1.caption FROM images_trl i1 ";
            $sql .= "JOIN languages i2 ON i1.lng_id = i2.id ";
            $sql .= "WHERE i1.image_id = t2.id AND i2.prefix = :prefix ";
            $sql .= ") as caption ";
            $sql .= "FROM images_of_page t1 ";
            $sql .= "JOIN images t2 ON t1.image_id = t2.id"; 
            
            //Debug::d($sql);
            
            //$sql  = "SELECT t2.* FROM images_of_page t1 ";
            //$sql .= "JOIN images t2 ON t1.image_id = t2.id ";
          
           
           $param[":prefix"] = $prefix;
           
           $arrPage['images'] = $con->createCommand($sql)->queryAll(true,$param);
            
        }
        
        return (!empty($arrPage))? $arrPage : false;
        
    }
    
}// end class
