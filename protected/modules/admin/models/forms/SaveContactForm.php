<?php

/**
 * Class AddPageForm
 */
class SaveContactForm extends CFormModel
{
   public $lngId;
   public $contactId;
   public $title;
   public $text;

   
   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('title,text,lngId,contactId', 'required'),
            array('title,text,lngId,contactId', 'safe'),          
        );
	}
   
    
    
}//class    