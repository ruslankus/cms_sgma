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

        $this->_objLngs = Languages::model()->findAllByAttributes(array('active' => 1));
        $prefix = Yii::app()->language;
        foreach($this->_objLngs as $lng){
            if($lng->prefix == $prefix){
                $this->_currLngObj = $lng;
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
    
    public function getCurrLng(){
        return $this->_currLngObj;
    }
    
    
}//SiteLng