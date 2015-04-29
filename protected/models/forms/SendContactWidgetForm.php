<?php

/**
 * Class AddPageForm
 */
class SendContactWidgetForm extends CFormModel
{
   public $email;
   public $text;
   public $code;
   public $name;
   /**
   * Declares the validation rules.
   */
  public function rules()
  {
        return array(
           // array('code', 'captcha'),
            array('email', 'email'),
            array('text,email,name', 'required'),
            array('email,text', 'safe'),      
        );
  }
   
  public function attributeLabels()
  {
    return array(
      'name' => Trl::t()->getLabel('Name'),
      'email' => Trl::t()->getLabel('Your mail'),
      'text' => Trl::t()->getLabel('Message text'),
      'code' => Trl::t()->getLabel('Sequrity code')

    );
  }
    
    
}//class    