<?php
/**
 * Labels and messages translation
 */
class SiteLng
{
    
    private static $_instance = false;   
    private $_arrLng = array();
    private $_objLngs;
  
    
    public static function lng(){
        if(!self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    
     private function __construct() {

        $this->_objLngs = Languages::model()->findAll();
        //$this->_arrMessages = FormMessages::model()->getLabels();
    }
    
    
    public function getLngs(){
        return $this->_objLngs;
    }
    
    
}//SiteLng