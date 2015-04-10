<?php

/**
 * Class AddPageForm
 */
class SaveContactForm extends CFormModel
{
   public $lngId;
   public $title;
   public $description;
   public $meta;
   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('title,description,lngId', 'required'),
            array('title,description,lngId,meta', 'safe'),      
        );
	}
   
    
    
}//class    