<?php
/**
 * Labels and messages translation
 */
class Trl
{
    private static $_instance = false;   
    private $_arrLabels = array();
    private $_arrMessages = array();
    
    public static function t(){
        if(!self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    private function __construct() {

        $currLng = Yii::app()->language;
        $this->_arrLabels = ExtLabels::model()->getLabels($currLng);
        //$this->_arrMessages = FormMessages::model()->getLabels();
    }
        
    private function __clone(){}
    
    public function getLabel($labelName)
    {
        if(array_key_exists($labelName,$this->_arrLabels)){
            if(empty($this->_arrLabels[$labelName])){
                return '!'.$labelName;    
            }else{
                return $this->_arrLabels[$labelName];    
            } 
            
        }else{
            return '*'.$labelName;  
        }
    }//getLabel
    
    
    public function getMsg($message){
        
        if(array_key_exists($message,$this->_arrMessages)){
            if(empty($this->_arrMessages[$message])){
                return '!'.$message;    
            }else{
                return $this->_arrMessages[$message];    
            }
           
        }else{
            return '*'.$message;  
        }
    }//getMessage
 
    
}





