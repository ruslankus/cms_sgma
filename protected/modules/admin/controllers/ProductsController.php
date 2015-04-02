<?php
class ProductsController extends ControllerAdmin
{
    public function actionCategories($page = 1)
    {
        $this->renderText('here will be product categories');
    }

    public function actionList($page = 1, $cat = 0)
    {
        $this->renderText('here will product list');
    }
}