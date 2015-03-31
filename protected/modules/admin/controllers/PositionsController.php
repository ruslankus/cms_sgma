<?php
class PositionsController extends ControllerAdmin
{
    /**
     * Register widgets to positions
     */
    public function actionRegistration()
    {
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-widgets.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.edit-widgets.css');

        $this->renderText('This is registration');
    }
}