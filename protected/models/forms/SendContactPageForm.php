<?php

/**
 * Class SendContactPageForm
 */
class SendContactPageForm extends CFormModel
{
   public $name;
   public $email_from;
   public $content;
   public $code;
   /**
   * Declares the validation rules.
   */
  public function rules()
  {
        return array(
            array('code', 'captcha'),
            array('email_from', 'email'),
            array('content,email_from,name', 'required'),
            array('email_from,content,name', 'safe'),      
        );
  }
   
  public function attributeLabels()
  {
    return array(
      'name' => Trl::t()->getLabel('Your name'),
      'email_from' => Trl::t()->getLabel('Your mail'),
      'content' => Trl::t()->getLabel('Message'),
      'code' => Trl::t()->getLabel('Sequrity code')
    );
  }
    
    
}//class    