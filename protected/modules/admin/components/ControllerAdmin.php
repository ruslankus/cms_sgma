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
            'logout' => array(ExtUserRoles::ROLE_ROOT,ExtUserRoles::ROLE_ADMIN)
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

            //return true if user's role is allowed
            return in_array($role,$arrAllowedRoles);
        }

        return false;
    }
    

    /**
     * Override before action method
     * @param CAction $action
     * @return bool|void
     */
    protected function beforeAction($action) {

        //if current action - not login
        if($action->id != 'login')
        {
            //if user not allowed to this controller and action
            if(!$this->isUserAllowed(Yii::app()->user,Yii::app()->controller->id,$action->id))
            {
                //redirect to login
                $this->redirect(Yii::app()->createUrl('/admin/main/login'));
            }
        }

        return parent::beforeAction($action);
    }
}