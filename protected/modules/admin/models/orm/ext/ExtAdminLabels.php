<?php
Class ExtAdminLabels extends AdminLabels
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
    public function getLabels($currLng) {

        $arrLabels = array();
        $sql  = "SELECT t1.label , t2.value FROM labels t1 ";
        $sql .= "JOIN labels_trl t2 ON t2.translation_id = t1.id ";
        $sql .= "JOIN languages t3 ON t2.lng_id = t3.id ";
        $sql .= "WHERE t3.prefix = :prefix";
        $params[':prefix'] = $currLng;
        $con = $this->dbConnection;
        $data=$con->createCommand($sql)->queryAll(true,$params);

        foreach($data as $row){
            $arrLabels[$row['label']] = $row['value'];
        }
        return $arrLabels;
    }

    public function getLabelsList($lng,$cond=array()){
        $sql = "SELECT t1.id,t2.label,t1.value, t2.id AS translation_id
            FROM labels_trl t1
            JOIN labels t2 ON t1.translation_id = t2.id
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
    public function addLabel($label,$arrLng){

        $sql = "INSERT INTO labels ('label') VALUES (:label)";

        $sql_param[':label'] = $label;

        $con = $this->dbConnection;
        $con->createCommand($sql)->execute($sql_param);
        $labelId = $con->getLastInsertID('labels');

        $sql = "INSERT INTO labels_trl ('translation_id', 'lng_id', 'value') VALUES ";
        /*
        foreach($arrLng as $key => $lng){
            if($key == 0){
                $sql .= "($labelId, {$lng['id']}, '')";
            }else{
                $sql .= ",($labelId, {$lng['id']}, '')";
            }
        }

        $con->createCommand($sql)->execute();
        $labelTrl[] = $con->getLastInsertID('labels_trl');
        */
        
        foreach($arrLng as $lng){
           
            $sql = "INSERT INTO labels_trl ('translation_id', 'lng_id', 'value') VALUES ";
            $sql .= "($labelId, {$lng['id']}, '')";
            
            $con->createCommand($sql)->execute();
            $labelTrl[] = $con->getLastInsertID('labels_trl');
        }
        
        return true;
    }

    /**
     * Deletes label
     * @param $id
     * @return bool
     */
    public function deleteLabel($id){
        $sql = "PRAGMA foreign_keys = ON";

        $con = $this->dbConnection;
        $con->createCommand($sql)->execute();

        $sql = "DELETE FROM labels
                WHERE id = ".(int)$id;

        $con->createCommand($sql)->execute();

        return true;
    }
}