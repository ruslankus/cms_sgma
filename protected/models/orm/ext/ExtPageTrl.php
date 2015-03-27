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
            $labelId = $con->getLastInsertID('page');
            //adding tranlation
            
            $sql  = "INSERT INTO ".$this->tableName()."(`article_id`, `lng_id`, `header`) ";
            $sql .= "VALUES ";
            $i=0;
            foreach($arrTitle as $key => $value){
                if($i == 0){
                    $sql .= "({$labelId}, {$key}, '{$value}') ";
                }else{
                     $sql .= ",({$labelId}, {$key}, '{$value}') ";
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
            echo($msg."   ".$code);
            Debug::d();
            return false;
        }
        
        
        
       

    }// setNewPage
    
}// end class
