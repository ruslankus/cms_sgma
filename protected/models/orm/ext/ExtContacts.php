<?php
/**
 * Class ExtContacts
 * @property ExtContactsFields[] $contactsFields
 */
class ExtContacts extends Contacts
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

        //return modified relations
        return $relations;
    }

    public function getContact($contact_id,$lng = 'en'){
        $contact = Yii::app()->db->createCommand();
        $contact->select('label,title,text,meta_description');
        $contact->from('contacts t1');
        $contact->join('contacts_trl t2' ,'t2.contacts_id=t1.id ');
        $contact->join('languages t3' ,'t2.lng_id=t3.id ');
        $contact->where("t3.prefix=:prefix and t1.id=:id", array(':prefix' => $lng,':id' => $contact_id));
        
        $result = $contact->queryRow();
      
        return $result; 
    }
}