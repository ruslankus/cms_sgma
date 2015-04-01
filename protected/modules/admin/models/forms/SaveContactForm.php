<?php

/**
 * Class AddPageForm
 */
class SaveContactForm extends CFormModel
{
   public $lngId;
   public $title;
   public $text;
   public $meta;
   
   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('title,text,lngId', 'required'),
            array('title,text,lngId,meta', 'safe'),          
        );
	}
   
    
    
}//class    