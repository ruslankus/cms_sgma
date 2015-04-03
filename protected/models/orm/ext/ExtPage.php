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
       //$relations['trl'] = array(self::HAS_ONE, 'PageTrl', 'article_id', 'with' => array('lng' => array('condition' => "lng.prefix= :lng"))); 
        $relations['trl'] = array(self::HAS_ONE, 'PageTrl', 'article_id');      

        //return modified relations
        return $relations;
    }//relations
    
    
    public function scopes(){
        return array('lang');
    }
    
    public function lang($lng = 'en'){
         $this->getDbCriteria()->mergeWith(array(
            'with' => 'lng',        
            'condition'=>'lng.prefix= :lng',
            'params'=> array(':lng' => $lng),

        ));

    }
    
    
    public function getPage($page_id,$lng = 'en'){
       $page = Yii::app()->db->createCommand();
        $page->select('label,title,content,meta_description');
        $page->from('page t1');
        $page->join('page_trl t2' ,'t2.page_id=t1.id ');
        $page->join('languages t3' ,'t2.lng_id=t3.id ');
        $page->where("t3.prefix=:prefix and t1.id=:id", array(':prefix' => $lng,':id' => $page_id));
        
        
        $result = $page->queryRow();
      
        return $result; 
    }//get page
    
    
    public function getPageWithImage($page_id,$lng = 'en'){
        
        $sql  = "SELECT * FROM ".$this->tableName();
        $sql .= " WHERE id=".(int)$page_id;
        $sql .= " LIMIT 1";
        $con = $this->dbConnection;
        $arrData = $con->createCommand($sql)->queryRow();
        // if array is empty - finish
        if(empty($arrData)){ return false;}
        
        $sql  = "SELECT t1.id AS link_id, t2.*,t3.caption FROM images_of_page t1 ";
        $sql .= "JOIN images t2 ON t1.image_id = t2.id ";
        $sql .= "JOIN images_trl t3 ON t3.image_id = t2.id ";
        $sql .= "JOIN languages t4 ON t3.lng_id = t4.id " ;
        $sql .= "WHERE t1.page_id = ".(int)$page_id." AND t4.prefix = :prefix";
        
        $sqlParam[':prefix'] = $lng;
        
        $arrData['images'] = $con->createCommand($sql)->queryAll(true,$sqlParam);
        
        return (!empty($arrData))? $arrData : false;
      
    }//getPageWithImage
    
    
}