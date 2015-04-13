<?php

/**
 * Class AddPageForm
 */
class SaveContactBlockForm extends CFormModel
{
   public $lngId;
   public $title;
   public $description;
   public $meta;
   public $page_id;
   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('title,description,lngId,page_id', 'required'),
            array('title,description,lngId,meta', 'safe'),      
        );
	}
   
    
    
}//class    