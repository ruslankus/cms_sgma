<?php
/**
 * Class ExtPage
 * @property ExtMenuItem $menuItem
 * @property PageTrl $trl
 */
class ExtPage extends Page
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
       //$relations['trl'] = array(self::HAS_ONE, 'PageTrl', 'article_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));
        $relations['trl'] = array(self::HAS_ONE, 'PageTrl', 'article_id', 'with' => array('lng' => array('condition' => "lng.prefix= :lng")));
       

        //return modified relations
        return $relations;
    }
}