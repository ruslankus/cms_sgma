<?php
/**
 * Class ExtProduct
 * @property ExtProductCategory $category
 * @property ProductTrl $trl
 * @property ExtImagesOfProduct[] $imagesOfProducts
 * @property ExtProductFieldGroupsActive[] $productFieldGroupsActives
 * @property ExtTagsOfProduct[] $tagsOfProducts
 */
class ExtProduct extends Product
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
     * @return ProductTrl
     */
    public function getOrCreateTrl($lngId)
    {
        $all = $this->productTrls;

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

        $trl = new ProductTrl();
        $trl -> product_id = $this->id;
        $trl -> lng_id = $lngId;

        return $trl;
    }

    /**
     * Returns first image if exist
     * @return ExtImages|null
     */
    public function getFirstImage()
    {
        if(count($this->imagesOfProducts) > 0)
        {
            return $this->imagesOfProducts[0]->image;
        }

        return null;
    }

    /**
     * Generates unique product code for product
     * @param string $prefix
     * @param string $postfix
     * @param int $size
     * @return int|string
     */
    public function generateUniqueProductCode($prefix = 'PR', $postfix = '', $size = 8)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);

        while(true)
        {
            $randomString = '';
            for ($i = 0; $i < $size; $i++)
            {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $code = $prefix.$randomString.$prefix;
            $count = Product::model()->countByAttributes(array('product_code' => $code));

            if($count == 0)
            {
                return $code;
            }
        }

        return 0;
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
        $relations['trl'] = array(self::HAS_ONE, 'ProductTrl', 'product_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));
        $relations['productFieldGroupsActives'] = array(self::HAS_MANY, 'ExtProductFieldGroupsActive', 'product_id', 'order' => 'priority ASC');

        //return modified relations
        return $relations;
    }
}