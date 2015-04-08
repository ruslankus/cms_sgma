<?php

class ExtRating extends Rating 
{
    
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    
    public function getProductMarks($id = null){
        
        $sql  = "SELECT t1.qnt, t2.mark_value FROM rating t1 ";
        $sql .= "JOIN marks t2 ON t1.mark_id = t2.id ";
        $sql .= "WHERE t1.product_id = ".(int)$id;
        
        $con = $this->dbConnection;
        $data=$con->createCommand($sql)->queryAll();
        
        $retArray = array();
        foreach($data as $row){
            $retArray[$row['mark_value']] = $row['qnt'];
        }
                
        return (!empty($retArray))? $retArray : false;
    }
    
}    