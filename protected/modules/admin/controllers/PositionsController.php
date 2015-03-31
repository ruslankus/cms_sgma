<?php
class PositionsController extends ControllerAdmin
{
    /**
     * Register widgets to positions
     */
    public function actionRegistration()
    {

        $positions = DynamicWidgets::getArrayOfPositionsByThemeName('dark');
        DynamicWidgets::init($positions,$this);
        $registered = DynamicWidgets::get()->objWidgetsArr;

        //get all possible items
        $allWidgets = ExtSystemWidget::model()->findAll();
        $allMenus = ExtMenu::model()->findAll();
        $allPossibleObjects = array();

        foreach($allWidgets as $obj)
        {
            $allPossibleObjects[] = $obj;
        }

        foreach($allMenus as $obj)
        {
            $allPossibleObjects[] = $obj;
        }



        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-widgets.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.edit-widgets.css');

        $this->render('registration',array('registered' => $registered, 'all' => $allPossibleObjects));
    }
}