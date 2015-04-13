<?php
/**
 * Class ExtPage
 * @property ExtMenuItem $menuItem
 */
class ExtContactsBlockTrl extends ContactsBlockTrl
{
    
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    
    public function setNewContactBlock($label,$arrTitle = null, $page_id = null){
        
        $con = $this->dbConnection;
        $transaction = $con->beginTransaction();
        try{
            
            $sql  = "INSERT INTO contacts_block(`label`,`page_id`,`priority`) ";
            $sql .= "VALUES(:label,:page_id,:priority)";
            
            $param[':label'] = $label;
            $param[':page_id'] = $page_id;
            $param[':priority'] = Sort::GetNextPriority("ContactsBlock");

            $con->createCommand($sql)->execute($param);
            $contactId = $con->getLastInsertID('contacts');
            //adding tranlation
            
            $sql  = "INSERT INTO ".$this->tableName()."(`block_id`, `lng_id`, `title`) ";
            $sql .= "VALUES ";
            $i=0;
            foreach($arrTitle as $key => $value){
                if($i == 0){
                    $sql .= "({$contactId}, {$key}, '{$value}') ";
                }else{
                     $sql .= ",({$contactId}, {$key}, '{$value}') ";
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
