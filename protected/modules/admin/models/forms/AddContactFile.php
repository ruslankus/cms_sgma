<?php

/**
 * Class AddPageForm
 */
class AddContactFile extends CFormModel
{
    public $captions;
    public $file;
    public $save_error;
    
    public function rules()
    {
        return array(
            array('captions', 'validateCaptions'),
            array('file', 'file', 'types'=>'jpg, gif, png','maxSize' => 1048576)
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