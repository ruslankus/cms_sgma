<?php
/**
 * Class ExtSystemWidget
 * @property ExtWidRegistration[] $widRegistrations
 */
Class ExtSystemWidget extends SystemWidget
{
    /**
     * @var SystemWidgetTrl
     */
    private $trl = null;

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
        //get all relations from base class
        $relations = parent::relations();

        //pass through all
        foreach($relations as $name => $relation)
        {
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
}