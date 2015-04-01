<?php

/**
 * Class AddPageForm
 */
class SavePageForm extends CFormModel
{
   public $lngId;
   public $pageId;
   public $title;
   public $content;
   public $note;
   
   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('title,content,lngId,pageId,note', 'required'),
            array('title,content,lngId,pageId,note', 'safe'),          
        );
	}
   
    
    
}//class    