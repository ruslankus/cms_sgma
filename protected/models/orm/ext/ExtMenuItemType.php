<?php
/**
 * Class ExtMenuItemType
 * @property ExtMenuItem[] $menuItems
 */
class ExtMenuItemType extends MenuItemType
{
    //all of this constants are correspond to ID's in table 'menu_item_type'
    const TYPE_SINGLE_PAGE = 1;
    const TYPE_NEWS_CATALOG = 2;
    const TYPE_PRODUCTS_CATALOG = 3;
    const TYPE_CONTACT_FORM = 4;
    const TYPE_COMPLEX_PAGE = 5;

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

        //return modified relations
        return $relations;
    }
}