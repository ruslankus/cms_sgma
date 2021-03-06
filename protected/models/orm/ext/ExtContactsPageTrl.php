<?php
/**
 * Class ExtPage
 * @property ExtMenuItem $menuItem
 */
class ExtContactsPageTrl extends ContactsPageTrl
{
    
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    
    public function setNewContactPage($label,$arrTitle = null){
        
        $con = $this->dbConnection;
        $transaction = $con->beginTransaction();
        try{
            
            $sql  = "INSERT INTO contacts_page(`label`,`priority`) ";
            $sql .= "VALUES(:label,:priority)";
            $param[':priority']= Sort::GetNextPriority("ContactsPage");
            $param[':label'] = $label;
            $con->createCommand($sql)->execute($param);
            $contactId = $con->getLastInsertID('contacts');
            //adding tranlation
            
            $sql  = "INSERT INTO ".$this->tableName()."(`page_id`, `lng_id`, `title`) ";
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
