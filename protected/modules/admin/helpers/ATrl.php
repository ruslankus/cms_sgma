<?php
/**
 * Labels and messages translation
 */
class ATrl
{
    private static $_instance = false;   
    private $_arrLabels = array();
    private $_arrMessages = array();

    /**
     * Singleton style
     * @return ATrl|bool
     */
    public static function t(){
        if(!self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor - get all labels and messages from DB
     */
    private function __construct() {

        $currLng = Yii::app()->language;
        $this->_arrLabels = ExtAdminLabels::model()->getLabels($currLng);
        $this->_arrMessages = ExtAdminMessages::model()->getMessages($currLng);
    }

    /**
     * Disable cloning (singleton)
     */
    private function __clone(){}

    /**
     * Get translation for label
     * @param $labelName
     * @return string
     */
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
    }

    /**
     * Get translation of messages
     * @param $message
     * @return string
     */
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
    }
 
    
}





