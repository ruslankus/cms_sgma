<?php

class SettingsController extends ControllerAdmin
{
 
    public function actionIndex()
    {
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.edit-widgets.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.switch-themes.js',CClientScript::POS_END);
        /*
        $arrData = ExtSettings::model()->getSettings();
        
        $this->render('main',array('arrData' => $arrData));
      */
        $objSet = Settings::model()->findByAttributes(array('value_name' => 'active_desktop_theme')); 
        if($_POST['save'])
        {
            if($objSet->setting != $_POST['radio']) // if no change theme
            {
                $objSet->setting = $_POST['radio'];
                $objSet->update();
            }
        }
        $active_theme = $objSet->setting;
        $dir = "themes";
        $themes = glob("themes/*", GLOB_ONLYDIR);
        $arrData=array();
        foreach($themes as $item):
            if(file_exists($item."/theme.ini"))
            {
                $folder_name = str_replace("themes/", "", $item);
                $ini_array = parse_ini_file($item."/theme.ini");
                $ini_array['folder_name'] = $folder_name;
                if($folder_name == $active_theme)
                {
                    $ini_array['active'] = 1;
                }
                $arrData[] = $ini_array;
            }
        endforeach;
        $this->render('main',array('arrData' => $arrData));
    }
    
    /*
        ajax reset widget position
    */
        public function actionAjaxResetPositionsConfirm()
        {
            $request = Yii::app()->request->isAjaxRequest);

        }

    /*
        End ajax reset widget position
    */    
    public function actionEdit(){
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.edit-widgets.css');
        $request = Yii::app()->request;
        
        if(isset($_POST['save'])){
        
            $setName = $request->getPost('setting');
            $setValue = $request->getPost('value');      
            $objSet = Settings::model()->findByAttributes(array('value_name' => $setName)); 
               
            $objSet->setting = $setValue;
            
            if($objSet->save()){
                
            }else{
                //error
            }
        
       }
        
        $lngPrefix = SiteLng::lng()->getCurrLng()->prefix;
        $arrData = ExtSettings::model()->getSettings();
        
        $this->render('edit',array('arrData' => $arrData, 'prefix' => $lngPrefix));
    }






/*************************************** W I D G E T  R E G I S T R A T I O N S ****************************************/

    /**
     * Register widgets to positions
     */
    public function actionRegistration()
    {

        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-widgets.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.edit-widgets.css');

        $themeName = 'dark'; //TODO: get theme name form current settings

        DynamicWidgets::init($themeName,$this);
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
            $this->renderPartial('_wid_registration',array('registered' => $registered, 'all' => $allPossibleObjects));
        }
        else
        {
            $this->render('wid_registration',array('registered' => $registered, 'all' => $allPossibleObjects));
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
            $this->redirect(Yii::app()->createUrl('admin/settings/registration'));
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
            $this->redirect(Yii::app()->createUrl('admin/settings/registration'));
        }
    }


/***********************************************************************************************************************/


    
}//controller       