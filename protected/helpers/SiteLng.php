<?php
/**
 * Site Languages Helper
 */
class SiteLng
{
    
    private static $_instance = false;   
    private $_arrLng = array();
    private $_objLngs;
    private $_currLngObj;
    //[id] => [prefix]
    private $_arrAllLngsPrefix = array();
  
    
    public static function lng(){
        if(!self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    
     private function __construct() {

        $this->_objLngs = Languages::model()->findAll();
        $prefix = Yii::app()->language;
        
        foreach($this->_objLngs as $lng){
            if($lng->prefix == $prefix){
                $this->_currLngObj = $lng;
            }
            
            if($lng->active == 1){
                $this->_arrLng[] = $lng; 
            }
            
            $this->_arrAllLngsPrefix[$lng->id] = $lng->prefix;
        }
        //$this->_arrMessages = FormMessages::model()->getLabels();
    }

    /**
     * @return Languages[]
     */
    public function getLngs(){
        return $this->_objLngs;
    }
    
    
    public function getActLngs(){
        return $this->_arrLng;
    }

    /**
     * @return Languages
     */
    public function getCurrLng(){
        
        return $this->_currLngObj;
    }
    
    /**
     * @param $lng_prefix - Language prefix
     * @return int Language ID
     */
    public function getIdFromPrefix($lng_prefix){
        foreach ($this->_objLngs as $objLng){
            if($objLng->prefix == $lng_prefix ){
                return $objLng->id;
            }
        }
        
        return false;
    }
    
    public function getPrefixFromId($id){
        if(!empty($this->_arrAllLngsPrefix[$id])){
            return $this->_arrAllLngsPrefix[$id];
        }else{
            false;
        }
                
    }
    
    
}//SiteLng