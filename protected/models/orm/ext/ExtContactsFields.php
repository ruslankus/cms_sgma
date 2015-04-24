<?php
/**
 * Class ExtContactsFields
 * @property ExtContactsBlock $contacts
 * @property ContactsFieldsTrl $trl
 */
class ExtContactsFields extends ContactsFields
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
        $relations['trl'] = array(self::HAS_ONE, 'ContactsFieldsTrl', 'contacts_field_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
    
    
    public function getFieldContent($id,$lng = 'en'){
        $con = $this->dbConnection;
            
        $sql  = "SELECT t1.*, t2.name,t2.`value` FROM contacts_fields t1 " . PHP_EOL;
        $sql .= "JOIN contacts_fields_trl t2 ON t1.id = t2.contacts_field_id " . PHP_EOL;
        $sql .= "JOIN languages t3 ON t2.lng_id = t3.id " . PHP_EOL;
        $sql .= "WHERE t3.prefix = :prefix AND t1.id =".(int)$id;
        
        $params[':prefix'] = $lng;
        $arrData = $con->createCommand($sql)->queryRow(true, $params);
        
        return (!empty($arrData))? $arrData : false;
    }//getFieldContent
}