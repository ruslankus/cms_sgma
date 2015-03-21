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
     * Override, relate with extended models
     * @return array relational rules.
     */
    public function relations()
    {
        $relations = parent::relations();
        foreach($relations as $name => $relation)
        {
            $relations[$name][1] = 'Ext'.$relation[1];
        }
        return $relations;
    }
}