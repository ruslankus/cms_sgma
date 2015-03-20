<?php

Class ExtMenu extends Menu
{
    /**
     * @var MenuTrl
     */
    public $trl;

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    /**
     * Find translation of object for current language
     */
    private function findTranslation()
    {
        /* @var $translations MenuTrl[] */

        //empty translation object
        $this->trl = new MenuTrl();

        //get all translation
        $translations = $this->menuTrls;

        //if found something
        if(!empty($translations))
        {
            //pass all translations
            foreach($translations as $translation)
            {
                //if found translation for current language
                if($translation->lng->prefix == Yii::app()->language)
                {
                    //get it
                    $this->trl = $translation;
                }
            }
        }
    }

    public function __construct($scenario='insert')
    {
        parent::__construct($scenario);
        $this->findTranslation();
    }
}