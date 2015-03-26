<?php

class MenuController extends ControllerAdmin
{
    /**
     * Index - list all menu
     */
    public function actionIndex($page = 1)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.menu-list.js',CClientScript::POS_END);

        /* @var $menus ExtMenu[] */
        $menus = ExtMenu::model()->findAll();

        //pager stuff
        $perPage = 10;
        $total_pages = (int)ceil(count($menus)/$perPage);
        $offset = (int)($perPage * ($page - 1));
        $itemsOfPage = array_slice($menus,$offset,$perPage);

        $this->render('list_menu',array('menus' => $itemsOfPage, 'total_pages' => $total_pages, 'current_page' => $page));
    }


    /**
     * Deleting menu
     * @param $id
     * @throws CHttpException
     */
    public function actionDeleteMenu($id)
    {
        //find menu
        $menu = ExtMenu::model()->findByPk($id);

        //if not found
        if(empty($menu))
        {
            throw new CHttpException(404);
        }

        $menu->delete();

        //back to list
        $this->redirect(Yii::app()->createUrl('/admin/menu/index'));
    }

    /**
     * Adding menu
     */
    public function actionAddMenu()
    {
        //not include jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

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

        //if ajax validation
        if(isset($_POST['ajax']))
        {
            if($_POST['ajax'] == 'add-form')
            {
                echo CActiveForm::validate($form_mdl);
            }
            Yii::app()->end();
        }

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

        $this->renderPartial('_add_menu',array('templates' => $templates, 'statuses' => $statuses, 'form_model' => $form_mdl),false,true);
    }

    /**
     * List all items of menu
     * @param $id
     * @param int $page
     * @throws CHttpException
     */
    public function actionMenuItems($id,$page = 1)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.trees.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.main-menu.js',CClientScript::POS_END);

        //find menu
        $menu = ExtMenu::model()->findByPk((int)$id);

        //if not found
        if(empty($menu))
        {
            throw new CHttpException(404);
        }

        //get all items
        $items = $menu->buildObjArrRecursive();
        $items = ExtMenu::model()->divideToRootGroups($items);

        //pager stuff
        $perPage = 10;
        $total_pages = (int)ceil(count($items)/$perPage);
        $offset = (int)($perPage * ($page - 1));
        $itemsOfPage = array_slice($items,$offset,$perPage,true);

        $this->render('list_menu_items',array('items' => $itemsOfPage, 'pages' => $total_pages, 'menu' => $menu ,'current_page' => $page));
    }


    /**
     * Edit and update menu
     * @param $id
     * @throws CHttpException
     */
    public function actionEditMenu($id)
    {
        //find menu
        $menu = ExtMenu::model()->findByPk((int)$id);

        //if not found
        if(empty($menu))
        {
            throw new CHttpException(404);
        }

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
                $menu->attributes = $form_mdl->attributes;
                $menu->time_updated = time();
                $menu->last_change_by = Yii::app()->user->getState('id');
                $menu->update();

                //back to list
                $this->redirect(Yii::app()->createUrl('/admin/menu/index'));
            }
        }

        $this->render('edit_menu',array('templates' => $templates, 'statuses' => $statuses, 'form_model' => $form_mdl, 'menu' => $menu));
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


    /**
     * Confirm deletion pup-up
     * @param string $type
     * @param $id
     */
    public function actionPopDel($type = 'item',$id)
    {
        $link = "#";

        switch ($type)
        {
            case 'menu': $link = Yii::app()->createUrl('/admin/deletemenu',array('id' => $id));  break;
            case 'item': $link = Yii::app()->createUrl('/admin/deleteitem',array('id' => $id)); break;
        }

        $this->renderPartial('_confirm_delete',array('link' => $link));
    }

    /**
     * Deleting item
     * @param $id
     * @throws CHttpException
     */
    public function actionDeleteItem($id)
    {
        //find item of menu
        $objItem = ExtMenuItem::model()->findByPk($id);

        ///if not found
        if(empty($objItem))
        {
            throw new CHttpException(404);
        }

        //menu id
        $menu_id = $objItem->menu_id;

        //delete item (and all related with it content by CASCADE)
        $objItem->delete();

        //back to listing items of menu
        $this->redirect(Yii::app()->createUrl('/admin/menu/menuitems',array('id' => $menu_id)));
    }
}