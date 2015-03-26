<?php

class MenuController extends ControllerAdmin
{

    /************************************************ M E N U *********************************************************/

    /**
     * List all menus (and create by modal)
     */
    public function actionList($page = 1)
    {
        //include necessary scripts and css
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.dialog-box.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.menu-list.js',CClientScript::POS_END);

        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.css');
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');


        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //menu form
        $form_mdl = new AddMenuForm();
        //currently selected theme
        $selectedTheme = 'dark'; //TODO: select theme from DB
        //get all templates for menus
        $templates = ThemeHelper::getTemplatesForMenu($selectedTheme);
        //statuses
        $statuses = ExtStatus::model()->arrayForMenuForm(true);

        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'add-form')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
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
                }
            }
        }

        //special for form with-ajax validation
        $form_params = array('templates' => $templates, 'statuses' => $statuses, 'form_model' => $form_mdl);


        /* @var $menus ExtMenu[] */
        $menus = ExtMenu::model()->findAll();

        //pager stuff
        $perPage = 10;
        $total_pages = (int)ceil(count($menus)/$perPage);
        $offset = (int)($perPage * ($page - 1));
        $itemsOfPage = array_slice($menus,$offset,$perPage);

        $this->render('list_menu',array('menus' => $itemsOfPage, 'total_pages' => $total_pages, 'current_page' => $page, 'form_params' => $form_params));
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
        $templates = ThemeHelper::getTemplatesForMenu($selectedTheme);
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
                $this->redirect(Yii::app()->createUrl('/admin/menu/list'));
            }
        }

        $this->render('edit_menu',array('templates' => $templates, 'statuses' => $statuses, 'form_model' => $form_mdl, 'menu' => $menu));
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
        $this->redirect(Yii::app()->createUrl('/admin/menu/list'));
    }


    /******************************************* M E N U  I T E M *****************************************************/


    /**
     * List all items of menu
     * @param $id
     * @param int $page
     * @param int $ajax
     * @throws CHttpException
     */
    public function actionMenuItems($id,$page = 1,$ajax = 0)
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

        if(!$ajax)
        {
            $this->render('list_menu_items',array('items' => $itemsOfPage, 'pages' => $total_pages, 'menu' => $menu ,'current_page' => $page));
        }
        else
        {
            $this->renderPartial('_list_menu_items',array('items' => $itemsOfPage, 'pages' => $total_pages, 'menu' => $menu ,'current_page' => $page));
        }

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
            case 'menu': $link = Yii::app()->createUrl('/admin/menu/deletemenu',array('id' => $id));  break;
            case 'item': $link = Yii::app()->createUrl('/admin/menu/deleteitem',array('id' => $id, 'ajax' => 1)); break;
        }

        $this->renderPartial('_confirm_delete',array('link' => $link));
    }


    /**
     * Changes order (for draggable items)
     */
    public function actionAjaxOrderItems()
    {
        //TODO: Разобраться с этим гребанным алогоритмом и добиться нормального изменения порядка...

        $ordersJson = Yii::app()->request->getParam('orders');
        $orders = json_decode($ordersJson,true);

        $previous = $orders['previous'];
        $new = $orders['new'];

        //swap all priorities
        foreach($previous as $index => $id)
        {
            Sort::SwapById($id,$new[$index],"MenuItem");
        }

        echo "OK";
    }

    /**
     * @param $id
     * @param int $ajax
     * @throws CHttpException
     */
    public function actionDeleteItem($id, $ajax = 0)
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

        if(!$ajax)
        {
            //back to listing items of menu
            $this->redirect(Yii::app()->createUrl('/admin/menu/menuitems',array('id' => $menu_id)));
        }
        else
        {
            echo "OK";
        }

    }
}