<?php

/**
 * Class ExtWidRegistration
 * @property ExtSystemWidget $widget
 * @property ExtMenu $menu
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

    /**
     * Override, relate with extended models
     * @return array relational rules.
     */

    /*
    public function relations()
    {
        //get all relations from base class
        $relations = parent::relations();

        Debug::out($relations);

        //pass through all
        foreach($relations as $name => $relation)
        {

            Debug::out($relation[1]);
            //if extended class exist for this related class
            if(class_exists('Ext'.$relation[1]))
            {
                //relate with extended class
                $relations[$name][1] = 'Ext'.$relation[1];
            }
        }

        //return modified relations
        return $relations;
    }
    */

}