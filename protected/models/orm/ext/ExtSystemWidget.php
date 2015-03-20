<?php

Class ExtSystemWidget extends SystemWidget
{
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}