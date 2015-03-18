<?php

class AdminActionsMenu extends CWidget {

    //current controller name
    public $currentController;

    //current action name
    public $currentAction;

    /**
     * Widget entry point
     */
    public function run(){

        $arrActions = array();

        //render top menu widget
        if(isset(AdminModule::$adminMenu[$this->currentController]['actions']))
        {
            $arrActions = AdminModule::$adminMenu[$this->currentController]['actions'];
        }

        $this->render('adminActionsMenu',array('current_controller' => $this->currentController, 'current_action' => $this->currentAction, 'actions' => $arrActions));
    }

}