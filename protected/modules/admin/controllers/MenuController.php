<?php

class MenuController extends ControllerAdmin
{
    /**
     * Index - list all menu
     */
    public function actionIndex()
    {
        /* @var $menus ExtMenu[] */
        $menus = ExtMenu::model()->findAll();
        $this->render('index',array('menus' => $menus));
    }


    /**
     * List  all items and other settings of menu
     * @param $id
     * @param int $page
     * @throws CHttpException
     */
    public function actionEditMenu($id,$page = 1)
    {
        //find menu
        $menu = ExtMenu::model()->findByPk((int)$id);

        //if noy found
        if(empty($menu))
        {
            throw new CHttpException(404);
        }

        //get all items
        $items = $menu->getArrayRecursive();

        //pager stuff
        $perPage = 10;
        $total_pages = (int)ceil(count($items)/$perPage);
        $offset = (int)($perPage * ($page - 1));
        $itemsOfPage = array_slice($items,$offset,$perPage);

        //currently selected theme
        $selectedTheme = 'dark'; //TODO: select theme from DB

        //get all templates for menus
        $themeManager = Yii::app()->themeManager;
        $dir = $themeManager->basePath.DS.$selectedTheme.DS.'views'.DS.'menus';
        $files = scandir($dir);
        $templates = array();

        foreach($files as $fileName)
        {
            if($fileName != ".." && $fileName != ".")
            {
                $templates[] = $fileName;
            }
        }

        $this->render('edit_menu',array('items' => $itemsOfPage, 'pages' => $total_pages, 'templates' => $templates));
    }
}