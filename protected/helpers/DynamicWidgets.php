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

    //instance
    private static $_instance = false;

    //array of all widgets contents in their places
    public $widgets = array();

    /**
     * Returns or creates an instance
     * @param null $positions
     * @param null $controller
     * @return bool|DynamicWidgets
     */
    public static function get($positions = null, $controller = null)
    {
        if(!self::$_instance && !empty($positions) && !empty($controller)){
            self::$_instance = new self($positions,$controller);
        }
        return self::$_instance;
    }

    /**
     * Main initialisation
     */
    private function __construct($positions,$controller) {

        $arrPositionTitles = array();

        foreach($positions as $number => $title)
        {
            /* @var $controller Controller */
            /* @var $registrations WidRegistration[] */
            /* @var $widgetInfo SystemWidget */

            //Search for all widget registrations
            $registrations = WidRegistration::model()->findAllByAttributes(array('position_nr' => $number, 'type_id' => self::REGISTRATION_WIDGET), array('order' => 'priority DESC'));

            foreach($registrations as $registration)
            {
                $widgetInfo = $registration->widget;

                if(!empty($widgetInfo))
                {
                    $widgetPath = !empty(Yii::app()->theme) ? 'webroot.themes.'.Yii::app()->theme->name.'.widgets.' : 'application.widgets.';

                    switch($widgetInfo->type)
                    {
                        case self::WID_TYPE_SEARCH:
                            $widgetPath.='SysSearch';
                            break;

                        case self::WID_TYPE_CALENDAR:
                            $widgetPath.='SysCalendar';
                            break;

                        case self::WID_TYPE_LANGUAGE_BAR:
                            $widgetPath.='SysCart';
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

                    $content = $controller->widget($widgetPath,array('templateName' => $widgetInfo->template_name),true);
                    Debug::out($content);
                }
            }

        }

    }

    /**
     * Disable cloning - by singleton pattern
     */
    private function __clone(){}
}