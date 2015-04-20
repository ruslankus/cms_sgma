<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public $layout='//layouts/main';
    public $menu=array();
    public $breadcrumbs=array();

    public $title = "";
    public $keywords = "";
    public $description = "";
    
    //settingng
    public $arrSettings = array();

    public function init(){
        
        //set default ime-zone
        date_default_timezone_set('Europe/Vilnius');
        
        $language = Yii::app()->request->getParam('language',Yii::app()->params['defaultLanguage']);
        $this->setLanguage($language);
        
        //TODO: get theme name form current settings
        //Set settings
        $this->arrSettings = ExtSettings::model()->getSettings(true);
      
        if(!empty($this->arrSettings['active_desktop_theme'])){
            Yii::app()->theme = $this->arrSettings['active_desktop_theme'];   
        }else{
        //Default
            Yii::app()->theme = 'classic';  
        }
       
        
    }//init

    /**
     * Override before action method
     * @param CAction $action
     * @return bool|void
     */
    protected function beforeAction($action) {

        /**
         * Initialise dynamic widgets
         */
        DynamicWidgets::init(Yii::app()->theme->name,$this);

        
        //publish dir to assets (fonts, css, js, images)
        //$publishedPath = Yii::app()->assetManager->publish(Yii::app()->theme->basePath.'/appearance');
        //Yii::app()->clientScript->registerCssFile($publishedPath.'/css/main.css');
       // Yii::app()->clientScript->registerCssFile($publishedPath.'/css/controller.css');

        if(is_dir(Yii::app()->theme->basePath))
        {
            $publishedPath = Yii::app()->assetManager->publish(Yii::app()->theme->basePath.'/appearance');       
            $arrThemeFiles = ThemeFiles::getThemeFiles($publishedPath);         
            print_r($arrThemeFiles);
            //echo $publishedPath;
        }

        return parent::beforeAction($action);
    }

    /**
     * Setup the language
     * @param $lng
     */
    public function setLanguage($lng)
    {
        $objUser = Yii::app()->user;
        $request = Yii::app()->request;

        Yii::app()->language = $lng;
        $objUser->setState('language', $lng);
        $request->cookies['language'] = new CHttpCookie('lng', $lng);

        if ($objUser->hasState('language')) {
            Yii::app()->language = $objUser->getState('language');
        }
        elseif (isset($request->cookies['language'])) {
            Yii::app()->language = $request->cookies['language']->value;
        }
    }

}