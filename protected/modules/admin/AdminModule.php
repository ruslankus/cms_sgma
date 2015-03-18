<?php

class AdminModule extends CWebModule
{
	public $defaultController='main';

    public static $adminMenu = array(

        'main' => array('title' => 'Main', 'default' => 'index', 'actions' => array(
            'index' => array('title' => 'Information', 'html_id' => '', 'html_class' => '', 'html_style' => '', 'icon' => ''),
            'logout' => array('title' => 'Exit', 'html_id' => '', 'html_class' => '', 'html_style' => '', 'icon' => ''),
            'pages' => array('title' => 'Pages', 'html_id' => '', 'html_class' => '', 'html_style' => '', 'icon' => '')
        )),
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
