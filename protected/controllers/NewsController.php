<?php
/**
 * Class NewsController
 */
class NewsController extends Controller
{

    public $default_item_tpl = "default";
    public $default_list_tpl = "default";
    public $on_page = 10;
    
    public function actionShow($id,$page = 1)
    {
        $category = ExtNewsCategory::model()->findByPk($id);

        if(empty($category))
        {
            throw new CHttpException(404);
        }

        $contentArray = $category->attributes;

        if(!empty($category->trl))
        {
            $this->title = $category->trl->header;
            $this->keywords = $category->trl->meta_description;

            $contentArray['trl_name'] = $category->trl->header;
            $contentArray['trl_description'] = $category->trl->description;
        }
        else
        {
            $contentArray['trl_name'] = '';
            $contentArray['trl_description'] = '';
        }

        $contentArray['items'] = array();
        if(!empty($category->news))
        {
            /* @var $items ExtNews[] */

            $items = CPaginator::getInstance($category->news,$this->on_page,$page)->getPreparedArray();
            
            foreach($items as $i=> $newsItem)
            {
                $contentArray['items'][$i] = $newsItem->attributes;
                $contentArray['items'][$i]['url'] = Yii::app()->createUrl('news/one',array('id' => $newsItem->id));
                $contentArray['items'][$i]['trl_name'] = !empty($newsItem->trl) ? $newsItem->trl->title : '';
                $contentArray['items'][$i]['trl_text'] = !empty($newsItem->trl) ? $newsItem->trl->text : '';
                $contentArray['items'][$i]['trl_summary'] = !empty($newsItem->trl) ? $newsItem->trl->summary : '';
                $contentArray['items'][$i]['trl_meta_des'] = !empty($newsItem->trl) ? $newsItem->trl->meta_description : '';
                $contentArray['items'][$i]['trl_meta_key'] = !empty($newsItem->trl) ? $newsItem->trl->meta_keywords : '';


                $contentArray['items'][$i]['images'] = array();
                if(!empty($newsItem->imagesOfNews))
                {
                    foreach($newsItem->imagesOfNews as $y => $ion)
                    {
                        $contentArray['items'][$i]['images'][$y] = $ion->image->attributes;
                        $contentArray['items'][$i]['images'][$y]['url'] = $ion->image->getUrl();

                        if(!empty($ion->image->trl))
                        {
                            $contentArray['items'][$i]['images'][$y]['trl_caption'] = $ion->image->trl->caption;
                        }
                        else
                        {
                            $contentArray['items'][$i]['images'][$y]['trl_caption'] = '';
                        }
                    }
                }
            }
        }

        //default template
        $template = $this->default_list_tpl;

        //if category has template name
        if(!empty($category->template_name))
        {
            //remove php extension
            $temp = $category->template_name;
            $temp = str_replace(".php","",$temp);

            //if file exist
            if($this->getViewFile('category/'.$temp))
            {
                //set this template
                $template = $temp;
            }
        }


        //render list
        $this->render('category/'.$template,array('content' => $contentArray));
    }
    
}