<?php

class MainMenu extends CWidget {

    //current controller name
    public $currentController;

    //current action name
    public $currentAction;

    /**
     * Widget entry point
     */
    public function run(){
        //render top menu widget
        $arrMenu = AdminModule::$adminMenu;
        $this->render('mainMenu',array('current_controller' => $this->currentController, 'current_action' => $this->currentAction, 'menu' => $arrMenu));
    }

}