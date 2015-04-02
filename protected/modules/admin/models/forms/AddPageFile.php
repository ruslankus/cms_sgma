<?php

/**
 * Class AddPageForm
 */
class AddPageFile extends CFormModel
{
    public $captions;
    
    public function rules()
    {
        return array(
            array('captions', 'validateCaptions'),
        );
    }
    
    
    
    public function validateCaptions(){
        
        foreach($this->captions as $key => $value){
            if(empty($value)){
                $this->addError("captions[{$key}]","Can't be empty");
                
            }
        }
        
        return ($this->hasErrors())? false : true; 
    
    }//validateCaptions
    
}    