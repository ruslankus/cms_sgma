<?php
/**************************************************** P A G E S *******************************************************/
class ComplexController extends ControllerAdmin
{
    /**
     * List all pages
     * @param int $page
     */
    public function actionPages($page = 1)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.products.js',CClientScript::POS_END);

        $objects = ExtComplexPage::model()->findAll(array('order' => 'priority DESC'));

        $array = CPaginator::getInstance($objects,10,$page)->getPreparedArray();

        $this->render('list_items',array('items' => $array));
    }

    /**
     * Add one page
     */
    public function actionAdd()
    {

        //include menu necessary scripts
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.add-menu.css');
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.add-menu.ext.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //all languages
        $objLanguages = SiteLng::lng()->getLngs();
        //statuses
        $arrStatuses = ExtStatus::model()->arrayForNewsAndProducts(true);
        //templates
        $theme = 'dark'; //TODO: get theme from db
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'pages_complex');
        //form
        $form_mdl = new ComplexPageForm();

        //ajax validation
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
            if(isset($_POST['ComplexPageForm']))
            {
                $form_mdl->attributes = $_POST['ComplexPageForm'];

                if($form_mdl->validate())
                {
                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        $item = new ExtComplexPage();
                        $item -> attributes = $form_mdl->attributes;
                        $item -> time_updated = time();
                        $item -> time_created = time();
                        $item -> priority = Sort::GetNextPriority('ComplexPage');
                        $item -> last_change_by = Yii::app()->user->id;
                        $item -> save();

                        //translations
                        $titles = $_POST['ComplexPageForm']['titles'];

                        foreach($objLanguages as $language)
                        {
                            $itemTrl = new ComplexPageTrl();
                            $itemTrl -> title = $titles[$language->id];
                            $itemTrl -> lng_id = $language->id;
                            $itemTrl -> page_id = $item->id;
                            $itemTrl -> save();
                        }

                        $transaction->commit();

                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }

                    //back to list
                    $this->redirect(Yii::app()->createUrl('/admin/complex/pages'));
                }
            }
        }

        $this->render('add_page',array(
                'languages' => $objLanguages,
                'statuses' => $arrStatuses,
                'form_model' => $form_mdl,
                'templates' => $arrTemplates,
            )
        );
    }


    /**
     * Edit (not translatable content, labels, images and etc.)
     * @param $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //item
        $item = ExtComplexPage::model()->findByPk($id);

        if(empty($item))
        {
            throw new CHttpException(404);
        }

        //statuses
        $arrStatuses = ExtStatus::model()->arrayForNewsAndProducts(true);
        //templates
        $theme = 'dark'; //TODO: get theme from db
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'pages_complex');
        //form
        $form_mdl = new ComplexPageForm();


        //ajax validation
        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'edit-item-form')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
            if(isset($_POST['ComplexPageForm']))
            {
                $form_mdl -> attributes = $_POST['ComplexPageForm'];
                $form_mdl -> image = CUploadedFile::getInstance($form_mdl,'image');

                if($form_mdl->validate())
                {
                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {

                        $item->attributes = $form_mdl->attributes;
                        $item->time_updated = time();
                        $item->last_change_by = Yii::app()->user->id;
                        $item->update();

                        //if have image
                        if(!empty($form_mdl->image))
                        {
                            //new name for our image
                            $randomName = uniqid();

                            //if saved
                            if($form_mdl->image->saveAs(Image::UPLOAD_DIR.DS.$randomName.'.'.$form_mdl->image->extensionName))
                            {
                                //add image item to db (to site gallery)
                                $image = new ExtImages();
                                $image -> filename = $randomName.'.'.$form_mdl->image->extensionName;
                                $image -> original_filename = $form_mdl->image->name;
                                $image -> size = $form_mdl->image->size;
                                $image -> mime_type = $form_mdl->image->type;
                                $image -> label = 'Image of "'.$item->label.'"';
                                $image -> status_id = ExtStatus::VISIBLE;
                                $image -> save();

                                //relate added image with this news item
                                $imageOfComplexPage = new ImagesOfComplexPage();
                                $imageOfComplexPage -> page_id = $item->id;
                                $imageOfComplexPage -> image_id = $image->id;
                                $imageOfComplexPage -> save();
                            }
                        }

                        //commit changes
                        $transaction->commit();
                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }
                }
            }
        }

        //get all related images of item
        $images = array(null,null,null,null,null);

        foreach($item->imagesOfComplexPages as $index => $ioc)
        {
            if($index+1 <= count($images))
            {
                $images[$index] = $ioc;
            }
        }

        $this->render('edit_product_settings',array(
            'statuses' => $arrStatuses,
            'form_model' => $form_mdl,
            'item' => $item,
            'images' => $images,
            'templates' => $arrTemplates
        ));
    }

    /**
     * Deletes image
     * @param $id
     */
    public function actionDeleteImage($id)
    {
        ImagesOfComplexPage::model()->deleteByPk((int)$id);
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Delete page
     * @param $id
     * @param int $page
     */
    public function actionDelete($id,$page = 1)
    {
        /**
         * Just delete item and back to list
         */
        ExtComplexPage::model()->deleteByPk((int)$id);
        $this->redirect(Yii::app()->createUrl('admin/complex/pages',array('page' => $page)));
    }


    /**
     * Deleting by checkboxes
     * @param int $page
     */
    public function actionDeleteAll($page = 1)
    {
        $ids = array();
        $deleteIds = Yii::app()->request->getParam('delete',array());
        foreach($deleteIds as $id => $status)
        {
            $ids[] = $id;
        }

        ExtComplexPage::model()->deleteByPk($ids);

        $this->redirect(Yii::app()->createUrl('admin/complex/pages',array('page' => $page)));
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

        $groups = ExtComplexPageFieldGroups::model()->findAll(array('order' => 'priority DESC'));
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
        ExtComplexPageFieldGroups::model()->deleteByPk($id);

        if(Yii::app()->request->isAjaxRequest)
        {
            echo "OK";
            Yii::app()->end();
        }
        else
        {
            $this->redirect(Yii::app()->createUrl('admin/complex/attrgroups'));
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
                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        //menu item
                        $group = new ExtComplexPageFieldGroups();
                        $group -> label = $form_mdl->label;
                        $group -> time_updated = time();
                        $group -> time_created = time();
                        $group ->last_change_by = Yii::app()->user->id;
                        $group->priority = Sort::GetNextPriority("ExtComplexPageFieldGroups");
                        $group->save();

                        //translations
                        foreach($_POST['AttrGroupForm']['names'] as $lngId => $name)
                        {
                            $groupTrl = new ComplexPageFieldGroupsTrl();
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
                    $this->redirect(Yii::app()->createUrl('/admin/complex/attrgroups'));
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
        $group = ExtComplexPageFieldGroups::model()->findByPk($id);

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
                    $this->redirect(Yii::app()->createUrl('/admin/complex/attrgroups'));
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

        Sort::ReorderItems("ExtComplexPageFieldGroups",$previous,$new);

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

        $fieldGroup = ExtComplexPageFieldGroups::model()->findByPk($group);

        if(!empty($fieldGroup))
        {
            $fields = ExtComplexPageFields::model()->findAllByAttributes(array('group_id' => $group),array('order' => 'priority DESC'));
        }
        else
        {
            $fields = ExtComplexPageFields::model()->findAll(array('order' => 'priority DESC'));
        }

        $items = CPaginator::getInstance($fields,10,$page)->getPreparedArray();

        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_list_attr_fields',array('items' => $items, 'group' => $group, 'objGroup' => $fieldGroup));
        }
        else
        {
            $this->render('list_attr_fields',array('items' => $items, 'group' => $group, 'objGroup' => $fieldGroup));
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
        $arrTypes = ExtComplexPageFieldTypes::model()->arrayForMenuItemForm(true);
        //parents
        $arrGroupItems = ExtComplexPageFieldGroups::model()->arrayForMenuItemForm();

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
                        $field = new ExtComplexPageFields();
                        $field -> attributes = $form_mdl->attributes;
                        $field -> priority = Sort::GetNextPriority("ComplexPageFields",array('group_id' => $form_mdl->group_id));
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
                            $trl = new ComplexPageFieldsTrl();
                            $trl -> lng_id = $lngId;
                            $trl -> page_field_id = $field->id;
                            $trl -> field_title = $title;
                            $trl -> field_description = $descriptions[$lngId];
                            $trl -> save();
                        }

                        //variants for select box
                        if($field -> type_id = ExtComplexPageFieldTypes::TYPE_SELECTABLE)
                        {
                            $variants_names = $_POST['AttrFieldForm']['variants']['option_name'];
                            $variants_values = $_POST['AttrFieldForm']['variants']['option_value'];

                            foreach($variants_names as $index => $variant_name)
                            {
                                if($variant_name != '' && $variants_values[$index] != '')
                                {
                                    $variantForSelectBox = new ExtComplexPageFieldSelectOptions();
                                    $variantForSelectBox -> field_id = $field->id;
                                    $variantForSelectBox -> option_name = $variant_name;
                                    $variantForSelectBox -> option_value = $variants_values[$index];
                                    $variantForSelectBox -> save();
                                }
                            }
                        }

                        $transaction->commit();

                        $this->redirect(Yii::app()->createUrl('admin/complex/fields',array('group' => $field->group_id)));
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
        $field = ExtComplexPageFields::model()->findByPk($id);

        if(empty($field))
        {
            throw new CHttpException(404);
        }

        //all languages
        $objLanguages = SiteLng::lng()->getLngs();
        //statuses
        $arrTypes = ExtComplexPageFieldTypes::model()->arrayForMenuItemForm(true);
        //parents
        $arrGroupItems = ExtComplexPageFieldGroups::model()->arrayForMenuItemForm();
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
                            $field -> priority = Sort::GetNextPriority("ComplexPageFields",array('group_id' => $form_mdl->group_id));
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
                        ExtComplexPageFieldSelectOptions::model()->deleteAllByAttributes(array('field_id' => $field->id));

                        //add variants for select box
                        if($field -> type_id == ExtComplexPageFieldTypes::TYPE_SELECTABLE)
                        {
                            $variants_names = $_POST['AttrFieldForm']['variants']['option_name'];
                            $variants_values = $_POST['AttrFieldForm']['variants']['option_value'];

                            foreach($variants_names as $index => $variant_name)
                            {
                                if($variant_name != '' && $variants_values[$index] != '')
                                {
                                    $variantForSelectBox = new ExtComplexPageFieldSelectOptions();
                                    $variantForSelectBox -> field_id = $field->id;
                                    $variantForSelectBox -> option_name = $variant_name;
                                    $variantForSelectBox -> option_value = $variants_values[$index];
                                    $variantForSelectBox -> save();
                                }
                            }
                        }

                        $transaction->commit();

                        $this->redirect(Yii::app()->createUrl('admin/complex/fields',array('group' => $field->group_id)));
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

        Sort::ReorderItems("ComplexPageFields",$previous,$new);

        echo "OK";
    }

    /**
     * Delete attr group
     * @param $id
     */
    public function actionDelField($id)
    {
        ExtComplexPageFields::model()->deleteByPk($id);

        if(Yii::app()->request->isAjaxRequest)
        {
            echo "OK";
            Yii::app()->end();
        }
        else
        {
            $this->redirect(Yii::app()->createUrl('admin/complex/fields'));
        }
    }
}
