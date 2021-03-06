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

        $perPage = ExtSettings::model()->getSetting('per_page',10,true);
        $array = CPaginator::getInstance($categories,$perPage,$page)->getPreparedArray();

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
        $theme = $this->arrSettings['active_desktop_theme'];
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
        $theme = $this->arrSettings['active_desktop_theme'];
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
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.products.js',CClientScript::POS_END);

        $category = ExtProductCategory::model()->findByPk($cat);
        $breadCrumbs = array();

        if(!empty($category))
        {
            $objects = ExtProduct::model()->findAllByAttributes(array('category_id' => (int)$cat),array('order' => 'priority ASC'));
            $breadCrumbs = $category->breadCrumbs(false);
        }
        else
        {
            $objects = ExtProduct::model()->findAll(array('order' => 'priority DESC'));
        }

        $perPage = ExtSettings::model()->getSetting('per_page',10,true);
        $array = CPaginator::getInstance($objects,$perPage,$page)->getPreparedArray();

        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_list_items',array('items' => $array, 'category' => $cat));
        }
        else
        {
            $this->render('list_items',array('items' => $array,'category' => $cat, 'breadcrumbs' => $breadCrumbs));
        }
    }

    /**
     * Delete item
     * @param $id
     * @param int $page
     * @param int $cat
     */
    public function actionDelete($id,$page = 1,$cat = 0)
    {
        /**
         * Just delete item and back to list
         */
        ExtProduct::model()->deleteByPk((int)$id);
        $this->redirect(Yii::app()->createUrl('admin/products/list',array('page' => $page, 'cat' => $cat)));
    }

    /**
     * Deleting by checkboxes
     * @param int $page
     * @param int $cat
     */
    public function actionDeleteAll($page = 1, $cat = 0)
    {
        $ids = array();
        $deleteIds = Yii::app()->request->getParam('delete',array());
        foreach($deleteIds as $id => $status)
        {
            $ids[] = $id;
        }

        ExtProduct::model()->deleteByPk($ids);

        $this->redirect(Yii::app()->createUrl('admin/products/list',array('page' => $page, 'cat' => $cat)));
    }

    /**
     * Add product item
     * @param int $cat
     */
    public function actionAdd($cat = 0)
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
        //parents
        $arrCategories = ExtProductCategory::model()->arrayForMenuItemForm(0,true,false);
        //templates
        $theme = $this->arrSettings['active_desktop_theme'];
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'products'.DS.'item');
        //form
        $form_mdl = new ProductForm();
        //product code
        $product_code = ExtProduct::model()->generateUniqueProductCode('PR',5);

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
            if(isset($_POST['ProductForm']))
            {
                $form_mdl->attributes = $_POST['ProductForm'];

                $category = ExtProductCategory::model()->findByPk((int)$form_mdl->category_id);

                if($form_mdl->validate())
                {
                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        $item = new ExtProduct();
                        $item -> attributes = $form_mdl->attributes;
                        $item -> time_updated = time();
                        $item -> time_created = time();
                        $item -> branch = !empty($category) ? $category->branch : '0';
                        $item -> priority = Sort::GetNextPriority('Product',array('category_id' => $form_mdl->category_id));
                        $item -> last_change_by = Yii::app()->user->id;

                        $item->price = Number::PriceToBase($item->price);
                        $item->discount_price = Number::PriceToBase($item->discount_price);

                        $item -> save();

                        //translations
                        $titles = $_POST['ProductForm']['titles'];
                        foreach($objLanguages as $language)
                        {
                            $itemTrl = new ProductTrl();
                            $itemTrl -> title = $titles[$language->id];
                            $itemTrl -> lng_id = $language->id;
                            $itemTrl -> product_id = $item->id;
                            $itemTrl -> save();
                        }

                        $transaction->commit();

                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }

                    $params = array();
                    $params['cat'] = !empty($category) ? $category->id : 0;

                    //back to list
                    $this->redirect(Yii::app()->createUrl('/admin/products/list',$params));
                }
            }
        }

        $this->render('add_product',array(
                'languages' => $objLanguages,
                'categories' => $arrCategories,
                'statuses' => $arrStatuses,
                'form_model' => $form_mdl,
                'category' => $cat,
                'templates' => $arrTemplates,
                'product_code' => $product_code
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
        $item = ExtProduct::model()->findByPk($id);

        if(empty($item))
        {
            throw new CHttpException(404);
        }

        //statuses
        $arrStatuses = ExtStatus::model()->arrayForNewsAndProducts(true);
        //parents
        $arrCategories = ExtProductCategory::model()->arrayForMenuItemForm(0,true,false);
        //tags
        $arrTags = ExtTag::model()->getListForForms();
        //templates
        $theme = $this->arrSettings['active_desktop_theme'];
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'products'.DS.'item');
        //form
        $form_mdl = new ProductForm();

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
            if(isset($_POST['ProductForm']))
            {

                $form_mdl -> attributes = $_POST['ProductForm'];
                $form_mdl -> image = CUploadedFile::getInstance($form_mdl,'image');

                if($form_mdl->validate())
                {
                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        //do we need recalculate priority (if category changed)
                        $needOtherPriority = $item->category_id != $form_mdl->category_id;

                        $item->attributes = $form_mdl->attributes;
                        $item->time_updated = time();
                        $item->last_change_by = Yii::app()->user->id;

                        //delete all selected tags
                        TagsOfProduct::model()->deleteAllByAttributes(array('product_id' => $item->id));

                        //add selected tags
                        if(!empty($_POST['ProductForm']['selected_tags']))
                        {
                            foreach($_POST['ProductForm']['selected_tags'] as $index => $tagId)
                            {
                                $top = new TagsOfProduct();
                                $top -> product_id = $item->id;
                                $top -> tag_id = $tagId;
                                $top -> save();
                            }
                        }


                        if($needOtherPriority)
                        {
                            $item->priority = Sort::GetNextPriority("Product",array('category_id' => $form_mdl->category_id));
                        }

                        $item->price = Number::PriceToBase($item->price);
                        $item->discount_price = Number::PriceToBase($item->discount_price);

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
                                $imageOfProduct = new ImagesOfProduct();
                                $imageOfProduct -> product_id = $item->id;
                                $imageOfProduct -> image_id = $image->id;
                                $imageOfProduct -> save();
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

        foreach($item->imagesOfProducts as $index => $iop)
        {
            if($index+1 <= count($images))
            {
                $images[$index] = $iop;
            }
        }

        //store selected values to mark them in form
        foreach($item->tagsOfProducts as $top)
        {
            $form_mdl->selected_tags[] = $top->tag_id;
        }

        $this->render('edit_product_settings',array(
            'categories' => $arrCategories,
            'statuses' => $arrStatuses,
            'form_model' => $form_mdl,
            'item' => $item,
            'images' => $images,
            'templates' => $arrTemplates,
            'tags' => $arrTags
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
        /* @var $item ExtNews */

        //include menu necessary css and js
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.edit-page-content.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-news-content.js',CClientScript::POS_END);

        //fin news item by PK
        $item = ExtProduct::model()->findByPk($id);

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
            $this->redirect(Yii::app()->createUrl('admin/products/edit',array('id' => $id)));
        }

        //if should update (etc. by AJAX)
        if(isset($_POST['ProductFormTrl']))
        {
            //foreach every language id
            foreach($_POST['ProductFormTrl'] as $lngId => $fields)
            {
                $lng = $lngId; //set current language id
                $trl = $item->getOrCreateTrl($lngId); // get TRL object (or create in not found in DB)

                //set values
                $trl->title = $fields['title'];
                $trl->summary = $fields['summary'];
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
            $this->renderPartial('_edit_product_content',array(
                'item' => $item,
                'languages' => $objLanguages,
                'currentLng' => $objCurrentLng,
                'itemTrl' => $trl,
            ));
        }
        //render simple
        else
        {
            $this->render('edit_product_content',array(
                'item' => $item,
                'languages' => $objLanguages,
                'currentLng' => $objCurrentLng,
                'itemTrl' => $trl,
            ));
        }
    }

    /**
     * Select and deselect which groups of attributes you want in product
     * @param $id
     * @throws CHttpException
     */
    public function actionEditProdAttrGroup($id)
    {
        //product item
        $product = ExtProduct::model()->findByPk((int)$id);

        if(empty($product))
        {
            throw new CHttpException(404);
        }

        //if checked any checkbox
        if(Yii::app()->request->isPostRequest)
        {
            ExtProductFieldGroupsActive::model()->deleteAllByAttributes(array('product_id' => $product->id));

            if(isset($_POST['active']))
            {
                $active = $_POST['active'];

                foreach($active as $iid => $status)
                {
                    $group = ExtProductFieldGroups::model()->findByPk($iid);

                    if(!empty($group))
                    {
                        $active = new ExtProductFieldGroupsActive();
                        $active -> product_id = $product->id;
                        $active -> group_id = $iid;
                        $active -> priority = $group->priority;
                        $active -> save();
                    }

                }
            }
        }

        //all field groups
        $allGroups = ExtProductFieldGroups::model()->findAll(array('order' => 'priority DESC'));

        //active id's
        $activeGroupIds = array();

        //get active id's
        foreach($product->productFieldGroupsActives as $active)
        {
            $activeGroupIds[] = $active->group_id;
        }

        //render
        $this->render('edit_product_attr_groups',
            array(
            'item' => $product,
            'groups' => $allGroups,
            'active_ids' => $activeGroupIds)
        );


    }

    /**
     * Edit values of attribute-fields
     * @param $id
     * @throws CHttpException
     */
    public function actionEditProdFields($id)
    {
        //include menu necessary scripts
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/ui-lightness/jquery-ui-1.10.4.custom.css');

        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.dynamic-fields.css');

        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.dynamic-fields.js',CClientScript::POS_END);

        //product item
        $product = ExtProduct::model()->findByPk((int)$id);

        if(empty($product))
        {
            throw new CHttpException(404);
        }

        //languages
        $languages = SiteLng::lng()->getLngs();

        //all selected groups of this item
        $attributeGroupsOfProduct = $product->productFieldGroupsActives;

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
                    $field = ExtProductFields::model()->findByPk($fieldId);
                    switch($field->type_id)
                    {
                        case ExtProductFieldTypes::TYPE_NUMERIC;
                            $value = $field->getValueObjForItem($product->id);
                            $value -> numeric_value = $valueData;
                            $value -> saveOrUpdate();
                            break;

                        case ExtProductFieldTypes::TYPE_TEXT:
                            $value = $field->getValueObjForItem($product->id);
                            $value -> text_value = $valueData;
                            $value -> saveOrUpdate();
                            break;

                        case ExtProductFieldTypes::TYPE_TRL_TEXT:
                            $value = $field->getValueObjForItem($product->id);
                            $value -> saveOrUpdate();

                            foreach($valueData as $lngId => $trlData)
                            {
                                $trl = $value->getOrCreateTrl($lngId);
                                $trl -> translatable_text = $trlData;
                                $saved = $trl -> isNewRecord ? $trl->save() : $trl->update();
                            }
                            break;

                        case ExtProductFieldTypes::TYPE_SELECTABLE:
                            $value = $field->getValueObjForItem($product->id);
                            $value -> selected_option_id = (int)$valueData;
                            $value -> saveOrUpdate();
                            break;

                        case ExtProductFieldTypes::TYPE_DATE:
                            $value = $field->getValueObjForItem($product->id);

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
            $this->render('edit_product_attr_values',
                array(
                    'active' => $attributeGroupsOfProduct,
                    'item' => $product,
                    'languages' => $languages
                ));
        }

    }

    /**
     * Deletes image
     * @param $id
     */
    public function actionDeleteImage($id)
    {
        ImagesOfProduct::model()->deleteByPk((int)$id);
        $this->redirect(Yii::app()->request->urlReferrer);
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
     * Assign image to value for image-type field of product
     * @param $id
     * @param $fid
     * @param $iid
     * @throws CHttpException
     */
    public function actionAssignFieldImage($id,$fid,$iid)
    {
        //just found all necessary records in db
        $field = ExtProductFields::model()->findByPk((int)$fid);
        $item = ExtProduct::model()->findByPk((int)$id);
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
        $imagesOfValue = $value->imagesOfProductFieldsValues;

        //if found some image-relations
        if(count($imagesOfValue) > 0)
        {
            //delete them all (this field can have only one image)
            ExtImagesOfProductFieldsValues::model()->deleteAllByAttributes(array('field_value_id' => $value->id));
        }

        //relate field value with image
        $imageOf = new ExtImagesOfProductFieldsValues();
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
        $product = ExtProduct::model()->findByPk((int)$id);
        $productFiled = ExtProductFields::model()->findByPk((int)$fid);

        if(empty($product) || empty($productFiled))
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
                    $image -> label = 'Image of "'.$productFiled->field_name.'" field value of page "'.$product->label.'"';
                    $image -> status_id = ExtStatus::VISIBLE;
                    $image -> save();

                    //get value
                    $value = $productFiled->getValueObjForItem($product->id);

                    if($value->isNewRecord)
                    {
                        $value->save();
                    }

                    //clean all old images
                    ExtImagesOfProductFieldsValues::model()->deleteAllByAttributes(array('field_value_id' => $value->id));

                    //add new relation
                    $iop = new ExtImagesOfProductFieldsValues();
                    $iop -> image_id = $image->id;
                    $iop -> field_value_id = $value->id;
                    $iop -> save();

                    //apply changes in DB
                    $transaction->commit();

                    //response back to JS script
                    $response = array(
                        'relation_id' => $iop->id,
                        'image_id' => $image->id,
                        'original_url' => $image->getUrl(),
                        'thumbnail_url' => $image->getCachedUrl(160,120),
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
        ExtImagesOfProductFieldsValues::model()->deleteByPk((int)$id);

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

        /* @var $allActiveGroups ExtProductFieldGroupsActive[] */

        //update priority active groups (priority pf them must be as
        $allActiveGroups = ExtProductFieldGroupsActive::model()->findAll();
        foreach($allActiveGroups as $ag)
        {
            $ag->priority = $ag->group->priority;
            $ag->update();
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

        $fieldGroup = ExtProductFieldGroups::model()->findByPk($group);

        if(!empty($fieldGroup))
        {
            $fields = ExtProductFields::model()->findAllByAttributes(array('group_id' => $group),array('order' => 'priority DESC'));
        }
        else
        {
            $fields = ExtProductFields::model()->findAll(array('order' => 'priority DESC'));
        }

        $perPage = ExtSettings::model()->getSetting('per_page',10,true);
        $items = CPaginator::getInstance($fields,$perPage,$page)->getPreparedArray();

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
                        if($field -> type_id == ExtProductFieldTypes::TYPE_SELECTABLE)
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


    /********************************************** T A G S **********************************************************/

    /**
     * Render list of tags
     * @param int $page
     */
    public function actionTags($page = 1)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.menu-list.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.products.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        $form_mdl = new TagForm();

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
            if($_POST['TagForm'])
            {
                $form_mdl->attributes = $_POST['TagForm'];

                if($form_mdl->validate())
                {
                    $menu = new ExtTag();
                    $menu->attributes = $form_mdl->attributes;
                    $menu->save();
                }
            }
        }

        $tags = ExtTag::model()->findAll();

        $perPage = ExtSettings::model()->getSetting('per_page',10,true);
        $items = CPaginator::getInstance($tags,$perPage,$page)->getPreparedArray();

        $this->render('list_tags', array('items' => $items, 'form_mdl' => $form_mdl));
    }

    /**
     * Deleting tags
     * @param $id
     * @param int $page
     */
    public function actionDeleteTag($id, $page = 1)
    {
        ExtTag::model()->deleteByPk($id);
        $this->redirect(Yii::app()->createUrl('admin/products/tags',array('page' => $page)));
    }


    /**
     * Delete image of tag
     * @param $id
     */
    public function actionDeleteTagImage($id)
    {
        ExtImagesOfTags::model()->deleteByPk((int)$id);
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Editing tags
     * @param $id
     */
    public function actionEditTag($id)
    {
        //include menu necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //all languages
        $objLanguages = SiteLng::lng()->getLngs();
        //menu item
        $tagItem = ExtTag::model()->findByPk($id);

        //form
        $form_mdl = new TagForm();

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
            if($_POST['TagForm'])
            {
                $form_mdl->attributes = $_POST['TagForm'];
                $form_mdl->image = CUploadedFile::getInstance($form_mdl,'image');

                if($form_mdl->validate())
                {
                    /* @var $parent ExtMenuItem */

                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    //try to update
                    try
                    {
                        //menu item
                        $tagItem->attributes = $form_mdl->attributes;
                        $tagItem->update();

                        $titles = $_POST['TagForm']['titles'];
                        $descriptions = $_POST['TagForm']['descriptions'];

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
                                $image -> size = $form_mdl->image->size;
                                $image -> mime_type = $form_mdl->image->type;
                                $image -> label = 'Image of tag "'.$tagItem->label.'"';
                                $image -> status_id = ExtStatus::VISIBLE;
                                $image -> save();

                                //delete all image-relations of this tag
                                ExtImagesOfTags::model()->deleteAllByAttributes(array('tag_id' => $tagItem->id));

                                //Create one image-tag relation (one image of tag)
                                $iot = new ExtImagesOfTags();
                                $iot -> image_id = $image->id;
                                $iot -> tag_id = $tagItem->id;
                                $iot -> save();
                            }
                        }

                        //translations
                        foreach($titles as $lngId => $title)
                        {
                            //try find translation
                            $tagItemTrl = $tagItem->getTrl($lngId);

                            //if not found - create
                            if(empty($tagItemTrl))
                            {
                                $tagItemTrl = new TagTrl();
                            }

                            $tagItemTrl->name = $title;
                            $tagItemTrl->description = $descriptions[$lngId];

                            //save or update
                            if($tagItemTrl->isNewRecord)
                            {
                                $tagItemTrl->save();
                            }
                            else
                            {
                                $tagItemTrl->update();
                            }
                        }
                        $transaction->commit();
                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }

                    //back to list
                    $this->redirect(Yii::app()->createUrl('admin/products/tags'));
                }
            }
        }

        //render
        $this->render('edit_tag_item',array('languages' => $objLanguages,'form_model' => $form_mdl, 'tag' => $tagItem));
    }

    /**
     * Batch deleting (with check boxes)
     * @param int $page
     */
    public function actionDeleteAllTags($page = 1)
    {
        $ids = array();
        $deleteIds = Yii::app()->request->getParam('delete',array());
        foreach($deleteIds as $id => $status)
        {
            $ids[] = $id;
        }

        Tag::model()->deleteByPk($ids);

        //back to list
        $this->redirect(Yii::app()->createUrl('admin/products/tags',array('page' => $page)));
    }
}