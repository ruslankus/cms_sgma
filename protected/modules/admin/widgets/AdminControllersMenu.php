<?php

class AdminControllersMenu extends CWidget {

    //current controller name
    public $current;

    /**
     * Widget entry point
     */
    public function run(){
        //render top menu widget
        $arrControllers = AdminModule::$adminMenu;
        $this->render('adminControllersMenu',array('current_controller' => $this->current, 'menu' => $arrControllers));
    }

}