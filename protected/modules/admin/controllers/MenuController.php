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
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.menu-list.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');


        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //menu form
        $form_mdl = new MenuForm();
        //currently selected theme
        $selectedTheme = $this->currentThemeName;
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
            if($_POST['MenuForm'])
            {
                $form_mdl->attributes = $_POST['MenuForm'];

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

        $perPage = ExtSettings::model()->getSetting('per_page',10,true);
        $array = CPaginator::getInstance($menus,$perPage,$page)->getPreparedArray();

        $this->render('list_menu',array('menus' => $array,'form_params' => $form_params));
    }

    /**
     * Edit and update menu
     * @param $id
     * @throws CHttpException
     */
    public function actionEditMenu($id)
    {
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.edit-menu-instance.css');

        //find menu
        $menu = ExtMenu::model()->findByPk((int)$id);

        //if not found
        if(empty($menu))
        {
            throw new CHttpException(404);
        }

        //menu form
        $form_mdl = new MenuForm();
        //currently selected theme
        $selectedTheme = $this->currentThemeName;
        //get all templates for menus
        $templates = ThemeHelper::getTemplatesForMenu($selectedTheme);
        //statuses
        $statuses = ExtStatus::model()->arrayForMenuForm(true);

        //if have form
        if($_POST['MenuForm'])
        {
            $form_mdl->attributes = $_POST['MenuForm'];

            if($form_mdl->validate())
            {
                $menu->attributes = $form_mdl->attributes;
                $menu->time_updated = time();
                $menu->last_change_by = Yii::app()->user->getState('id');
                $menu->update();

                //back to list
                $this->redirect(Yii::app()->createUrl('admin/menu/list'));
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
        //delete
        ExtMenu::model()->deleteByPk((int)$id);

        //back to list
        $this->redirect(Yii::app()->createUrl('admin/menu/list'));
    }


    /******************************************* M E N U  I T E M *****************************************************/


    /**
     * List all items of menu
     * @param $id
     * @param int $pid
     * @param int $page
     * @throws CHttpException
     */
    public function actionMenuItems($id,$pid = 0,$page = 1)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.trees.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.main-menu.js',CClientScript::POS_END);

        //find menu
        $menu = ExtMenu::model()->findByPk((int)$id);
        $parent = ExtMenuItem::model()->findByPk((int)$pid);
        $breadcrumbs = array();

        if(!empty($parent))
        {
            $breadcrumbs = $parent->buildBreadCrumbs();
        }

        //if not found
        if(empty($menu))
        {
            throw new CHttpException(404);
        }

        //get all items
        $items = $menu->buildObjArrRecursive($pid);
        $items = ExtMenu::model()->divideToRootGroups($items,$pid);

        $perPage = ExtSettings::model()->getSetting('per_page',10,true);
        $array = CPaginator::getInstance($items,$perPage,$page)->getPreparedArray();

        
        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_list_menu_items',array('items' => $array,'menu' => $menu, 'parent_id' => $pid));
        }
        else
        {
            $this->render('list_menu_items',array('items' => $array,'menu' => $menu, 'parent_id' => $pid, 'breadcrumbs' => $breadcrumbs));
        }
    }

    /**
     * Add new menu item and create it in database
     * @param $id
     */
    public function actionAddMenuItem($id)
    {
        //include menu necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //all languages
        $objLanguages = SiteLng::lng()->getLngs();
        //current menu
        $objMenu = ExtMenu::model()->findByPk($id);
        //get all menu items in menu of current item (for parent selection)
        $arrParentItems = $objMenu->arrayForMenuItemForm();
        //statuses
        $arrStatuses = ExtStatus::model()->arrayForMenuForm(true);
        //types
        $arrTypes = ExtMenuItemType::model()->arrayForMenuItemForm(true);
        //content items by type (first type)
        $objFirstType = ExtMenuItemType::model()->find();
        $objConItems = !empty($objFirstType) ? $this->getContentsByType($objFirstType) : array();

        //form
        $form_mdl = new MenuItemForm();


        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'add-item-form')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
            //if have form
            if($_POST['MenuItemForm'])
            {
                $form_mdl->attributes = $_POST['MenuItemForm'];

                if($form_mdl->validate())
                {
                    /* @var $parent ExtMenuItem */

                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        //menu item
                        $menuItem = new ExtMenuItem();
                        $menuItem->attributes = $form_mdl->attributes;
                        $menuItem->time_updated = time();
                        $menuItem->time_created = time();
                        $menuItem->last_change_by = Yii::app()->user->id;
                        $menuItem->priority = Sort::GetNextPriority('MenuItem',array('parent_id' => $form_mdl->parent_id, 'menu_id' => $form_mdl->menu_id));
                        $menuItem->save();

                        //translations
                        foreach($_POST['MenuItemForm']['titles'] as $lngId => $title)
                        {
                            $menuItemTrl = new MenuItemTrl();
                            $menuItemTrl->menu_item_id = $menuItem -> id;
                            $menuItemTrl->lng_id = $lngId;
                            $menuItemTrl->value = $title;
                            $menuItemTrl->save();
                        }

                        $transaction->commit();
                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }

                    //back to list
                    $this->redirect(Yii::app()->createUrl('/admin/menu/menuitems',array('id' => $objMenu->id)));
                }
            }
        }

        $this->render('add_menu_item',array(
            'languages' => $objLanguages,
            'parent_items' => $arrParentItems,
            'statuses' => $arrStatuses,
            'types' => $arrTypes,
            'form_model' => $form_mdl,
            'menu' => $objMenu,
            'content_items' => $objConItems,
            'first_type' => $objFirstType
            )
        );
    }


    /**
     * Edit menu item and update it
     * @param $id
     */
    public function actionEditMenuItem($id)
    {
        //include menu necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //all languages
        $objLanguages = SiteLng::lng()->getLngs();
        //menu item
        $menuItem = ExtMenuItem::model()->findByPk($id);
        //current menu
        $objMenu = $menuItem->menu;
        //get all menu items in menu of current item (for parent selection)
        $objParentItems = $objMenu->buildObjArrRecursive();
        //statuses
        $arrStatuses = ExtStatus::model()->arrayForMenuForm(true);
        //types
        $arrTypes = ExtMenuItemType::model()->arrayForMenuItemForm(true);
        //content items by type (first type)
        $objFirstType = ExtMenuItemType::model()->findByPk($menuItem->type_id);
        $objConItems = !empty($objFirstType) ? $this->getContentsByType($objFirstType) : array();

        //form
        $form_mdl = new MenuItemForm();

        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'add-item-form')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
            //if have form
            if($_POST['MenuItemForm'])
            {
                $form_mdl->attributes = $_POST['MenuItemForm'];

                if($form_mdl->validate())
                {
                    /* @var $parent ExtMenuItem */

                    //do we need to recalculate priority
                    $bNewPriority = $menuItem->parent_id != $form_mdl->parent_id;

                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    //try to update
                    try
                    {
                        //menu item
                        $menuItem->attributes = $form_mdl->attributes;
                        $menuItem->time_updated = time();
                        $menuItem->last_change_by = Yii::app()->user->id;

                        if($bNewPriority)
                        {
                            $menuItem->priority = Sort::GetNextPriority('MenuItem',array('parent_id' => $form_mdl->parent_id, 'menu_id' => $form_mdl->menu_id));
                        }

                        $menuItem->update();

                        //translations
                        foreach($_POST['MenuItemForm']['titles'] as $lngId => $title)
                        {
                            //try find translation
                            $menuItemTrl = MenuItemTrl::model()->findByAttributes(array('lng_id' => $lngId, 'menu_item_id' => $menuItem->id));

                            //if not found - create
                            if(empty($menuItemTrl))
                            {
                                $menuItemTrl = new MenuItemTrl();
                            }

                            $menuItemTrl->menu_item_id = $menuItem -> id;
                            $menuItemTrl->lng_id = $lngId;
                            $menuItemTrl->value = $title;

                            //save or update
                            if($menuItemTrl->isNewRecord)
                            {
                                $menuItemTrl->save();
                            }
                            else
                            {
                                $menuItemTrl->update();
                            }

                        }

                        $transaction->commit();

                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }


                    //back to list
                    $this->redirect(Yii::app()->createUrl('/admin/menu/menuitems',array('id' => $objMenu->id)));
                }
            }
        }

        $this->render('edit_menu_item',array(
                'languages' => $objLanguages,
                'parent_items' => $objParentItems,
                'statuses' => $arrStatuses,
                'types' => $arrTypes,
                'form_model' => $form_mdl,
                'menu' => $objMenu,
                'content_items' => $objConItems,
                'first_type' => $objFirstType,
                'menuItem' => $menuItem,
            )
        );
    }

    /**
     * Returns all content items by menu item type
     * @param $type ExtMenuItemType
     * @return ExtPage[]|ExtNewsCategory[]|ExtProductCategory[]|array
     */
    private function getContentsByType($type)
    {
        $objItems = array();

        if(!empty($type))
        {
            switch($type->id)
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
                    $objItems = ExtContactsPage::model()->findAll();
                    break;

                case ExtMenuItemType::TYPE_COMPLEX_PAGE:
                    $objItems = ExtComplexPage::model()->findAll(array('order' => 'priority DESC'));
                    break;

                default:
                    $objItems = array();
                    break;

            }
        }

        return $objItems;
    }

    /************************************* A J A X  S E C T I O N *****************************************************/
    /**
     * Loads list of available content items by type
     * @param int $id
     * @param null $selected
     */
    public function actionAjaxContentItemsByType($id = ExtMenuItemType::TYPE_SINGLE_PAGE, $selected = null)
    {
        $type = ExtMenuItemType::model()->findByPk($id);
        $objItems = $this->getContentsByType($type);
        $this->renderPartial('_ajax_content_items',array('objContentItems' => $objItems, 'type' => $type, 'selected' => $selected));
    }


    /**
     * Returns created link
     * @param $id
     * @param $type
     * @param $obj
     * @throws CHttpException
     */
    public function actionAjaxCreateUrlFor($id,$type,$obj)
    {
        $menuItem = ExtMenuItem::model()->findByPk($id);

        if(empty($menuItem))
        {
            throw new CHttpException(404);
        }

        $url = $menuItem->getUrl(true,'show',(int)$type,(int)$obj);
        echo $url;
    }


    /**
     * Changes order (for draggable items)
     */
    public function actionAjaxOrderItems()
    {
        $ordersJson = Yii::app()->request->getParam('orders');
        $orders = json_decode($ordersJson,true);

        $previous = $orders['old'];
        $new = $orders['new'];

        Sort::ReorderItems("ExtMenuItem",$previous,$new);

        echo "OK";
    }

    /**
     * Deletes item form db
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

        $objItem->deleteChildren();
        $objItem->delete();

        if(!Yii::app()->request->isAjaxRequest)
        {
            //back to listing items of menu
            $this->redirect(Yii::app()->createUrl('/admin/menu/menuitems',array('id' => $menu_id)));
        }
        else
        {
            echo "OK";
        }
    }

    /**
     * Move item's priority
     * @param int $id
     * @param string $dir
     * @throws CHttpException
     */
    public function actionMove($id, $dir)
    {
        //find item of menu
        $objItem = ExtMenuItem::model()->findByPk($id);

        ///if not found
        if(empty($objItem))
        {
            throw new CHttpException(404);
        }

        Sort::Move($objItem,$dir,'ExtMenuItem',array('parent_id' => $objItem->parent_id,'menu_id' => $objItem->menu_id));

        if(!Yii::app()->request->isAjaxRequest)
        {
            //back to listing items of menu
            $this->redirect(Yii::app()->createUrl('/admin/menu/menuitems',array('id' => $objItem->menu_id)));
        }
        else
        {
            echo "OK";
        }

    }
}