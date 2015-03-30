<?php

class WidgetsController extends ControllerAdmin
{
    /**
     * Listing all widgets
     * @param int $page
     */
    public function actionList($page = 1)
    {
        //include necessary scripts and css
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.dialog-box.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.menu-list.js',CClientScript::POS_END);

        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.css');
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);


        //menu form
        $form_mdl = new WidgetForm();
        //currently selected theme
        $selectedTheme = 'dark'; //TODO: select theme from DB
        //get all templates for menus
        $templates = ThemeHelper::getTemplatesForWidgets($selectedTheme);
        //types
        $types = ExtSystemWidgetType::model()->getAllTypesForForm(true);


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
            if($_POST['WidgetForm'])
            {
                $form_mdl->attributes = $_POST['WidgetForm'];

                if($form_mdl->validate())
                {
                    $widget = new ExtSystemWidget();
                    $widget -> attributes = $form_mdl->attributes;
                    $widget -> save();
                }
            }
        }

        //special for form with-ajax validation
        $form_params = array('templates' => $templates, 'types' => $types, 'form_model' => $form_mdl);

        //widgets
        $widgets = ExtSystemWidget::model()->findAll();

        //pager stuff
        $perPage = 10;
        $total_pages = (int)ceil(count($widgets)/$perPage);
        $offset = (int)($perPage * ($page - 1));
        $itemsOfPage = array_slice($widgets,$offset,$perPage);

        $this->render('list_widgets',array('widgets' => $itemsOfPage, 'current_page' => $page, 'total_pages' => $total_pages, 'form_params' => $form_params));
    }

    /**
     * Deletes widget
     * @param $id
     */
    public function actionDelete($id)
    {
        ExtSystemWidget::model()->deleteByPk($id);
        $this->redirect(Yii::app()->createUrl('/admin/widgets/list'));
    }
}