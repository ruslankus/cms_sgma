<?php
Class ExtLetters extends Letters
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function pageMenu(){
    	$id = $this->page_id;
    	$objMenu = MenuItem::model()->findByAttributes(array('content_item_id'=>$id,'type_id'=>4));
    	return $objMenu->label;
    }
}