<?php
/**
 * Class ExtNews
 * @property ExtNewsCategory $category
 * @property NewsTrl $trl
 * @property ExtImagesOfNews[] $imagesOfNews
 */
class ExtNews extends News
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
     * Returns trl or creates it if not found
     * @param $lngId
     * @return NewsTrl
     */
    public function getOrCreateTrl($lngId)
    {
        $all = $this->newsTrls;

        if(!empty($all))
        {
            foreach($all as $trl)
            {
                if($trl->lng_id == $lngId)
                {
                    return $trl;
                }
            }
        }

        $trl = new NewsTrl();
        $trl -> news_id = $this;
        $trl -> lng_id = $lngId;

        return $trl;
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
        $relations['trl'] = array(self::HAS_ONE, 'NewsTrl', 'news_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}