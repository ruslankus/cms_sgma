<?php

class MenuController extends ControllerAdmin
{
    /**
     * Index - list all menu
     */
    public function actionIndex()
    {
        /* @var $menus ExtMenu[] */
        $menus = ExtMenu::model()->findAll();
        $this->render('list_menu',array('menus' => $menus));
    }


    public function actionAddMenu()
    {
        //menu form
        $form_mdl = new AddMenuForm();

        //currently selected theme
        $selectedTheme = 'dark'; //TODO: select theme from DB

        //get all templates for menus
        $themeManager = Yii::app()->themeManager;
        $dir = $themeManager->basePath.DS.$selectedTheme.DS.'views'.DS.'menus';
        $files = scandir($dir);
        $templates = array();

        foreach($files as $fileName)
        {
            if($fileName != ".." && $fileName != ".")
            {
                $templates[$fileName] = $fileName;
            }
        }

        //statuses
        $statuses = ExtStatus::model()->arrayForMenuForm(true);

        //if have form
        if($_POST['AddMenuForm'])
        {
            $form_mdl->attributes = $_POST['AddMenuForm'];

            if($form_mdl->validate())
            {
                $menu = new ExtMenu();
                $menu->attributes = $form_mdl->attributes;
                $menu->time_updated = time();
                $menu->time_created = time();
                $menu->last_change_by = Yii::app()->user->getState('id');
                $menu->save();

                //back to list
                $this->redirect(Yii::app()->createUrl('/admin/menu/index'));
            }
        }

        $this->render('add_menu',array('templates' => $templates, 'statuses' => $statuses, 'form_model' => $form_mdl));
    }

    /**
     * List  all items and other settings of menu
     * @param $id
     * @param int $page
     * @throws CHttpException
     */
    public function actionEditMenu($id,$page = 1)
    {
        //find menu
        $menu = ExtMenu::model()->findByPk((int)$id);

        //if not found
        if(empty($menu))
        {
            throw new CHttpException(404);
        }

        //get all items
        $items = $menu->buildObjArrRecursive();

        //pager stuff
        $perPage = 10;
        $total_pages = (int)ceil(count($items)/$perPage);
        $offset = (int)($perPage * ($page - 1));
        $itemsOfPage = array_slice($items,$offset,$perPage);

        //currently selected theme
        $selectedTheme = 'dark'; //TODO: select theme from DB

        //get all templates for menus
        $themeManager = Yii::app()->themeManager;
        $dir = $themeManager->basePath.DS.$selectedTheme.DS.'views'.DS.'menus';
        $files = scandir($dir);
        $templates = array();

        foreach($files as $fileName)
        {
            if($fileName != ".." && $fileName != ".")
            {
                $templates[] = $fileName;
            }
        }

        $this->render('edit_menu',array('items' => $itemsOfPage, 'pages' => $total_pages, 'templates' => $templates, 'menu' => $menu));
    }

    /**
     * Loads list of available content items by type
     * @param int $id
     */
    public function actionAjaxContentItemsByType($id = ExtMenuItemType::TYPE_SINGLE_PAGE)
    {
        $objItems = array();

        switch($id)
        {
            case ExtMenuItemType::TYPE_SINGLE_PAGE:
                $objItems = ExtPage::model()->findAll(array('order' => 'priority DESC'));
                break;

            case ExtMenuItemType::TYPE_NEWS_CATALOG:
                $objItems = ExtNewsCategory::model()->findAll(array('order' => 'priority DESC'));
                break;

            case ExtMenuItemType::TYPE_PRODUCTS_CATALOG:
                $objItems = ExtProductCategory::model()->findAll(array('order' => 'priority DESC'));
                break;

            case ExtMenuItemType::TYPE_CONTACT_FORM:
                break;

            case ExtMenuItemType::TYPE_COMPLEX_PAGE:
                break;
        }

        $this->renderPartial('_ajax_content_items',array('objContentItems' => $objItems));
    }

    /**
     * Edit menu item
     * @param $id
     * @throws CHttpException
     */
    public function actionEditItem($id)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);

        //find item of menu
        $objItem = ExtMenuItem::model()->findByPk($id);

        //languages
        $objLanguages = ExtLanguages::model()->findAll();

        //get all menu items in menu of current item
        $objItems = $objItem->menu->buildObjArrRecursive();

        //all types of item
        $objTypes = MenuItemType::model()->findAll();

        ///if not found
        if(empty($objItem))
        {
            throw new CHttpException(404);
        }

        if(isset($_POST['ItemForm']))
        {
            //TODO: update item
        }

        $this->render('edit_menu_item',array('languages' => $objLanguages, 'curItem' => $objItem, 'items' => $objItems, 'types' => $objTypes));
    }
}