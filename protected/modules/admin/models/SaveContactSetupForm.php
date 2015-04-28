<?php

/**
 * Class SaveContactSetupForm
 * Save contacts setup 
 */
class SaveContactSetupForm extends CFormModel
{
   public $save_form;
   public $template_name;

   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('template_name', 'safe'),      
        );
	}
   
    
    
}//class    