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

        $objects = ExtComplexPage::model()->findAll(array('order' => 'priority ASC'));

        $perPage = ExtSettings::model()->getSetting('per_page',10,true);
        $array = CPaginator::getInstance($objects,$perPage,$page)->getPreparedArray();

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
        $theme = $this->arrSettings['active_desktop_theme'];
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'complex');
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
        $theme = $this->arrSettings['active_desktop_theme'];
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'complex');
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

        $this->render('edit_page_settings',array(
            'statuses' => $arrStatuses,
            'form_model' => $form_mdl,
            'item' => $item,
            'images' => $images,
            'templates' => $arrTemplates
        ));
    }


    /**
     * Edit translatable part of content
     * @param $id
     * @param null $lng
     * @throws CHttpException
     */
    public function actionEditItemTrl($id,$lng = null)
    {
        /* @var $item ExtComplexPage */

        //include menu necessary css and js
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.edit-page-content.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-news-content.js',CClientScript::POS_END);

        //fin news item by PK
        $item = ExtComplexPage::model()->findByPk($id);

        //if item not found - 404
        if(empty($item))
        {
            throw new CHttpException(404);
        }

        //get all site languages
        $objLanguages = SiteLng::lng()->getLngs();

        //if languages not found
        if(count($objLanguages) == 0)
        {
            //redirect to editing of not translatable part
            $this->redirect(Yii::app()->createUrl('admin/complex/edit',array('id' => $id)));
        }

        //if should update (etc. by AJAX)
        if(isset($_POST['ComplexPageFormTrl']))
        {
            //foreach every language id
            foreach($_POST['ComplexPageFormTrl'] as $lngId => $fields)
            {
                $lng = $lngId; //set current language id
                $trl = $item->getOrCreateTrl($lngId); // get TRL object (or create in not found in DB)

                //set values
                $trl->title = $fields['title'];
                $trl->meta_keywords = $fields['keywords'];
                $trl->text = $fields['text'];

                //if record just created
                if($trl->isNewRecord)
                {
                    //save
                    $trl->save();
                }
                //if record has ben already in DB
                else
                {
                    //update
                    $trl->update();
                }
            }
        }

        //current language (if set - find it by PK, if not set - get first from array)
        $objCurrentLng = $lng != null ? Languages::model()->findByPk((int)$lng) : $objLanguages[0];

        //translation of item for this language
        $trl = $item->getOrCreateTrl($objCurrentLng->id);

        //render partial block (for AJAX requests)
        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_edit_page_content',array(
                'item' => $item,
                'languages' => $objLanguages,
                'currentLng' => $objCurrentLng,
                'itemTrl' => $trl,
            ));
        }
        //render simple
        else
        {
            $this->render('edit_page_content',array(
                'item' => $item,
                'languages' => $objLanguages,
                'currentLng' => $objCurrentLng,
                'itemTrl' => $trl,
            ));
        }
    }


    /**
     * Select and deselect which groups of attributes you want in complex page to be displayed
     * @param $id
     * @throws CHttpException
     */
    public function actionEditPageAttrGroup($id)
    {
        //product item
        $page = ExtComplexPage::model()->findByPk((int)$id);

        if(empty($page))
        {
            throw new CHttpException(404);
        }

        //if checked any checkbox
        if(Yii::app()->request->isPostRequest)
        {
            ExtComplexPageFieldGroupsActive::model()->deleteAllByAttributes(array('page_id' => $page->id));

            if(isset($_POST['active']))
            {
                $active = $_POST['active'];

                foreach($active as $iid => $status)
                {
                    $group = ExtComplexPageFieldGroups::model()->findByPk($iid);

                    if(!empty($group))
                    {
                        $active = new ExtComplexPageFieldGroupsActive();
                        $active -> page_id = $page->id;
                        $active -> group_id = $iid;
                        $active -> priority = $group->priority;
                        $active -> save();
                    }

                }
            }
        }

        //all field groups
        $allGroups = ExtComplexPageFieldGroups::model()->findAll(array('order' => 'priority ASC'));

        //active id's
        $activeGroupIds = array();

        //get active id's
        foreach($page->complexPageFieldGroupsActives as $active)
        {
            $activeGroupIds[] = $active->group_id;
        }

        //render
        $this->render('edit_page_attr_groups',
            array(
                'item' => $page,
                'groups' => $allGroups,
                'active_ids' => $activeGroupIds)
        );


    }


    /**
     * Edit values of attribute-fields
     * @param $id
     * @throws CHttpException
     */
    public function actionEditPageFields($id)
    {
        //include menu necessary scripts
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/jquery-ui.min.css');
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.dynamic-fields.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.dynamic-fields.js',CClientScript::POS_END);

        //product item
        $page = ExtComplexPage::model()->findByPk((int)$id);

        if(empty($page))
        {
            throw new CHttpException(404);
        }

        //languages
        $languages = SiteLng::lng()->getLngs();

        //all selected groups of this item
        $attributeGroupsOfPage = $page->complexPageFieldGroupsActives;

        //if have POST request
        if(isset($_POST['DynamicFields']))
        {
            //get all dynamic field data
            $fieldData = $_POST['DynamicFields'];

            //use transaction
            $con = Yii::app()->db;
            $transaction = $con->beginTransaction();

            try
            {
                foreach ($fieldData as $fieldId => $valueData)
                {
                    $field = ExtComplexPageFields::model()->findByPk($fieldId);
                    switch($field->type_id)
                    {
                        case ExtProductFieldTypes::TYPE_NUMERIC;
                            $value = $field->getValueObjForItem($page->id);
                            $value -> numeric_value = $valueData;
                            $value -> saveOrUpdate();
                            break;

                        case ExtProductFieldTypes::TYPE_TEXT:
                            $value = $field->getValueObjForItem($page->id);
                            $value -> text_value = $valueData;
                            $value -> saveOrUpdate();
                            break;

                        case ExtProductFieldTypes::TYPE_TRL_TEXT:
                            $value = $field->getValueObjForItem($page->id);
                            $value -> saveOrUpdate();

                            foreach($valueData as $lngId => $trlData)
                            {
                                $trl = $value->getOrCreateTrl($lngId);
                                $trl -> translatable_text = $trlData;
                                $saved = $trl -> isNewRecord ? $trl->save() : $trl->update();
                            }
                            break;

                        case ExtProductFieldTypes::TYPE_SELECTABLE:
                            $value = $field->getValueObjForItem($page->id);
                            $value -> selected_option_id = (int)$valueData;
                            $value -> saveOrUpdate();
                            break;

                        case ExtProductFieldTypes::TYPE_DATE:
                            $value = $field->getValueObjForItem($page->id);

                            $dt = DateTime::createFromFormat('m/d/Y', $valueData);
                            $time = $dt -> getTimestamp();

                            $value -> time_value = $time;
                            $value -> saveOrUpdate();
                            break;

                        default:
                            //do nothing
                            break;
                    }
                }

                $transaction->commit();
            }
            catch(Exception $ex)
            {
                $transaction->rollback();
            }
        }

        if(Yii::app()->request->isAjaxRequest)
        {
            echo "OK";
            Yii::app()->end();
        }
        else
        {
            //render form
            $this->render('edit_page_attr_values',
                array(
                    'active' => $attributeGroupsOfPage,
                    'item' => $page,
                    'languages' => $languages
                ));
        }

    }

    /**
     * Just list images in partial image-selection-box
     * @throws CHttpException
     */
    public function actionListImagesBox()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $images = ExtImages::model()->findAll();
            $this->renderPartial('_list_images_in_box',array('objPhotos' => $images));
        }
        else
        {
            throw new CHttpException(404);
        }
    }


    /**
     * Assign image to value for image-type field of page
     * @param $id
     * @param $fid
     * @param $iid
     * @throws CHttpException
     */
    public function actionAssignFieldImage($id,$fid,$iid)
    {
        //just found all necessary records in db
        $field = ExtComplexPageFields::model()->findByPk((int)$fid);
        $item = ExtComplexPage::model()->findByPk((int)$id);
        $image = ExtImages::model()->findByPk((int)$iid);

        //if something not found
        if(empty($field) || empty($item) || empty($image))
        {
            throw new CHttpException(404);
        }

        //get value of item's field
        $value = $field->getValueObjForItem((int)$id);

        //if value is new - save it
        if($value->isNewRecord)
        {
            $value->save();
        }

        //get all image-relations of this value (probably value already has them)
        $imagesOfValue = $value->imagesOfComplexPageFieldValues;

        //if found some image-relations
        if(count($imagesOfValue) > 0)
        {
            //delete them all (this field can have only one image)
            ExtImagesOfComplexPageFieldValues::model()->deleteAllByAttributes(array('field_value_id' => $value->id));
        }

        //relate field value with image
        $imageOf = new  ExtImagesOfComplexPageFieldValues();
        $imageOf -> field_value_id = $value->id;
        $imageOf -> image_id = $image->id;
        $imageOf -> save();

        //OK for ajax - redirect for standard request
        if(Yii::app()->request->isAjaxRequest)
        {
            echo $imageOf->id;
        }
        else
        {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }


    /**
     * Uploads an image via ajax and assigns image to value of field
     * @param $id
     * @param $fid
     * @throws CHttpException
     */
    public function actionUploadFieldImage($id,$fid)
    {
        $complexPage = ExtComplexPage::model()->findByPk((int)$id);
        $complexPageFiled = ExtComplexPageFields::model()->findByPk((int)$fid);

        if(empty($complexPage) || empty($complexPageFiled))
        {
           throw new CHttpException(404);
        }

        //get image instance
        $imageFromRequest = CUploadedFile::getInstanceByName('field_image');
        $validation = new MediaUploadFormValidation();
        $validation->image = $imageFromRequest;

        //if image is correct
        if($validation->validate())
        {
            //new name for our image
            $randomName = uniqid();

            //if saved
            if($validation->image->saveAs(Image::UPLOAD_DIR.DS.$randomName.'.'.$validation->image->extensionName))
            {
                //use transaction
                $con = Yii::app()->db;
                $transaction = $con->beginTransaction();

                try
                {
                    //add image item to db (to site gallery)
                    $image = new ExtImages();
                    $image -> filename = $randomName.'.'.$validation->image->extensionName;
                    $image -> original_filename = $validation->image->name;
                    $image -> size = $validation->image->size;
                    $image -> mime_type = $validation->image->type;
                    $image -> label = 'Image of "'.$complexPageFiled->field_name.'" field value of page "'.$complexPage->label.'"';
                    $image -> status_id = ExtStatus::VISIBLE;
                    $image -> save();

                    //get value
                    $value = $complexPageFiled->getValueObjForItem($complexPage->id);

                    if($value->isNewRecord)
                    {
                        $value->save();
                    }

                    //clean all old images
                    ExtImagesOfComplexPageFieldValues::model()->deleteAllByAttributes(array('field_value_id' => $value->id));

                    //add new relation
                    $iof = new ExtImagesOfComplexPageFieldValues();
                    $iof -> image_id = $image->id;
                    $iof -> field_value_id = $value->id;
                    $iof -> save();

                    //apply changes in DB
                    $transaction->commit();

                    //response back to JS script
                    $response = array(
                        'relation_id' => $iof->id,
                        'image_id' => $image->id,
                        'original_url' => $image->getUrl(),
                        'thumbnail_url' => $image->getUrl(), //TODO: get url for thumbnail
                        'success' => '1'
                    );

                    echo json_encode($response);
                }
                catch(Exception $ex)
                {
                    //discard all changes in DB
                    $transaction->rollback();

                    //response back to JS script
                    $response = array(
                        'relation_id' => '',
                        'image_id' => '',
                        'original_url' => '',
                        'thumbnail_url' => '',
                        'success' => '0'
                    );

                    echo json_encode($response);
                }
            }
        }
        Yii::app()->end();
    }


    /**
     * Delete image relation with field value
     * @param $id
     */
    public function actionDelFieldImage($id)
    {
        ExtImagesOfComplexPageFieldValues::model()->deleteByPk((int)$id);

        //OK for ajax - redirect for standard request
        if(Yii::app()->request->isAjaxRequest)
        {
            echo "OK";
        }
        else
        {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
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

        $groups = ExtComplexPageFieldGroups::model()->findAll(array('order' => 'priority ASC'));

        $perPage = ExtSettings::model()->getSetting('per_page',10,true);
        $items = CPaginator::getInstance($groups,$perPage,$page)->getPreparedArray();

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

        /* @var $allActives ExtComplexPageFieldGroupsActive[]*/

        $allActives = ExtComplexPageFieldGroupsActive::model()->findAll();

        //update priorities of all active added groups
        foreach($allActives as $active)
        {
            $active->priority = $active->group->priority;
            $active->update();
        }

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
            $fields = ExtComplexPageFields::model()->findAllByAttributes(array('group_id' => $group),array('order' => 'priority ASC'));
        }
        else
        {
            $fields = ExtComplexPageFields::model()->findAll(array('order' => 'priority ASC'));
        }

        $perPage = ExtSettings::model()->getSetting('per_page',10,true);
        $items = CPaginator::getInstance($fields,$perPage,$page)->getPreparedArray();

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
