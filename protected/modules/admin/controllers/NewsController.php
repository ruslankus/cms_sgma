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
        $arrParentItems = ExtNewsCategory::model()->arrayForMenuItemForm();

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
            )
        );
    }


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

        if($cat !== 0)
        {
            $objects = ExtNews::model()->findAllByAttributes(array('category_id' => (int)$cat),array('order' => 'priority DESC'));
        }
        else
        {
            $objects = ExtNews::model()->findAll(array('order' => 'priority DESC'));
        }

        $array = CPaginator::getInstance($objects,10,$page)->getPreparedArray();

        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_list_items',array('items' => $array, 'category' => $cat));
        }
        else
        {
            $this->render('list_items',array('items' => $array,'category' => $cat));
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
                        $item -> time_update = time();
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
            )
        );
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