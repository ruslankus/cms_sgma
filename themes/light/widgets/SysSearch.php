<?php

class SysSearch extends CWidget
{
    //template of widget
    public $templateName;

    public function run()
    {
        $this->render('search/'.$this->templateName);
    }
}