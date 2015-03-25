<?php
Class ExtAdminLanguages extends AdminLanguages
{

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
    	return parent::model($className);
    }
    public function getLabels($lng,$cond=array()){
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
    
    
    public function selectArray(){
        $sql = "SELECT t1.prefix,t1.name FROM languages t1";
        
        $con = $this->dbConnection;
        $arrData = $con->createCommand($sql)->queryAll();
        //$retData[''] = Trl::t()->getLabel('Select language');
       
        foreach($arrData as $item){
            $retData[$item['prefix']] = $item['name'];       
        }
        
        return $retData;       
    }//selectArray
    
    public function getAllLang(){
       $sql = "SELECT * FROM languages";
       
       $con = $this->dbConnection;
       $retData = $con->createCommand($sql)->queryAll();
       
       return $retData;
    } 
    
    
}    