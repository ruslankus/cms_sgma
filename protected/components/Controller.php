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

    public $arrSettings = array();

    public function init(){
        
        //set default ime-zone
        date_default_timezone_set('Europe/Vilnius');
        
        $language = Yii::app()->request->getParam('language',Yii::app()->params['defaultLanguage']);
        $this->setLanguage($language);

        //get all settings from db

        $this->arrSettings = ExtSettings::model()->getSettings(true);

        //if not empty theme name
        if(!empty($this->arrSettings['active_desktop_theme']))
        {
            //set theme
            Yii::app()->theme = $this->arrSettings['active_desktop_theme'];
            //Yii::app()->theme = 'asddsf';
        }

    }//init


    /**
     * Override before action method
     * @param CAction $action
     * @return bool|void
     */
    protected function beforeAction($action) {


        /**
         * Init dynamic widgets
         */
        DynamicWidgets::init(Yii::app()->theme->name,$this);


        /**
         * Appending JS and CSS files to the layout
         */

        //appearance from theme dir
        $appearance_dir_theme = Yii::app()->theme->basePath.DS.'appearance';
        //appearance from core dir
        $appearance_dir_core =  Yii::app()->basePath.DS.'appearance';
        //get dor of core (if theme not set, or hasn't it's own appearance folder) or theme appearance
        $appearance_dir = (Yii::app()->theme != null && is_dir($appearance_dir_theme)) ? $appearance_dir_theme : $appearance_dir_core;
        //published URL of appearance
        $published_url = Yii::app()->assetManager->publish($appearance_dir);

        $pub_url_arr = explode('/',$published_url);
        $dir = $pub_url_arr[count($pub_url_arr)-1];
        $published_dir = Yii::app()->assetManager->getBasePath().DS.$dir;


        if(is_dir($published_dir.DS.'css'))
        {
            $arr = scandir($published_dir.DS.'css');
            foreach($arr as $filename)
            {
                if(is_file($published_dir.DS.'css'.DS.$filename))
                {
                    Yii::app()->clientScript->registerCssFile($published_url.'/css/'.$filename);
                }
            }
        }

        if(is_dir($published_dir.DS.'js'))
        {
            $arr = scandir($published_dir.DS.'js');
            foreach($arr as $filename)
            {
                if(is_file($published_dir.DS.'js'.DS.$filename))
                {
                    Yii::app()->clientScript->registerScriptFile($published_url.'/js/'.$filename);
                }
            }
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