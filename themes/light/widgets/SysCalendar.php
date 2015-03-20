<?php

class SysCalendar extends CWidget
{
    //template of widget
    public $templateName;

    public function run()
    {
        $this->render('calendar/'.$this->templateName);
    }
}