<?php

/**
 * Class AddPageForm
 */
class SaveContactForm extends CFormModel
{
   public $lngId;
   public $title;
   public $description;
   public $templates;
   public $meta;
   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('title,description,lngId', 'required'),
            array('title,description,lngId,meta,templates', 'safe'),      
        );
	}
   
    
    
}//class    