<?php
/**
 * Class ExtSystemWidget
 * @property ExtWidRegistration[] $widRegistrations
 * @property SystemWidgetTrl $trl
 */
Class ExtSystemWidget extends SystemWidget
{

    //type of registration
    public $registration_type = DynamicWidgets::REGISTRATION_WIDGET;

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    /**
     * Get translation for specified language
     * @param $lngId
     * @return SystemWidgetTrl
     */
    public function getTrl($lngId)
    {
        //all translations
        $translations = $this->systemWidgetTrls;

        //select just one by lng id
        foreach($translations as $trl)
        {
            if($trl->lng_id == $lngId)
            {
                return $trl;
            }
        }

        //or return new empty if not found
        return new SystemWidgetTrl();
    }

    /**
     * Override, relate with extended models
     * @return array relational rules.
     */
    public function relations()
    {
        //get all relations from base class
        $relations = parent::relations();

        //pass through all
        foreach($relations as $name => $relation)
        {
            //if found extended file for this related class
            if(file_exists(dirname(__FILE__).DS.'Ext'.$relation[1].'.php'))
            {
                $relations[$name][1] = 'Ext'.$relation[1];
            }
        }

        //relate with translation
        $lng = Yii::app()->language;
        $relations['trl'] = array(self::HAS_ONE, 'MenuItemTrl', 'menu_item_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}