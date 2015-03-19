<?php

class ControllerAdmin extends CController
{
    /**
     * Access rules for every action in every controller for role(roles - not editable, and can be
     * edited only by developer)
     * @var array
     */
    public $accessRulesForRoles = array(

        'main' => array(
            'index' => array(ExtUserRoles::ROLE_ADMIN,ExtUserRoles::ROLE_ROOT),
            'logout' => array(ExtUserRoles::ROLE_ROOT,ExtUserRoles::ROLE_ADMIN),
            'pages' => array(ExtUserRoles::ROLE_ROOT,ExtUserRoles::ROLE_ADMIN)
        ),
    );

    public $layout='/layouts/main';
    public $title = "SIGMA CMS";
    public $description = "Content Management System";
    public $keywords = "";

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

        if(!$user->isGuest)
        {
            //get user role
            $role = $user->getState('role');
            $arrAllowedRoles = $this->accessRulesForRoles[$controller][$action];

            if(empty($arrAllowedRoles))
            {
                return false;
            }

            //return true if user's role is allowed
            return in_array($role,$arrAllowedRoles);
        }

        return false;
    }

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

        parent::__construct($id,$module);
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
        $publishedPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('admin.admin_assets'));

        //register css
        Yii::app()->clientScript->registerCssFile($publishedPath.'/css/jquery-ui.min.css');
        Yii::app()->clientScript->registerCssFile($publishedPath.'/css/style.css');

        //register scripts
        Yii::app()->clientScript->registerScriptFile($publishedPath.'/js/jquery-1.11.2.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($publishedPath.'/js/jquery-ui.min.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($publishedPath.'/js/panel.js',CClientScript::POS_END);

        //if current action - not login
        if($action->id != 'login')
        {
            //if user not allowed to this controller and action
            if(!$this->isUserAllowed(Yii::app()->user,$action->controller->id,$action->id))
            {
                $this->redirect(Yii::app()->createUrl('/admin/main/login'));
            }
        }

        return parent::beforeAction($action);
    }
}