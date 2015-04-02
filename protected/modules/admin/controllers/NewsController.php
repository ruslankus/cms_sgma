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
                        $category->time_update = time();
                        $category->time_created = time();
                        $category->last_change_by = Yii::app()->user->id;
                        $category->priority = Sort::GetNextPriority('ExtNewsCategory',array('parent_id' => $form_mdl->parent_id));
                        $category->save();

                        //update branch
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


    /*********************************************** I T E M S ********************************************************/

    /**
     * List of all news
     * @param int $page
     * @param int $cat
     */
    public function actionList($page = 1, $cat = 0)
    {
        $this->renderText('here will be news list');
    }
}