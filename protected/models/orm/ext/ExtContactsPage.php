<?php
/**
 * Class ExtContactsGroup
 * @property ExtContactsBlock[] $contacts
 * @property ContactsPageTrl $trl
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

            $lng = Yii::app()->language;
            $relations['trl'] = array(self::HAS_ONE, 'ContactsPageTrl', 'page_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));
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
        
        if(!empty($arrData)){
            
            $sql  = "SELECT  t2.*,t1.id AS link_id, ";
            $sql .= "(" ;
            $sql .= "SELECT i1.caption FROM images_trl i1 ";
            $sql .= "JOIN languages i2 ON i1.lng_id = i2.id ";
            $sql .= "WHERE i1.image_id = t2.id AND i2.prefix = :prefix ";
            $sql .= ") as caption ";
            $sql .= "FROM images_of_contacts t1 ";
            $sql .= "JOIN images t2 ON t1.image_id = t2.id"; 
        
        
            //$sql  = "SELECT t2.*,t3.caption FROM images_of_contacts t1 ";
            //$sql .= "JOIN images t2 ON t1.image_id = t2.id ";
            //$sql .= "JOIN images_trl t3 ON t3.image_id = t2.id ";
            //$sql .= "JOIN languages t4 ON t3.lng_id = t4.id " ;
            //$sql .= "WHERE t1.contact_page_id = ".(int)$page_id." AND t4.prefix = :prefix";
        
            $sqlParam[':prefix'] = $lng;
        
            $arrData['images'] = $con->createCommand($sql)->queryRow(true,$sqlParam);
        }
        
        return (!empty($arrData))? $arrData : false;
      
    }//getPageWithImage
    
    
    public function getContactFull($page_id, $lng = 'en'){
        
        $sql  = "SELECT * FROM ".$this->tableName();
        $sql .= " WHERE id=".(int)$page_id;
        $sql .= " LIMIT 1";
        $con = $this->dbConnection;
        $arrData = $con->createCommand($sql)->queryRow();
        //adding translation
        $sql  = "SELECT t1.title, t1.description,t1.meta_description, t1.meta_keywords " ;
        $sql .= "FROM contacts_page_trl t1 ";
        $sql .= "JOIN languages t2 ON t1.lng_id = t2.id ";
        $sql .= "WHERE t2.prefix = :prefix AND page_id = ".(int)$page_id;    
        
        $sqlParam[':prefix'] = $lng;        
        $arrData['content'] =  $con->createCommand($sql)->queryRow(true,$sqlParam);
        //aading images
        if(!empty($arrData)){
            
            $sql  = "SELECT  t2.*,t1.id AS link_id, ";
            $sql .= "(" ;
            $sql .= "SELECT i1.caption FROM images_trl i1 ";
            $sql .= "JOIN languages i2 ON i1.lng_id = i2.id ";
            $sql .= "WHERE i1.image_id = t2.id AND i2.prefix = :prefix ";
            $sql .= ") as caption ";
            $sql .= "FROM images_of_contacts t1 ";
            $sql .= "JOIN images t2 ON t1.image_id = t2.id"; 
            
            //Debug::d($sql);
            
            //$sql  = "SELECT t2.* FROM images_of_page t1 ";
            //$sql .= "JOIN images t2 ON t1.image_id = t2.id ";
          
           
           $param[":prefix"] = $prefix;
           
           $arrData['images'] = $con->createCommand($sql)->queryAll(true,$param);
           //adding block
           
           
        }
         
        return $arrData;
    }//getContactFull
    
    
    
}