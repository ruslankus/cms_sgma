<?php

/**
 * Class ExtComplexPage
 * @property ExtComplexPageFieldGroupsActive[] $complexPageFieldGroupsActives
 * @property ExtComplexPageFieldValues[] $complexPageFieldValues
 * @property ExtImagesOfComplexPage[] $imagesOfComplexPages
 * @property ComplexPageTrl $trl
 */
class ExtComplexPage extends ComplexPage
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
     * @return ComplexPageTrl
     */
    public function getOrCreateTrl($lngId)
    {
        $all = $this->complexPageTrls;

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

        $trl = new ComplexPageTrl();
        $trl -> page_id = $this->id;
        $trl -> lng_id = $lngId;

        return $trl;
    }

    /**
     * Returns first image if exist
     * @return ExtImages|null
     */
    public function getFirstImage()
    {
        if(count($this->imagesOfComplexPages) > 0)
        {
            return $this->imagesOfComplexPages[0]->image;
        }

        return null;
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
        $relations['trl'] = array(self::HAS_ONE, 'ComplexPageTrl', 'page_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));
        $relations['complexPageFieldGroupsActives'] = array(self::HAS_MANY, 'ExtComplexPageFieldGroupsActive', 'page_id', 'order' => 'priority DESC');

        //return modified relations
        return $relations;
    }

}