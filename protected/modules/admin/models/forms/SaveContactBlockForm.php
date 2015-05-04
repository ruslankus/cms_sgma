<?php

/**
 * Class AddPageForm
 */
class SaveContactBlockForm extends CFormModel
{
   public $lngId;
   public $title;
   public $text;
   public $meta;
   public $page_id;
   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('title,text,lngId,page_id', 'required'),
            array('title,text,lngId,meta', 'safe'),      
        );
	}
   
    
    
}//class    