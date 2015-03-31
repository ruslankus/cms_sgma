<?php
class PositionsController extends ControllerAdmin
{
    /**
     * Register widgets to positions
     */
    public function actionRegistration()
    {

        $positions = DynamicWidgets::getArrayOfPositionsByThemeName('dsd');


        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-widgets.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.edit-widgets.css');

        $this->render('registration');
    }
}