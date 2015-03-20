<?php
/*
 * Class DynamicWidgets
 */
class DynamicWidgets
{
    //all of these constants correspond to ID's in table 'system_widget_type'
    const WID_TYPE_SEARCH = 1;
    const WID_TYPE_LOGIN = 2;
    const WID_TYPE_CALENDAR = 3;
    const WID_TYPE_LANGUAGE_BAR = 4;
    const WID_TYPE_PRODUCT_CART = 5;
    const WID_TYPE_CUSTOM_HTML = 6;

    //all of these constants correspond to ID's in table 'wid_registration_type'
    const REGISTRATION_WIDGET = 1;
    const REGISTRATION_MENU = 2;

    /**
     * Main instance
     * @var DynamicWidgets|bool
     */
    private static $_instance = false;

    //items not separated, array looks like 'position' => 'HTML of all widgets in this position'
    public $widgets = array();

    //items separated, array looks like 'positions' => (1 => 'HTML of widget 1', 2 => 'HTML of widget 2')
    public $widgetsArr = array();


    /**
     * Returns an instance or contents of all widgets in selected positions
     * @param null $position
     * @param null $positions
     * @param null $controller
     * @return string|bool|DynamicWidgets
     */
    public static function get($position = null, $positions = null, $controller = null)
    {
        if(!self::$_instance && !empty($positions) && !empty($controller)){
            self::init($positions,$controller);
        }

        if($position == null)
        {
            return self::$_instance;
        }
        else
        {
            if(self::$_instance)
            {
                return self::$_instance->widgets[$position];
            }
        }

        return false;
    }


    /**
     * Initialisation
     * @param null $positions
     * @param null $controller
     * @return bool
     */
    public static function init($positions = null, $controller = null)
    {
        $success = true;

        try
        {
            self::$_instance = new self($positions,$controller);
        }
        catch(Exception $ex)
        {
            $success = false;
        }

        return $success;
    }

    /**
     * Main initialisation
     */
    private function __construct($positions,$controller) {

        $arrPositionTitles = array();
        $arrPositionTitlesArr = array();

        foreach($positions as $number => $title)
        {
            $arrPositionTitles[$title] = '';
            $arrPositionTitlesArr[$title] = array();

            /* @var $controller Controller */
            /* @var $registrations WidRegistration[] */
            /* @var $widgetInfo SystemWidget */
            /* @var $menuInfo Menu */

            //Search for all widget registrations
            $registrations = WidRegistration::model()->findAllByAttributes(array('position_nr' => $number), array('order' => 'priority DESC'));

            foreach($registrations as $registration)
            {
                //if registered simple widget
                if($registration->type_id == self::REGISTRATION_WIDGET)
                {
                    $widgetInfo = $registration->widget;

                    if(!empty($widgetInfo))
                    {
                        $widgetPath = 'application.widgets.system.';

                        switch($widgetInfo->type_id)
                        {
                            case self::WID_TYPE_SEARCH:
                                $widgetPath.='SysSearch';
                                break;

                            case self::WID_TYPE_CALENDAR:
                                $widgetPath.='SysCalendar';
                                break;

                            case self::WID_TYPE_LANGUAGE_BAR:
                                $widgetPath.='SysLanguages';
                                break;

                            case self::WID_TYPE_LOGIN:
                                $widgetPath.='SysLogin';
                                break;

                            case self::WID_TYPE_CUSTOM_HTML:
                                $widgetPath.='SysCustom';
                                break;

                            case self::WID_TYPE_PRODUCT_CART:
                                $widgetPath.='SysCart';
                                break;
                        }

                        try
                        {
                            //Try get widget content
                            $widgetContent = $controller->widget($widgetPath,array('templateName' => $widgetInfo->template_name),true);
                        }
                        catch(Exception $ex)
                        {
                            //Get error message if can't find widget's template
                            $widgetContent = $ex->getMessage();
                        }

                        $arrPositionTitles[$title].= $widgetContent;
                        $arrPositionTitlesArr[$title][] = $widgetContent;
                    }
                }

                //if registered menu
                if($registration->type_id == self::REGISTRATION_MENU)
                {
                    $menuInfo = $registration->menu;

                    if(!empty($menuInfo))
                    {
                        $widgetPath = 'application.widgets.system.SysMenu';

                        try
                        {
                            //Try get widget content
                            $menuContent = $controller->widget($widgetPath,array('menu' => $menuInfo),true);
                        }
                        catch(Exception $ex)
                        {
                            //Get error message if can't find widget's template
                            $menuContent = $ex->getMessage();
                        }

                        $arrPositionTitles[$title].= $menuContent;
                        $arrPositionTitlesArr[$title][] = $menuContent;
                    }
                }
            }
        }

        $this->widgets = $arrPositionTitles;
        $this->widgetsArr = $arrPositionTitlesArr;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = "";
        if(!empty($this->widgets))
        {
            foreach($this->widgets as $widgetHtmlInPosition)
            {
                $html.=$widgetHtmlInPosition;
            }
        }
        return $html;
    }

    /**
     * Disable cloning - by singleton pattern
     */
    private function __clone(){}
}