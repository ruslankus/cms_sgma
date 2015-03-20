<?php

class SysCart extends CWidget
{
    //template of widget
    public $templateName;

    public function run()
    {
        $this->render('cart/'.$this->templateName);
    }
}