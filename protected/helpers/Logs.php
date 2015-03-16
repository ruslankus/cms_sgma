<?php
/**
 * Logs 
 */
class Logs
{
    const DS = DIRECTORY_SEPARATOR;
    private static $_instanse = false;  
    private $_logfile;
    private $_fname;
    private $_lname;
    
    public static function inst(){
        if(!self::$_instanse){
            self::$_instanse = new self();
        }
        return self::$_instanse;
    } 
    
    private function __construct(){
        $this->_logfile = dirname(Yii::app()->request->scriptFile). self::DS ."logs" . self::DS . "log.txt";
        
        $this->_fname = Yii::app()->user->getState('name');
        $this->_lname = Yii::app()->user->getState('surname');
    }
    
    
    public function log_action($action,$message=""){
        
        if($handle = fopen($this->_logfile,'a')){
            
            $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
            $content = "{$timestamp} : {$this->_fname} {$this->_lname} : {$action} : {$message}".PHP_EOL;
            fwrite($handle,$content);      
            fclose($handle);
        }else {
            //
        }
    }//log_action 
    
    
    public function getlog(){
        
         return file($this->_logfile);
    }  
    
}//Logs    