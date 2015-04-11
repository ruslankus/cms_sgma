<?php

class ControllerAdmin extends CController
{

    public $layout='/layouts/main';
    public $title = "SIGMA CMS";
    public $description = "Content Management System";
    public $keywords = "";
    public $assetsPath = "";

    /**
     * Check if user allowed to admin's module controllers and actions
     * @param CWebUser $user
     * @param string $controller
     * @param string $action
     * @return bool
     */
    public function isUserAllowed($user,$controller,$action)
    {
        /* @var $user CWebUser */
        /* @var $dbUser ExtUsers */
        /* @var $role UserRole */
        /* @var $available Available */

        $isAllowed = false;

        if(!$user->isGuest)
        {
            //get user role
            $role_id = $user->getState('role');
            $role = UserRole::model()->findByPk($role_id);

            if(empty($role))
            {
                return $isAllowed;
            }

            $arrAvailable = $role->availables;

            foreach($arrAvailable as $available)
            {
                if($available->action->name == $action && $available->action->controller->name == $controller)
                {
                    $isAllowed = true;
                }
            }

        }

        //return $isAllowed;
        return true;
    }


    /*
    public function __construct($id,$module=null)
    {
        //set default ime-zone
        date_default_timezone_set('Europe/Vilnius');

        $language = Yii::app()->request->getParam('language',Yii::app()->params['defaultLanguage']);
        $this->setLanguage($language);

        parent::__construct($id,$module);
    }
    */

    public function init()
    {
        //set default ime-zone
        date_default_timezone_set('Europe/Vilnius');

        $language = Yii::app()->request->getParam('language',Yii::app()->params['defaultLanguage']);
        $this->setLanguage($language);
        
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

    /**
     * Override before action method
     * @param CAction $action
     * @return bool|void
     */
    protected function beforeAction($action) {


        //publish dir to assets (fonts, css, js, images)
//        $this->assetsPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('admin.appearance'),false,-1,true); //use for debug
        $this->assetsPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('admin.appearance')); //use for production

        //register css
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/jquery-ui.min.css');
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/style.css');
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/preloader.css');
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.css');

        //register scripts
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/jquery-1.11.2.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/jquery-ui.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.dialog-box.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.preloader.js',CClientScript::POS_END);

        //if current action - not login
        if($action->id != 'login')
        {
            //if user not allowed to this controller and action
            if(Yii::app()->user->isGuest)
            {
               
                $this->redirect(Yii::app()->createUrl('/admin/main/login'));
            }
        }

        return parent::beforeAction($action);
    }
}