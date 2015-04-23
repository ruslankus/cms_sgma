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
        $this->renderText('Under construction...');
    }

    /******************************** A T T R I B U T E S : F I E L D S ***********************************************/

    /**
     * List all fields of specified group
     * @param int $page
     * @param $group
     */
    public function actionFields($page = 1, $group = 0)
    {
        $this->renderText('Under construction...');
    }
}
