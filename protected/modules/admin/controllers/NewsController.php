<?php
class NewsController extends ControllerAdmin
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

        $categories = ExtNewsCategory::model()->rootGroups();

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
        $arrParentItems = ExtNewsCategory::model()->arrayForMenuItemForm();
        //templates
        $theme = $this->arrSettings['active_desktop_theme'];
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'news'.DS.'category');

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
                        $category = new ExtNewsCategory();
                        $category->attributes = $form_mdl->attributes;
                        $category->time_updated = time();
                        $category->time_created = time();
                        $category->last_change_by = Yii::app()->user->id;
                        $category->priority = Sort::GetNextPriority('ExtNewsCategory',array('parent_id' => $form_mdl->parent_id));
                        $category->save();

                        //update branch (branch can be useful for breadcrumbs and item filtering by category)
                        $category->updateBranch();

                        //translations
                        $titles = $_POST['CategoryForm']['titles'];
                        $keywords = $_POST['CategoryForm']['keywords'];
                        $descriptions = $_POST['CategoryForm']['descriptions'];

                        foreach($titles as $lngId => $value)
                        {
                            $catTrl = new NewsCategoryTrl();
                            $catTrl -> header = $titles[$lngId];
                            $catTrl -> meta_description = $keywords[$lngId];
                            $catTrl -> description = $descriptions[$lngId];
                            $catTrl -> news_category_id = $category->id;
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
                    $this->redirect(Yii::app()->createUrl('/admin/news/categories'));
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

        $category = ExtNewsCategory::model()->findByPk($id);

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
        $arrParentItems = ExtNewsCategory::model()->arrayForMenuItemForm();
        //templates
        $theme = $this->arrSettings['active_desktop_theme'];
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'news'.DS.'category');

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
                        $category->priority = Sort::GetNextPriority('ExtNewsCategory',array('parent_id' => $form_mdl->parent_id));
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
                            $catTrl -> news_category_id = $category->id;
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
                    $this->redirect(Yii::app()->createUrl('/admin/news/categories'));
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

        Sort::ReorderItems("ExtNewsCategory",$previous,$new);

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

        Sort::Move($objItem,$dir,'ExtNewsCategory',array('parent_id' => $objItem->parent_id));

        if(!Yii::app()->request->isAjaxRequest)
        {
            //back to listing items
            $this->redirect(Yii::app()->createUrl('/admin/news/categories'));
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
        $objItem = ExtNewsCategory::model()->findByPk($id);

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
            $this->redirect(Yii::app()->createUrl('/admin/news/categories'));
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

        $category = ExtNewsCategory::model()->findByPk($cat);
        $breadCrumbs = array();

        if(!empty($category))
        {
            $objects = ExtNews::model()->findAllByAttributes(array('category_id' => (int)$cat),array('order' => 'priority ASC'));
            $breadCrumbs = $category->breadCrumbs(false);
        }
        else
        {
            $objects = ExtNews::model()->findAll(array('order' => 'priority ASC'));
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
     * Adding
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
        $arrCategories = ExtNewsCategory::model()->arrayForMenuItemForm(0,true,false);
        //templates
        $theme = $this->arrSettings['active_desktop_theme'];
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'news'.DS.'item');
        //form
        $form_mdl = new NewsForm();

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
            if(isset($_POST['NewsForm']))
            {
                $form_mdl->attributes = $_POST['NewsForm'];

                $category = ExtNewsCategory::model()->findByPk((int)$form_mdl->category_id);

                if($form_mdl->validate())
                {
                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        $item = new ExtNews();
                        $item -> attributes = $form_mdl->attributes;
                        $item -> time_updated = time();
                        $item -> time_created = time();
                        $item -> branch = !empty($category) ? $category->branch : '0';
                        $item -> priority = Sort::GetNextPriority('News',array('category_id' => $form_mdl->category_id));
                        $item -> last_change_by = Yii::app()->user->id;
                        $item -> save();

                        //translations
                        $titles = $_POST['NewsForm']['titles'];
                        foreach($objLanguages as $language)
                        {
                            $itemTrl = new NewsTrl();
                            $itemTrl -> title = $titles[$language->id];
                            $itemTrl -> lng_id = $language->id;
                            $itemTrl -> news_id = $item->id;
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
                    $this->redirect(Yii::app()->createUrl('/admin/news/list',$params));
                }
            }
        }

        $this->render('add_item',array(
                'languages' => $objLanguages,
                'categories' => $arrCategories,
                'statuses' => $arrStatuses,
                'form_model' => $form_mdl,
                'category' => $cat,
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
        $item = ExtNews::model()->findByPk($id);

        if(empty($item))
        {
            throw new CHttpException(404);
        }

        //statuses
        $arrStatuses = ExtStatus::model()->arrayForNewsAndProducts(true);
        //parents
        $arrCategories = ExtNewsCategory::model()->arrayForMenuItemForm(0,true,false);
        //templates
        $theme = $this->arrSettings['active_desktop_theme'];
        $arrTemplates = ThemeHelper::getTemplatesFor($theme,'news'.DS.'item');
        //form
        $form_mdl = new NewsForm();


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
            if(isset($_POST['NewsForm']))
            {
                $form_mdl -> attributes = $_POST['NewsForm'];
                $form_mdl -> image = CUploadedFile::getInstance($form_mdl,'image');

                if($form_mdl->validate())
                {
                    //use transaction
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        $needOtherPriority = $item->category_id != $form_mdl->category_id;

                        //update basic params
                        $item->label = $form_mdl->label;
                        $item->status_id = $form_mdl->status_id;
                        $item->category_id = $form_mdl->category_id;
                        $item->time_updated = time();
                        $item->last_change_by = Yii::app()->user->id;

                        if($needOtherPriority)
                        {
                            $item->priority = Sort::GetNextPriority("News",array('category_id' => $form_mdl->category_id));
                        }

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
                                $imageOfNews = new ImagesOfNews();
                                $imageOfNews -> news_id = $item->id;
                                $imageOfNews -> image_id = $image->id;
                                $imageOfNews -> save();
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

        foreach($item->imagesOfNews as $index => $ion)
        {
            if($index+1 <= count($images))
            {
                $images[$index] = $ion;
            }
        }

        $this->render('edit_item_settings',array(
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
        $item = ExtNews::model()->findByPk($id);

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
            $this->redirect(Yii::app()->createUrl('admin/news/edit',array('id' => $id)));
        }

        //if should update (etc. by AJAX)
        if(isset($_POST['NewsFormTrl']))
        {
            //foreach every language id
            foreach($_POST['NewsFormTrl'] as $lngId => $fields)
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
            $this->renderPartial('_edit_item_content',array(
                'item' => $item,
                'languages' => $objLanguages,
                'currentLng' => $objCurrentLng,
                'itemTrl' => $trl,
            ));
        }
        //render simple
        else
        {
            $this->render('edit_item_content',array(
                'item' => $item,
                'languages' => $objLanguages,
                'currentLng' => $objCurrentLng,
                'itemTrl' => $trl,
            ));
        }
    }

    /**
     * Deletes image
     * @param $id
     */
    public function actionDeleteImage($id)
    {
        ImagesOfNews::model()->deleteByPk((int)$id);
        $this->redirect(Yii::app()->request->urlReferrer);
    }


    /**
     * Deleting
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        //find item of menu
        $objItem = ExtNews::model()->findByPk($id);

        ///if not found
        if(empty($objItem))
        {
            throw new CHttpException(404);
        }

        $objItem->delete();

        if(!Yii::app()->request->isAjaxRequest)
        {
            //back to listing items
            $this->redirect(Yii::app()->createUrl('/admin/news/list'));
        }
        else
        {
            echo "OK";
        }
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

        Sort::ReorderItems("ExtNews",$previous,$new);
        echo "OK";
    }
}