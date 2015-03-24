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
    
    
    public function getPage(){
       $page = Yii::app()->db->createCommand();
        $page->select('label,header,content,meta_description');
        $page->from('page t1');
        $page->join('page_trl t2' ,'t2.article_id=t1.id ');
        $page->join('languages t3' ,'t2.lng_id=t3.id ');
        $page->where("t3.prefix=:prefix", array(':prefix' => 'ru'));
        
        $result = $page->queryRow();
        Debug::d($result);
        return $result; 
    }
    
    
}