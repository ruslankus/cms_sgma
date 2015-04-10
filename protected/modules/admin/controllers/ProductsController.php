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
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.products.js',CClientScript::POS_END);

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
        $theme = 'dark'; //TODO: get theme from db
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
        //templates
        $theme = 'dark'; //TODO: get theme from db
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
                        $needOtherPriority = $item->category_id != $form_mdl->category_id;

                        $item->attributes = $form_mdl->attributes;
                        $item->time_updated = time();
                        $item->last_change_by = Yii::app()->user->id;

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
                            if($form_mdl->image->saveAs('uploads/images/'.$randomName.'.'.$form_mdl->image->extensionName))
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

        $this->render('edit_product_settings',array(
            'categories' => $arrCategories,
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


    public function actionEditProdAttrGroup($id)
    {
        //product item
        $product = ExtProduct::model()->findByPk((int)$id);

        if(empty($product))
        {
            throw new CHttpException(404);
        }

        //if checked any checkbox
        if(isset($_POST['active']))
        {
            $active = $_POST['active'];

            ExtProductFieldGroupsActive::model()->deleteAllByAttributes(array('product_id' => $product->id));

            foreach($active as $id => $status)
            {
                $active = new ExtProductFieldGroupsActive();
                $active -> product_id = $product->id;
                $active -> group_id = $id;
                $active -> save();
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
     * Deletes image
     * @param $id
     */
    public function actionDeleteImage($id)
    {
        ImagesOfProduct::model()->deleteByPk((int)$id);
        $this->redirect(Yii::app()->request->urlReferrer);
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



}