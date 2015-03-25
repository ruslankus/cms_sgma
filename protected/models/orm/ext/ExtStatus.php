<?php
class ExtStatus extends Status
{

    //all of this constants are correspond to ID's in table 'status'
    const VISIBLE = 1;
    const HIDDEN = 2;
    const DELETED = 3;
    const SUSPENDED = 4;
    const WAITS_FOR_ACTIVATION = 5;

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Prepare array special for add-menu form
     * @param bool $translate
     * @return array
     */
    public function arrayForMenuForm($translate = false)
    {
        //ignore statuses which shouldn't be in array
        $ignore = array(
            self::SUSPENDED,
            self::WAITS_FOR_ACTIVATION,
            self::DELETED
        );

        //result
        return $this->arrayForForm($ignore,$translate);
    }

    /**
     * Returns prepared array for using in Yii forms
     * @param array $ignore
     * @param bool $translate
     * @return array
     */
    public function arrayForForm($ignore = array(),$translate = false)
    {
        //result
        $arr = array();

        /* @var $all self[] */
        $all = self::model()->findAll();

        //pass through all
        foreach($all as $status)
        {
            //if status not ignored
            if(!in_array($status->id,$ignore))
            {
                //add it to array (with translation or just label - depends on $translate value)
                $arr[$status->id] = $translate == false ? $status->label : ATrl::t()->getLabel($status->label);
            }
        }

        return $arr;
    }

}