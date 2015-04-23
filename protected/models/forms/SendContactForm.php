<?php

/**
 * Class AddPageForm
 */
class SendContactForm extends CFormModel
{
   public $email;
   public $text;
   public $verifyCode;
   /**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('verifyCode', 'captcha', 'message'=>'caPTCHA ERROT'),
            array('email,text', 'required'),
            array('email,text', 'safe'),      
        );
	}
   
    
    
}//class    