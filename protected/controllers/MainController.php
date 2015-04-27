<?php
/**
 * Class MainController
 */
class MainController extends Controller
{
    /**
     * Main site-entry
     */
    public function actionIndex()
    {
        /* @var $item ExtMenuItem */

        //get home page menu-item id (site redirects us to it at first visit)
        $home_page_id = ExtSettings::model()->getSetting('home_page_item');

        //if some items found in DB
        if(ExtMenuItem::model()->count() > 0)
        {
            //get menu
            $item = ExtMenuItem::model()->findByPk((int)$home_page_id);

            //if item not found (for example was deleted)
            if(empty($item))
            {
                //get first item
                $item = ExtMenu::model()->find();
            }

            //if item not related with content
            if(empty($item->content_item_id))
            {
                $this->renderText(Trl::t()->getMsg('Your menu item is not related with any content'));
                Yii::app()->end();
            }

            //create url
            $defaultAction = 'show';
            $controllerMatches = array(
                ExtMenuItemType::TYPE_SINGLE_PAGE => 'pages',
                ExtMenuItemType::TYPE_NEWS_CATALOG => 'news',
                ExtMenuItemType::TYPE_PRODUCTS_CATALOG => 'products',
                ExtMenuItemType::TYPE_CONTACT_FORM => 'contacts',
                ExtMenuItemType::TYPE_COMPLEX_PAGE => 'complex'
            );

            $url = Yii::app()->createUrl($controllerMatches[$item->type_id].'/'.$defaultAction,array('id' => $item->content_item_id));

            //redirect to home page
            $this->redirect($url);
        }
        else
        {
            $this->renderText(Trl::t()->getMsg('You have no menu items'));
            Yii::app()->end();
        }

    }
}