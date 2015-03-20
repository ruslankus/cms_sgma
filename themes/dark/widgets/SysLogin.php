<?php

class SysLogin extends CWidget
{
    //template of widget
    public $templateName;

    public function run()
    {
        $this->render('login/'.$this->templateName);
    }
}