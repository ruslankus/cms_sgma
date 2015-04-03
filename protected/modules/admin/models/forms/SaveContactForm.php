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
   public $email;
   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('title,text,lngId,email', 'required'),
            array('title,text,lngId,meta,email', 'safe'),      
        );
	}
   
    
    
}//class    