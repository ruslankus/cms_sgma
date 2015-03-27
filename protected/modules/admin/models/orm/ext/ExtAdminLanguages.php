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
    
    public function writeTrl($lang_id,$arrLabels)
    {
        foreach($arrLabels as $label):
            $label_id = $label['id'];
        endforeach;
        //return $id;
    }
}    