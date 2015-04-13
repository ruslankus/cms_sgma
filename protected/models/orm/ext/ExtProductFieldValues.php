<?php
/**
 * Class ExtProductFieldValues
 * @property ExtImagesOfProductFieldsValues[] $imagesOfProductFieldsValues
 * @property ExtProductFields $field
 * @property ExtProduct $product
 */
class ExtProductFieldValues extends ProductFieldValues
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
     * @return ProductFieldValuesTrl
     */
    public function getOrCreateTrl($lngId)
    {
        $all = $this->productFieldValuesTrls;

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

        $trl = new ProductFieldValuesTrl();
        $trl -> field_value_id = $this->id;
        $trl -> lng_id = $lngId;

        return $trl;
    }

    /**
     * Does saving or updating record if exist in db
     */
    public function saveOrUpdate()
    {
        if($this->isNewRecord)
        {
            $this->save();
        }
        else
        {
            $this->update();
        }
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