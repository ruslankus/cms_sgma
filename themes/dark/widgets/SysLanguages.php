<?php

class SysLanguages extends CWidget
{
    //template of widget
    public $templateName;

    public function run()
    {
        $this->render('languages/'.$this->templateName);
    }
}