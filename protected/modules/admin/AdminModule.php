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

        array(
            'controller' => 'main',
            'action' => 'index',
            'icon' => '',
            'html_class' => 'dashboard',
            'title' => 'Dashboard'
        ),
        array(
            'controller' => 'menu',
            'action' => 'list',
            'icon' => '',
            'html_class' => 'pages',
            'title' => 'Menu',

            'sub' => array(
                array('controller' => 'menu', 'action' => 'list', 'title' => 'Menus'),
                array('controller' => 'widgets', 'action' => 'list', 'title' => 'Widgets')
            ),
        ),
        array(
            'controller' => 'pages',
            'action' => 'index',
            'icon' => '',
            'html_class' => 'pages',
            'title' => 'Pages',
        ),

        array(
            'controller' => 'complex',
            'action' => 'pages',
            'icon' => '',
            'html_class' => 'pages',
            'title' => 'Custom Pages',

            'sub' => array(
                array('controller' => 'complex', 'action' => 'pages', 'title' => 'Page list'),
                array('controller' => 'complex', 'action' => 'attrgroups', 'title' => 'Attributes')
            ),
        ),

        array(
            'controller' => 'contacts',
            'action' => 'pages',
            'html_class' => 'pages',
            'title' => 'Contacts',
            /*
            'sub' => array(
                array('controller' => 'contacts', 'action' => 'pages', 'title' => 'Pages')
                //array('controller' => 'contacts' ,'action' => 'blocks', 'title' => 'Blocks')
            ),
            */
        ),

        array(
            'controller' => 'news',
            'action' => 'categories',
            'icon' => '',
            'html_class' => 'products',
            'title' => 'News',

            'sub' => array(
                array('controller' => 'news', 'action' => 'categories', 'title' => 'Categories'),
                array('controller' => 'news', 'action' => 'list', 'title' => 'News list'),
            ),
        ),

        array(
            'controller' => 'products',
            'action' => 'categories',
            'icon' => '',
            'html_class' => 'products',
            'title' => 'Products',

            'sub' => array(
                array('controller' => 'products', 'action' => 'categories', 'title' => 'Categories'),
                array('controller' => 'products', 'action' => 'list', 'title' => 'Product list'),
                array('controller' => 'products', 'action' => 'attrgroups', 'title' => 'Attributes'),
                array('controller' => 'products', 'action' => 'tags', 'title' => 'Tags')
            ),
        ),

        array(
            'controller' => 'gallery',
            'action' => 'index',
            'html_class' => 'pages',
            'title' => 'Gallery',
        ),

        array(
            'controller' => 'settings',
            'action' => 'index',
            'icon' => '',
            'html_class' => 'settings',
            'title' => 'Settings',
        ),
        array(
            'controller' => 'translation',
            'action' => 'index',
            'icon' => '',
            'html_class' => 'translate',
            'title' => 'Translation',

            'sub' => array(
                array('controller' => 'translation', 'action' => 'index', 'title' => 'Panel translation'),
                array('controller' => 'translationSite', 'action' => 'index', 'title' => 'Site translation'),
            ),
        ),
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
        
        /*
        Yii::app()->setComponents(array(
            'errorHandler'=>array(
            'errorAction'=>'admin',
            ),
        ));
        */
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
