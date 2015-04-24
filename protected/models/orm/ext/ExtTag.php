<?php
/**
 * Class ExtTag
 * @property TagTrl $trl
 * @property ExtTagsOfProduct[] $tagsOfProducts
 */
class ExtTag extends Tag
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
     * @return TagTrl
     */
    public function getTrl($lngId)
    {
        $all = $this->tagTrls;

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

        $trl = new TagTrl();
        $trl -> tag_id = $this->id;
        $trl -> lng_id = $lngId;

        return $trl;
    }

    /**
     * Returns list for select-boxes or list-check-boxes in forms
     * @param bool $translate
     * @return array
     */
    public function getListForForms($translate = false)
    {
        /* @var $all self[] */

        $all = self::model()->findAll();
        $result = array();

        foreach($all as $tag)
        {
            if(!$translate)
            {
                $result[$tag->id] = $tag->label;
            }
            else
            {
                $result[$tag->id] = !empty($tag->trl) ? $tag->trl->name : '';
            }
        }

        return $result;
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
        $relations['trl'] = array(self::HAS_ONE, 'TagTrl', 'tag_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}
