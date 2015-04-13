<?php
/**
 * Class ExtPage
 * @property ExtMenuItem $menuItem
 */
class ExtContactsFieldsTrl extends ContactsFieldsTrl
{
    
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    
    public function setNewContactField($label,$arrTitle = null, $block_id = null){
        
        $con = $this->dbConnection;
        $transaction = $con->beginTransaction();
        try{
            
            $sql  = "INSERT INTO contacts_fields(`label`,`block_id`) ";
            $sql .= "VALUES(:label,:block_id)";
            
            $param[':label'] = $label;
            $param[':block_id'] = $block_id;
           
            $con->createCommand($sql)->execute($param);
            $contactId = $con->getLastInsertID('contacts_fields');
            //adding tranlation
            
            $sql  = "INSERT INTO ".$this->tableName()."(`contacts_field_id`, `lng_id`, `name`) ";
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
