<?php

class WidgetsController extends ControllerAdmin
{
    /**
     * Listing all widgets (includes creation feature)
     * @param int $page
     */
    public function actionList($page = 1)
    {
        //include necessary scripts and css
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.menu-list.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);


        //menu form
        $form_mdl = new WidgetForm();
        //currently selected theme
        $selectedTheme = 'dark'; //TODO: select theme from DB
        //get all templates for widgets
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
        $array = CPaginator::getInstance($widgets,10,$page)->getPreparedArray();

        $this->render('list_widgets',array('widgets' => $array, 'form_params' => $form_params));
    }


    /**
     * Edit and update widget
     * @param $id
     */
    public function actionEdit($id)
    {
        /* @var $objLanguages Languages[] */

        //include menu necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //all languages
        $objLanguages = SiteLng::lng()->getLngs();
        //get widget
        $objWidget = ExtSystemWidget::model()->findByPk($id);
        //types
        $arrTypes = ExtSystemWidgetType::model()->getAllTypesForForm(true);
        //currently selected theme
        $selectedTheme = 'dark'; //TODO: select theme from DB
        //get all templates for widgets
        $templates = ThemeHelper::getTemplatesForWidgets($selectedTheme);

        //form
        $form_mdl = new WidgetForm();

        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'edit-widget')
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
                //attributes
                $form_mdl->attributes = $_POST['WidgetForm'];

                if($form_mdl->validate())
                {

                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        //update
                        $objWidget->attributes = $form_mdl->attributes;
                        $objWidget->update();

                        //multi-language fields
                        $customName = $_POST['WidgetForm']['custom_name'];
                        $customHtml = $_POST['WidgetForm']['custom_name'];

                        //update translations
                        foreach($objLanguages as $language)
                        {
                            //try find translation for language
                            $trl = SystemWidgetTrl::model()->findByAttributes(array('lng_id' => $language->id, 'widget_id' => $objWidget->id));

                            //if not found
                            if(empty($trl))
                            {
                                //create translation for this widget and this language
                                $trl = new SystemWidgetTrl();
                                $trl -> widget_id = $objWidget->id;
                                $trl -> lng_id = $language->id;
                            }

                            //set data
                            $trl -> custom_html = $customHtml[$language->id];
                            $trl -> custom_name = $customName[$language->id];

                            //save pr update
                            if($trl->isNewRecord)
                            {
                                $trl->save();
                            }
                            else
                            {
                                $trl->update();
                            }
                        }

                        $transaction->commit();
                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }
                }

                //back to list
                $this->redirect('/admin/widgets/list');
            }
        }

        $this->render('edit_widget',array(
                'languages' => $objLanguages,
                'types' => $arrTypes,
                'form_model' => $form_mdl,
                'templates' => $templates,
                'widget' => $objWidget,
            )
        );
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