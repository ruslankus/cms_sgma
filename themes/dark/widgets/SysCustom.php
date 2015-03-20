<?php

class SysCustom extends CWidget
{
    //template of widget
    public $templateName;

    public function run()
    {
        $this->render('custom/'.$this->templateName);
    }
}