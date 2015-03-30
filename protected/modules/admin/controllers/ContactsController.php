<?php

class ContactsController extends ControllerAdmin
{
    public function actionList($page = 1)
    {
        $this->renderText('Here will be contact page list');
    }
}