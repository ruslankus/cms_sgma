<?php
Class ExtLanguages extends Languages
{
    
    public static function model($className=__CLASS__)
    {
    	return parent::model($className);
    }

    
     
     /**
     * Set language
     * @param string $lng
     */
    public function SetLanguage($lng)
    {
        /* set language in config */
        Yii::app()->language = $lng;
    
        /* set language in user state */
        Yii::app()->user->setState('language', $lng);
    
        /* set language in cookie */
        Yii::app()->request->cookies['language'] = new CHttpCookie('lng', $lng);
    
        /* if user has language - set it*/
        if (Yii::app()->user->hasState('language')){
            
            Yii::app()->language = Yii::app()->user->getState('language');
            
        }elseif(isset(Yii::app()->request->cookies['language'])){
            Yii::app()->language = Yii::app()->request->cookies['language']->value;}
    }

    
}    