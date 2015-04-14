<?php

/**
 * Class AddPageForm
 */
class AddBannerFile extends CFormModel
{
    public $captions;
    public $file;
    public $save_error;
    public $page_id;
    
    public function rules()
    {
        return array(
            array('captions', 'validateCaptions'),
            array('file', 'file', 'types'=>'jpg, gif, png','maxSize' => 1048576),
            array('file','checkCount')
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
    
    
    public function checkCount(){
        $objImgs = ImagesOfPage::model()->findAllByAttributes(array('page_id' => $this->page_id));
        if(count($objImgs) >= 5)
        {
            $this->addError('file', "To much photos");
        }
        
        return ($this->hasErrors())? false : true; 
    }
    
}    