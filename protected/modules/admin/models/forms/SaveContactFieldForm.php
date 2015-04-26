<?php

/**
 * Class Contact Page block field
 */
class SaveContactFieldForm extends CFormModel
{
   public $lngId;
   public $name;
   public $value;
   public $block_id;
   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('name,value', 'required'),
            array('name,value', 'safe'),      
        );
	}
   
    
    
}//class    