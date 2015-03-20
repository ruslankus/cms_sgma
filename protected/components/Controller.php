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


    /**
     * Constructor override - to assign language
     * @param string $id
     * @param null $module
     */
    public function __construct($id,$module=null)
    {
        //set default ime-zone
        date_default_timezone_set('Europe/Vilnius');

        $language = Yii::app()->request->getParam('language',Yii::app()->params['defaultLanguage']);
        $this->setLanguage($language);

        //TODO: get theme from db
        Yii::app()->theme = "dark";

        parent::__construct($id,$module);
    }

    /**
     * Override before action method
     * @param CAction $action
     * @return bool|void
     */
    protected function beforeAction($action) {

        /**
         * Read all widget positions from INI file
         */
        $themeConfigFile = !empty(Yii::app()->theme) ? Yii::app()->theme->basePath.'/config/theme.ini' : Yii::app()->basePath.'/config/theme.ini';
        $arrThemeConfig = file_exists($themeConfigFile) ? parse_ini_file($themeConfigFile,true) : array();
        $arrWidgetPositions = !empty($arrThemeConfig['widget_positions']) ? $arrThemeConfig['widget_positions'] : array();

        /**
         * Initialise dynamic widgets
         */
        DynamicWidgets::init($arrWidgetPositions,$this);

        /*
        //publish dir to assets (fonts, css, js, images)
        $publishedPath = Yii::app()->assetManager->publish(Yii::app()->theme->basePath.'/asset');
        Yii::app()->clientScript->registerCssFile($publishedPath.'/css/main.css');
        Yii::app()->clientScript->registerCssFile($publishedPath.'/css/controller.css');
        */

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