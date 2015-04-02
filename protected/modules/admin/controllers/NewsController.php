<?php
class NewsController extends ControllerAdmin
{
    public function actionCategories($page = 1)
    {
        $this->renderText('here will be news categories');
    }

    public function actionList($page = 1, $cat = 0)
    {
        $this->renderText('here will be news list');
    }
}