<?php
class ProductsController extends ControllerAdmin
{
    /******************************************* C A T E G O R I E S ***************************************************/
    /**
     * List all categories
     * @param int $page
     */
    public function actionCategories($page = 1)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.trees.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.main-menu.js',CClientScript::POS_END);

        $categories = ExtProductCategory::model()->rootGroups();
        $array = CPaginator::getInstance($categories,10,$page)->getPreparedArray();

        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_list_categories',array('items' => $array));
        }
        else
        {
            $this->render('list_categories',array('items' => $array));
        }
    }

    /**
     * Adding category
     */
    public function actionAddCat()
    {
        //include menu necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //all languages
        $objLanguages = SiteLng::lng()->getLngs();
        //statuses
        $arrStatuses = ExtStatus::model()->arrayForNewsAndProducts(true);
        //parents
        $arrParentItems = ExtProductCategory::model()->arrayForMenuItemForm();
        //templates
        $theme = 'dark'; //TODO: get theme from db
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'products'.DS.'category');

        //form
        $form_mdl = new CategoryForm();

        //ajax validation
        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'add-cat-form')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
            //if have form
            if($_POST['CategoryForm'])
            {
                $form_mdl->attributes = $_POST['CategoryForm'];

                if($form_mdl->validate())
                {
                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        //category
                        $category = new ExtProductCategory();
                        $category->attributes = $form_mdl->attributes;
                        $category->time_updated = time();
                        $category->time_created = time();
                        $category->last_change_by = Yii::app()->user->id;
                        $category->priority = Sort::GetNextPriority('ExtProductCategory',array('parent_id' => $form_mdl->parent_id));
                        $category->save();

                        //update branch (branch can be useful for breadcrumbs and item filtering by category)
                        $category->updateBranch();

                        //translations
                        $titles = $_POST['CategoryForm']['titles'];
                        $keywords = $_POST['CategoryForm']['keywords'];
                        $descriptions = $_POST['CategoryForm']['descriptions'];

                        foreach($titles as $lngId => $value)
                        {
                            $catTrl = new ProductCategoryTrl();
                            $catTrl -> header = $titles[$lngId];
                            $catTrl -> meta_description = $keywords[$lngId];
                            $catTrl -> description = $descriptions[$lngId];
                            $catTrl -> product_category_id = $category->id;
                            $catTrl -> lng_id = $lngId;
                            $catTrl -> save();
                        }

                        $transaction->commit();
                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }

                    //back to list
                    $this->redirect(Yii::app()->createUrl('/admin/products/categories'));
                }
            }
        }

        $this->render('add_category',array(
                'languages' => $objLanguages,
                'parent_items' => $arrParentItems,
                'statuses' => $arrStatuses,
                'form_model' => $form_mdl,
                'templates' => $arrTemplates
            )
        );
    }


    /**
     * Editing category
     * @param $id
     * @throws CHttpException
     */
    public function actionEditCat($id)
    {

        $category = ExtProductCategory::model()->findByPk($id);

        if(empty($category))
        {
            throw new CHttpException(404);
        }

        //include menu necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //all languages
        $objLanguages = SiteLng::lng()->getLngs();
        //statuses
        $arrStatuses = ExtStatus::model()->arrayForNewsAndProducts(true);
        //parents
        $arrParentItems = ExtProductCategory::model()->arrayForMenuItemForm();
        //templates
        $theme = 'dark'; //TODO: get theme from db
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'products'.DS.'category');

        //form
        $form_mdl = new CategoryForm();

        //ajax validation
        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'edit-cat-form')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
            //if have form
            if($_POST['CategoryForm'])
            {
                $form_mdl->attributes = $_POST['CategoryForm'];

                if($form_mdl->validate())
                {
                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        //category
                        $category->attributes = $form_mdl->attributes;
                        $category->time_updated = time();
                        $category->time_created = time();
                        $category->last_change_by = Yii::app()->user->id;
                        $category->priority = Sort::GetNextPriority('ExtProductCategory',array('parent_id' => $form_mdl->parent_id));
                        $category->update();

                        //update branch (branch can be useful for breadcrumbs and item filtering by category)
                        $category->updateBranch();

                        //translations
                        $titles = $_POST['CategoryForm']['titles'];
                        $keywords = $_POST['CategoryForm']['keywords'];
                        $descriptions = $_POST['CategoryForm']['descriptions'];

                        foreach($objLanguages as $language)
                        {
                            $catTrl = $category->getOrCreateTrl($language->id);
                            $catTrl -> header = $titles[$language->id];
                            $catTrl -> meta_description = $keywords[$language->id];
                            $catTrl -> description = $descriptions[$language->id];
                            $catTrl -> product_category_id = $category->id;
                            $catTrl -> lng_id = $language->id;

                            if($catTrl->isNewRecord)
                            {
                                $catTrl -> save();
                            }
                            else
                            {
                                $catTrl -> update();
                            }
                        }

                        $transaction->commit();
                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }

                    //back to list
                    $this->redirect(Yii::app()->createUrl('/admin/products/categories'));
                }
            }
        }

        $this->render('edit_category',array(
                'languages' => $objLanguages,
                'parent_items' => $arrParentItems,
                'statuses' => $arrStatuses,
                'form_model' => $form_mdl,
                'category' => $category,
                'templates' => $arrTemplates
            )
        );
    }


    /**
     * Changes order (for draggable items)
     */
    public function actionAjaxOrderCategories()
    {
        $ordersJson = Yii::app()->request->getParam('orders');
        $orders = json_decode($ordersJson,true);

        $previous = $orders['old'];
        $new = $orders['new'];

        Sort::ReorderItems("ExtProductCategory",$previous,$new);

        echo "OK";
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
        $objItem = ExtNewsCategory::model()->findByPk($id);

        ///if not found
        if(empty($objItem))
        {
            throw new CHttpException(404);
        }

        Sort::Move($objItem,$dir,'ExtProductCategory',array('parent_id' => $objItem->parent_id));

        if(!Yii::app()->request->isAjaxRequest)
        {
            //back to listing items
            $this->redirect(Yii::app()->createUrl('/admin/products/categories'));
        }
        else
        {
            echo "OK";
        }
    }

    /**
     * Deletes category from database
     * @param $id
     * @throws CHttpException
     */
    public function actionDeleteCat($id)
    {
        //find item of menu
        $objItem = ExtProductCategory::model()->findByPk($id);

        ///if not found
        if(empty($objItem))
        {
            throw new CHttpException(404);
        }

        $objItem->deleteChildren();
        $objItem->delete();

        if(!Yii::app()->request->isAjaxRequest)
        {
            //back to listing items
            $this->redirect(Yii::app()->createUrl('/admin/products/categories'));
        }
        else
        {
            echo "OK";
        }
    }

    /*********************************************** I T E M S ********************************************************/

    /**
     * List of all news
     * @param int $page
     * @param int $cat
     */
    public function actionList($page = 1, $cat = 0)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.trees.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.main-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.news.ext.css');

        $category = ExtProductCategory::model()->findByPk($cat);
        $breadCrumbs = array();

        if(!empty($category))
        {
            $objects = ExtProduct::model()->findAllByAttributes(array('category_id' => (int)$cat),array('order' => 'priority DESC'));
            $breadCrumbs = $category->breadCrumbs(false);
        }
        else
        {
            $objects = ExtProduct::model()->findAll(array('order' => 'priority DESC'));
        }

        $array = CPaginator::getInstance($objects,10,$page)->getPreparedArray();

        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_list_items',array('items' => $array, 'category' => $cat));
        }
        else
        {
            $this->render('list_items',array('items' => $array,'category' => $cat, 'breadcrumbs' => $breadCrumbs));
        }
    }


    /******************************** A T T R I B U T E S : G R O U P S ***********************************************/

    /**
     * List all groups
     * @param int $page
     */
    public function actionAttrGroups($page = 1)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.trees.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.main-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.news.ext.css');

        $groups = ExtProductFieldGroups::model()->findAll(array('order' => 'priority DESC'));
        $items = CPaginator::getInstance($groups,10,$page)->getPreparedArray();

        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_list_attr_groups',array('items' => $items));
        }
        else
        {
            $this->render('list_attr_groups',array('items' => $items));
        }
        
    }

    /**
     * Delete attr group
     * @param $id
     */
    public function actionDelAttrGroup($id)
    {
        ExtProductFieldGroups::model()->deleteByPk($id);

        if(Yii::app()->request->isAjaxRequest)
        {
            echo "OK";
            Yii::app()->end();
        }
        else
        {
            $this->redirect(Yii::app()->createUrl('admin/products/attrgroups'));
        }
    }

    /**
     * Add attribute group
     */
    public function actionAddAttrGroup()
    {

        //include menu necessary scripts
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.add-menu.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //form
        $form_mdl = new AttrGroupForm();
        $languages = SiteLng::lng()->getLngs();

        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'add-group-form')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
            //if have form
            if(isset($_POST['AttrGroupForm']))
            {
                $form_mdl->attributes = $_POST['AttrGroupForm'];

                if($form_mdl->validate())
                {
                    /* @var $parent ExtMenuItem */

                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        //menu item
                        $group = new ExtProductFieldGroups();
                        $group -> label = $form_mdl->label;
                        $group -> time_updated = time();
                        $group -> time_created = time();
                        $group ->last_change_by = Yii::app()->user->id;
                        $group->priority = Sort::GetNextPriority("ProductFieldGroups");
                        $group->save();

                        //translations
                        foreach($_POST['AttrGroupForm']['names'] as $lngId => $name)
                        {
                            $groupTrl = new ProductFieldGroupsTrl();
                            $groupTrl -> name = $name;
                            $groupTrl -> description = $_POST['AttrGroupForm']['descriptions'][$lngId];
                            $groupTrl -> lng_id = $lngId;
                            $groupTrl -> group_id = $group->id;
                            $groupTrl -> save();
                        }

                        $transaction->commit();
                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }

                    //back to list
                    $this->redirect(Yii::app()->createUrl('/admin/products/attrgroups'));
                }
            }
        }

        $this->render('add_attribute_group',array('form_mdl' => $form_mdl, 'languages' => $languages));
    }

    /**
     * Editing group of attributes
     * @param $id
     * @throws CHttpException
     */
    public function actionEditAttrGroup($id)
    {
        //include menu necessary scripts
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.add-menu.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //form
        $form_mdl = new AttrGroupForm();
        $languages = SiteLng::lng()->getLngs();
        $group = ExtProductFieldGroups::model()->findByPk($id);

        if(empty($group))
        {
            throw new CHttpException(404);
        }

        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'add-group-form')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
            //if have form
            if(isset($_POST['AttrGroupForm']))
            {
                $form_mdl->attributes = $_POST['AttrGroupForm'];

                if($form_mdl->validate())
                {
                    /* @var $parent ExtMenuItem */

                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        $group -> label = $form_mdl->label;
                        $group -> time_updated = time();
                        $group -> time_created = time();
                        $group ->last_change_by = Yii::app()->user->id;
                        $group->priority = Sort::GetNextPriority("ProductFieldGroups");
                        $group->save();

                        //translations
                        foreach($_POST['AttrGroupForm']['names'] as $lngId => $name)
                        {
                            $groupTrl = $group->getOrCreateTrl($lngId);
                            $groupTrl -> name = $name;
                            $groupTrl -> description = $_POST['AttrGroupForm']['descriptions'][$lngId];

                            if($groupTrl->isNewRecord)
                            {
                                $groupTrl -> save();
                            }
                            else
                            {
                                $groupTrl->update();
                            }
                        }

                        $transaction->commit();
                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }

                    //back to list
                    $this->redirect(Yii::app()->createUrl('/admin/products/attrgroups'));
                }
            }
        }

        $this->render('edit_attribute_group',array('form_mdl' => $form_mdl, 'languages' => $languages, 'group' => $group));
    }

    /**
     * Ordering with drg-n-drop
     */
    public function actionAjaxOrderAttrGroups()
    {
        $ordersJson = Yii::app()->request->getParam('orders');
        $orders = json_decode($ordersJson,true);

        $previous = $orders['old'];
        $new = $orders['new'];

        Sort::ReorderItems("ProductFieldGroups",$previous,$new);

        echo "OK";
    }

    /******************************** A T T R I B U T E S : F I E L D S ***********************************************/


    /**
     * List all fields of specified group
     * @param int $page
     * @param $group
     */
    public function actionFields($page = 1, $group = 0)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.trees.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.main-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.news.ext.css');

        $fieldGroup = ExtProductFieldGroups::model()->findByPk($group);

        if(!empty($fieldGroup))
        {
            $fields = ExtProductFields::model()->findAllByAttributes(array('group_id' => $group),array('order' => 'priority DESC'));
        }
        else
        {
            $fields = ExtProductFields::model()->findAll(array('order' => 'priority DESC'));
        }

        $items = CPaginator::getInstance($fields,10,$page)->getPreparedArray();

        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_list_attr_fields',array('items' => $items, 'group' => $group));
        }
        else
        {
            $this->render('list_attr_fields',array('items' => $items, 'group' => $group));
        }
    }

    /**
     * Add attribute-field
     * @param int $group
     */
    public function actionAddField($group = 0)
    {
        //include menu necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-field.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //all languages
        $objLanguages = SiteLng::lng()->getLngs();
        //statuses
        $arrTypes = ExtProductFieldTypes::model()->arrayForMenuItemForm(true);
        //parents
        $arrGroupItems = ExtProductFieldGroups::model()->arrayForMenuItemForm();

        //form
        $form_mdl = new AttrFieldForm();

        //ajax validation
        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'add-field-form')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
            if(isset($_POST['AttrFieldForm']))
            {
                $form_mdl->attributes = $_POST['AttrFieldForm'];

                if($form_mdl->validate())
                {

                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        //create field
                        $field = new ExtProductFields();
                        $field -> attributes = $form_mdl->attributes;
                        $field -> priority = Sort::GetNextPriority("ProductFields",array('group_id' => $form_mdl->group_id));
                        $field -> time_created = time();
                        $field -> time_updated = time();
                        $field -> last_change_by = Yii::app()->user->id;
                        $field -> save();

                        //translatable
                        $titles = $_POST['AttrFieldForm']['field_titles'];
                        $descriptions = $_POST['AttrFieldForm']['field_descriptions'];


                        //create translations
                        foreach($titles as $lngId => $title)
                        {
                            $trl = new ProductFieldsTrl();
                            $trl -> lng_id = $lngId;
                            $trl -> product_field_id = $field->id;
                            $trl -> field_title = $title;
                            $trl -> field_description = $descriptions[$lngId];
                            $trl -> save();
                        }

                        //variants for select box
                        if($field -> type_id = ExtProductFieldTypes::TYPE_SELECTABLE)
                        {
                            $variants_names = $_POST['AttrFieldForm']['variants']['option_name'];
                            $variants_values = $_POST['AttrFieldForm']['variants']['option_value'];

                            foreach($variants_names as $index => $variant_name)
                            {
                                if($variant_name != '' && $variants_values[$index] != '')
                                {
                                    $variantForSelectBox = new ExtProductFieldSelectOptions();
                                    $variantForSelectBox -> field_id = $field->id;
                                    $variantForSelectBox -> option_name = $variant_name;
                                    $variantForSelectBox -> option_value = $variants_values[$index];
                                    $variantForSelectBox -> save();
                                }
                            }
                        }

                        $transaction->commit();

                        $this->redirect(Yii::app()->createUrl('admin/products/fields',array('group' => $field->group_id)));
                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }
                }
            }
        }

        //render form
        $this->render('add_attribute_field',array(
            'languages' => $objLanguages,
            'types' => $arrTypes,
            'groups' => $arrGroupItems,
            'group' => $group,
            'form_mdl' => $form_mdl
        ));
    }

    /**
     * Edit attribute-field
     * @param $id
     * @throws CHttpException
     */
    public function actionEditField($id)
    {
        //include menu necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-field.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //field item
        $field = ExtProductFields::model()->findByPk($id);

        if(empty($field))
        {
            throw new CHttpException(404);
        }

        //all languages
        $objLanguages = SiteLng::lng()->getLngs();
        //statuses
        $arrTypes = ExtProductFieldTypes::model()->arrayForMenuItemForm(true);
        //parents
        $arrGroupItems = ExtProductFieldGroups::model()->arrayForMenuItemForm();
        //form
        $form_mdl = new AttrFieldForm();

        //ajax validation
        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'edit-field-form')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
            if(isset($_POST['AttrFieldForm']))
            {
                $form_mdl->attributes = $_POST['AttrFieldForm'];

                if($form_mdl->validate())
                {
                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        //do we need recalculate priority
                        $needChangePriority = $form_mdl->group_id != $field->group_id;

                        //update field
                        $field -> attributes = $form_mdl->attributes;

                        if($needChangePriority)
                        {
                            $field -> priority = Sort::GetNextPriority("ProductFields",array('group_id' => $form_mdl->group_id));
                        }

                        $field -> time_updated = time();
                        $field -> last_change_by = Yii::app()->user->id;
                        $field -> update();

                        //translatable
                        $titles = $_POST['AttrFieldForm']['field_titles'];
                        $descriptions = $_POST['AttrFieldForm']['field_descriptions'];


                        //update translations
                        foreach($titles as $lngId => $title)
                        {
                            $trl = $field->getOrCreateTrl($lngId);
                            $trl -> field_title = $title;
                            $trl -> field_description = $descriptions[$lngId];

                            if($trl->isNewRecord)
                            {
                                $trl->save();
                            }
                            else
                            {
                                $trl->update();
                            }
                        }

                        //clear all fields selectable variants
                        ExtProductFieldSelectOptions::model()->deleteAllByAttributes(array('field_id' => $field->id));

                        //add variants for select box
                        if($field -> type_id = ExtProductFieldTypes::TYPE_SELECTABLE)
                        {
                            $variants_names = $_POST['AttrFieldForm']['variants']['option_name'];
                            $variants_values = $_POST['AttrFieldForm']['variants']['option_value'];

                            foreach($variants_names as $index => $variant_name)
                            {
                                if($variant_name != '' && $variants_values[$index] != '')
                                {
                                    $variantForSelectBox = new ExtProductFieldSelectOptions();
                                    $variantForSelectBox -> field_id = $field->id;
                                    $variantForSelectBox -> option_name = $variant_name;
                                    $variantForSelectBox -> option_value = $variants_values[$index];
                                    $variantForSelectBox -> save();
                                }
                            }
                        }

                        $transaction->commit();

                        $this->redirect(Yii::app()->createUrl('admin/products/fields',array('group' => $field->group_id)));
                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }
                }
            }
        }


        //render form
        $this->render('edit_attribute_field',array(
            'languages' => $objLanguages,
            'types' => $arrTypes,
            'groups' => $arrGroupItems,
            'group' => $field->group_id,
            'form_mdl' => $form_mdl,
            'field' => $field
        ));
    }

    /**
     * Ordering with drg-n-drop
     */
    public function actionAjaxOrderFields()
    {
        $ordersJson = Yii::app()->request->getParam('orders');
        $orders = json_decode($ordersJson,true);

        $previous = $orders['old'];
        $new = $orders['new'];

        Sort::ReorderItems("ProductFields",$previous,$new);

        echo "OK";
    }


    /**
     * Delete attr group
     * @param $id
     */
    public function actionDelField($id)
    {
        ExtProductFields::model()->deleteByPk($id);

        if(Yii::app()->request->isAjaxRequest)
        {
            echo "OK";
            Yii::app()->end();
        }
        else
        {
            $this->redirect(Yii::app()->createUrl('admin/products/fields'));
        }
    }



}