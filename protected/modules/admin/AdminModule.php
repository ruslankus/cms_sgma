<?php

class AdminModule extends CWebModule
{
	public $defaultController='main';

    /**
     * Main menu of admin panel
     * TODO: add access by role feature to menu
     * @var array
     */
    public static $adminMenu = array(
        'main' => array(
            'title' => 'Dashboard',
            'default' => 'index',
            'icon' => '',
            'html_class' => 'dashboard'),

        'menu' => array(
            'title' => 'Menu',
            'default' => 'index',
            'icon' => '',
            'html_class' => 'pages'),

        'pages' => array(
            'title' => 'Pages',
            'default' => 'index',
            'icon' => '',
            'html_class' => 'pages'),

        'products' => array(
            'title' => 'Products',
            'default' => 'index',
            'icon' => '',
            'html_class' => 'products',
            'actions' => array('index' => array('title' => 'Products'),'categories' => array('title' => 'Categories'),
        )),
        'settings' => array(
            'title' => 'Settings',
            'default' => 'index',
            'icon' => '',
            'html_class' => 'settings'),
            
        'Translation' => array(
            'title' => 'Translation',
            'default' => 'index',
            'icon' => '',
            'html_class' => 'translation',
            'actions' => array('panel' => array('title' => 'Panel translation'),'site' => array('title' => 'Site translation'))),    
    );

    public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
            'admin.models.forms.*',
            'admin.models.orm.*',
            'admin.models.orm.ext.*',
			'admin.components.*',
            'admin.helpers.*'
		));
        
        Yii::app()->setComponents(array(
            'errorHandler'=>array(
            'errorAction'=>'admin',
            ),
        ));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			
            // this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
