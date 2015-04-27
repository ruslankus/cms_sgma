<?php

/**
 * Class AddPageForm
 */
class SendContactForm extends CFormModel
{
   public $email;
   public $text;
   public $code;
   /**
   * Declares the validation rules.
   */
  public function rules()
  {
        return array(
           // array('code', 'captcha'),
            array('email', 'email'),
            array('text,email', 'required'),
            array('email,text', 'safe'),      
        );
  }
   
    
    
}//class    