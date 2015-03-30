<?php

Class ExtMessages extends Messages
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
     * Returns array of labels
     * @param $currLng
     * @return array
     */
    public function getMessages($lng,$cond=array()){
        $sql = "SELECT t1.id,t2.label,t1.value, t2.id AS translation_id
            FROM messages_trl t1
            JOIN messages t2 ON t1.translation_id = t2.id
            JOIN languages t3 ON t1.lng_id = t3.id
          WHERE t3.prefix = :prefix";
        
        $param = array();
        
        if(!empty($cond['search_label'])){
             $sql .= " AND t2.label LIKE :label";
             $param[':label'] = "%{$cond['search_label']}%";

        }
        
        //add order
        $sql .= " ORDER BY t1.id DESC"; 
        
        
        $param[':prefix'] = $lng;
        $con = $this->dbConnection;        
        $retData = $con->createCommand($sql)->queryAll(true,$param);
        
        return $retData;        
    }//getLabels
    /**
     * Adds label
     * @param $label
     * @param $arrLng
     * @return bool
     */
    public function addMessage($label,$arrLng){

        $sql = "INSERT INTO messages (`label`) VALUES (:label)";

        $sql_param[':label'] = $label;

        $con = $this->dbConnection;
        $con->createCommand($sql)->execute($sql_param);
        $labelId = $con->getLastInsertID('messages');

        /*
        $sql = "INSERT INTO messages_trl (`translation_id`, `lng_id`, `value`) VALUES ";
        foreach($arrLng as $key => $lng){
            if($key == 0){
                $sql .= "($labelId, {$lng['id']}, '')";
            }else{
                $sql .= ",($labelId, {$lng['id']}, '')";
            }
        }

        $con->createCommand($sql)->execute();
        $labelTrl[] = $con->getLastInsertID('messages_trl');
        */
        
        foreach($arrLng as $lng){
           
            $sql = "INSERT INTO messages_trl (`translation_id`, `lng_id`, `value`) VALUES ";
            $sql .= "($labelId, {$lng['id']}, ' ')";
            
            $con->createCommand($sql)->execute();
            $labelTrl[] = $con->getLastInsertID('messages_trl');
        }
        

        return true;
    }

    /**
     * Deletes message
     * @param $id
     * @return bool
     */
    public function deleteMessage($id){
        //$sql = "PRAGMA foreign_keys = ON";

        $con = $this->dbConnection;
        //$con->createCommand($sql)->execute();

        $sql = "DELETE FROM messages
                WHERE id = ".(int)$id;

        $con->createCommand($sql)->execute();

        return true;
    }
}