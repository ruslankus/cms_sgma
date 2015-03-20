<?php

/**
 * @property ExtSystemWidget $widget
 * @property ExtMenu $menu
 * Class ExtWidRegistration
 */
Class ExtWidRegistration extends WidRegistration
{
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Override, relation with extended models
     * @return array relational rules.
     */
    public function relations()
    {
        $arr = parent::relations();
        $arr['widget'] = array(self::BELONGS_TO, 'ExtSystemWidget', 'widget_id');
        $arr['menu'] = array(self::BELONGS_TO, 'ExtMenu', 'menu_id');
        return $arr;
    }
}