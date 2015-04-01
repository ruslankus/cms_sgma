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

        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_registration',array('registered' => $registered, 'all' => $allPossibleObjects));
        }
        else
        {
            $this->render('registration',array('registered' => $registered, 'all' => $allPossibleObjects));
        }

    }

    /**
     * Registration of widget or menu
     * @param $rt
     * @param $id
     * @param $pos
     */
    public function actionAjaxRegister($rt,$id,$pos)
    {
        $registrationTypeId = (int)$rt;
        $widgetOrMenuId = (int)$id;
        $positionNumber = (int)$pos;

        if($registrationTypeId != 0 && $widgetOrMenuId != 0 && $positionNumber != 0)
        {
            $registration = new ExtWidRegistration();
            $registration->position_nr = $positionNumber;
            $registration->priority = Sort::GetNextPriority('ExtWidRegistration',array('position_nr' => $positionNumber));
            $registration->type_id = $registrationTypeId;
            $registration->status_id = ExtStatus::VISIBLE;

            if($registrationTypeId == DynamicWidgets::REGISTRATION_WIDGET)
            {
                if(ExtSystemWidget::model()->countByAttributes(array('id' => $widgetOrMenuId)) > 0)
                {
                    $registration->widget_id = $widgetOrMenuId;
                }
            }
            elseif($registrationTypeId == DynamicWidgets::REGISTRATION_MENU)
            {
                if(ExtMenu::model()->countByAttributes(array('id' => $widgetOrMenuId)) > 0)
                {
                    $registration->menu_id = $widgetOrMenuId;
                }
            }

            $registration->save();
        }

        echo "OK";
    }


    /**
     * Delete registered
     * @param $rt
     * @param $id
     * @param $pos
     */
    public function actionDelete($rt,$id,$pos)
    {
        $registrationTypeId = (int)$rt;
        $widgetOrMenuId = (int)$id;
        $positionNumber = (int)$pos;

        if($registrationTypeId == DynamicWidgets::REGISTRATION_WIDGET)
        {
            ExtWidRegistration::model()->deleteAllByAttributes(array('widget_id' => $widgetOrMenuId, 'position_nr' => $positionNumber));
        }
        elseif($registrationTypeId == DynamicWidgets::REGISTRATION_MENU)
        {
            ExtWidRegistration::model()->deleteAllByAttributes(array('menu_id' => $widgetOrMenuId, 'position_nr' => $positionNumber));
        }

        if(Yii::app()->request->isAjaxRequest)
        {
            echo "OK";
        }
        else
        {
            $this->redirect(Yii::app()->createUrl('admin/positions/registration'));
        }
    }


    /**
     * Moves registration up and down by priority
     * @param $rt
     * @param $id
     * @param $pos
     * @param $dir
     */
    public function actionMove($rt,$id,$pos,$dir)
    {
        /* @var $reg ExtWidRegistration */

        $registrationTypeId = (int)$rt;
        $widgetOrMenuId = (int)$id;
        $positionNumber = (int)$pos;

        $reg = null;

        if($registrationTypeId == DynamicWidgets::REGISTRATION_WIDGET)
        {
            $reg = ExtWidRegistration::model()->findByAttributes(array('widget_id' => $widgetOrMenuId, 'position_nr' => $positionNumber));
        }
        elseif($registrationTypeId == DynamicWidgets::REGISTRATION_MENU)
        {
            $reg = ExtWidRegistration::model()->findByAttributes(array('menu_id' => $widgetOrMenuId, 'position_nr' => $positionNumber));
        }

        if(!empty($reg))
        {
            Sort::Move($reg,$dir,'ExtWidRegistration',array('position_nr' => $positionNumber),'priority ASC');
        }

        if(Yii::app()->request->isAjaxRequest)
        {
            echo "OK";
        }
        else
        {
            $this->redirect(Yii::app()->createUrl('admin/positions/registration'));
        }
    }
}