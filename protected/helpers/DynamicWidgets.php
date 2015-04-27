<?php
/*
 * Class DynamicWidgets
 */
class DynamicWidgets
{
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

    //items as object
    public $objWidgetsArr = array();


    /**
     * Returns all available widget positions for specified theme
     * @param string $themeName
     * @return array
     */
    public static function getArrayOfPositionsByThemeName($themeName)
    {
        $theme = !empty($themeName) ? Yii::app()->themeManager->getTheme($themeName) : null;
        $path = !empty($theme) ? $theme->getBasePath() : Yii::app()->getBasePath();
        $themeConfigFile = $path.DS.'theme.ini';
        $arrThemeConfig = file_exists($themeConfigFile) ? parse_ini_file($themeConfigFile,true) : array();
        $arrWidgetPositions = !empty($arrThemeConfig['widget_positions']) ? $arrThemeConfig['widget_positions'] : array();
        return $arrWidgetPositions;
    }

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
     * @param null $controller
     * @param null $themeName
     * @return bool
     */
    public static function init($themeName = null, $controller = null)
    {
        $success = true;

        try
        {
            self::$_instance = new self($themeName, $controller);
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
    private function __construct($themeName,$controller)
    {
        $positions = self::getArrayOfPositionsByThemeName($themeName);

        if(empty($positions))
        {
            return;
        }

        foreach($positions as $number => $title)
        {
            $this->widgets[$title] = '';
            $this->widgetsArr[$title] = array();

            $this->objWidgetsArr[$number]['title'] = $title;
            $this->objWidgetsArr[$number]['objects'] = array();
            $this->objWidgetsArr[$number]['keys'] = array();

            /* @var $controller Controller */
            /* @var $registrations ExtWidRegistration[] */
            /* @var $widgetInfo ExtSystemWidget */
            /* @var $menuInfo ExtMenu */

            //Search for all widget registrations
            $registrations = ExtWidRegistration::model()->findAllByAttributes(array('position_nr' => $number), array('order' => 'priority ASC'));

            foreach($registrations as $registration)
            {
                //if registered simple widget
                if($registration->type_id == self::REGISTRATION_WIDGET)
                {
                    $widgetInfo = $registration->widget;

                    if(!empty($widgetInfo))
                    {
                        $widgetPath = 'application.widgets.system.'.$widgetInfo->type->widget_class;

                        try
                        {
                            //Try get widget content
                            $widgetContent = $controller->widget($widgetPath,array('widgetInfo' => $widgetInfo, 'themeName' => $themeName),true);
                        }
                        catch(Exception $ex)
                        {
                            //Get error message if can't find widget's template (or widget class is incorrect)
                            $widgetContent = $ex->getMessage();
                        }

                        //push all contents to array
                        $this->widgets[$title].= $widgetContent;
                        $this->widgetsArr[$title][] = $widgetContent;
                        $this->objWidgetsArr[$number]['objects'][] = $widgetInfo;
                        $this->objWidgetsArr[$number]['keys'][] = array($widgetInfo->registration_type,$widgetInfo->id);
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
                            $menuContent = $controller->widget($widgetPath,array('menu' => $menuInfo, 'themeName' => $themeName),true);
                        }
                        catch(Exception $ex)
                        {
                            //Get error message if can't find widget's template
                            $menuContent = $ex->getMessage();
                        }

                        $this->widgets[$title].= $menuContent;
                        $this->widgetsArr[$title][] = $menuContent;
                        $this->objWidgetsArr[$number]['objects'][] = $menuInfo;
                        $this->objWidgetsArr[$number]['keys'][] = array($menuInfo->registration_type,$menuInfo->id);
                    }
                }
            }
        }
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