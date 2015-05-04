<?php

/**
 * Class AddPageForm
 */
class SaveContactForm extends CFormModel
{
   public $lngId;
   public $title;
   public $description;
   //public $templates;
   public $meta;
   public $email;
   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('email', 'email'),
            array('title,description,lngId,email', 'required'),
            array('title,description,lngId,meta', 'safe'),      
        );
	}
   
    
    
}//class    