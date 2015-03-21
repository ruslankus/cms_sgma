<?php

Class ExtSystemWidget extends SystemWidget
{
    /**
     * @var SystemWidgetTrl
     */
    private $trl = null;

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Find translation of object for current language (singleton-like style)
     * @return SystemWidgetTrl
     */
    public function getTrl()
    {
        if($this->trl == null)
        {
            /* @var $translations SystemWidgetTrl[] */

            //empty translation object
            $this->trl = new SystemWidgetTrl();

            //get all translation
            $translations = $this->systemWidgetTrls;

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

        return $this->trl;
    }
}