<?php
Class ExtAdminLanguages extends AdminLanguages
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