<?php
/**
 * Labels and messages translation
 */
class SiteLng
{
    
    private static $_instance = false;   
    private $_arrLng = array();
    private $_objLngs;
    private $_currLngObj;
  
    
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
    
    public function getCurrLng(){
        
        return $this->_currLngObj;
    }
    
    
}//SiteLng