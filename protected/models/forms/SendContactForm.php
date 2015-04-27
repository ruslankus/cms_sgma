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
   
  public function attributeLabels()
  {
    return array(
      'email' => Trl::t()->getLabel('Your mail'),
      'text' => Trl::t()->getLabel('Message text'),
      'code' => Trl::t()->getLabel('Sequrity code')

    );
  }
    
    
}//class    