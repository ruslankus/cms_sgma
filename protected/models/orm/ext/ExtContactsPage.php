<?php
/**
 * Class ExtContactsGroup
 * @property ExtContactsBlock[] $contacts
 */
class ExtContactsPage extends ContactsPage
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

    public function getContactPageWithImage($page_id,$lng = 'en'){
        
        $sql  = "SELECT * FROM ".$this->tableName();
        $sql .= " WHERE id=".(int)$page_id;
        $sql .= " LIMIT 1";
        $con = $this->dbConnection;
        $arrData = $con->createCommand($sql)->queryRow();
        
        $sql  = "SELECT t2.*,t3.caption FROM images_of_contacts t1 ";
        $sql .= "JOIN images t2 ON t1.image_id = t2.id ";
        $sql .= "JOIN images_trl t3 ON t3.image_id = t2.id ";
        $sql .= "JOIN languages t4 ON t3.lng_id = t4.id " ;
        $sql .= "WHERE t1.contact_page_id = ".(int)$page_id." AND t4.prefix = :prefix";
        
        $sqlParam[':prefix'] = $lng;
        
        $arrData['images'] = $con->createCommand($sql)->queryAll(true,$sqlParam);
        
        return (!empty($arrData))? $arrData : false;
      
    }//getPageWithImage
}