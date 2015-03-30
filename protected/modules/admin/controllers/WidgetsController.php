<?php

class WidgetsController extends ControllerAdmin
{
    public function actionList($page = 1)
    {
        $this->renderText('Here will be widgets list');
    }
}