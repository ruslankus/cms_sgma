<?php
/**
 * Class ProductsController
 */
class ProductsController extends Controller
{

    public $default_item_tpl = "default";
    public $default_list_tpl = "default";
    public $on_page = 10;

    /**
     * Render list of all items in category
     * @param $id
     * @param int $page
     * @throws CHttpException
     */
    public function actionShow($id,$page = 1)
    {
        $category = ExtProductCategory::model()->findByPk($id);

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
        if(!empty($category->products))
        {
            /* @var $items ExtProduct[] */

            $products = $category->allRelatedItems(true,true);
            $items = CPaginator::getInstance($products,$this->on_page,$page)->getPreparedArray();

            foreach($items as $i=> $product)
            {
                $contentArray['items'][$i] = $product->attributes;
                $contentArray['items'][$i]['url'] = Yii::app()->createUrl('news/one',array('id' => $product->id));
                $contentArray['items'][$i]['trl_name'] = !empty($product->trl) ? $product->trl->title : '';
                $contentArray['items'][$i]['trl_text'] = !empty($product->trl) ? $product->trl->text : '';
                $contentArray['items'][$i]['trl_summary'] = !empty($product->trl) ? $product->trl->summary : '';
                $contentArray['items'][$i]['trl_meta_des'] = !empty($product->trl) ? $product->trl->meta_description : '';
                $contentArray['items'][$i]['trl_meta_key'] = !empty($product->trl) ? $product->trl->meta_keywords : '';


                $contentArray['items'][$i]['images'] = array();
                if(!empty($product->imagesOfProducts))
                {
                    foreach($product->imagesOfProducts as $y => $iop)
                    {
                        $contentArray['items'][$i]['images'][$y] = $iop->image->attributes;
                        $contentArray['items'][$i]['images'][$y]['url'] = $iop->image->getUrl();

                        if(!empty($iop->image->trl))
                        {
                            $contentArray['items'][$i]['images'][$y]['trl_caption'] = $iop->image->trl->caption;
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


    /**
     * Renders content of one item
     * @param $id
     * @throws CHttpException
     */
    public function actionOne($id)
    {
        $product = ExtProduct::model()->findByPk($id);

        if(empty($product))
        {
            throw new CHttpException(404);
        }

        $contentArray = $product->attributes;
        $contentArray['url'] = Yii::app()->createUrl('news/one',array('id' => $product->id));
        $contentArray['trl_name'] = !empty($product->trl) ? $product->trl->title : '';
        $contentArray['trl_text'] = !empty($product->trl) ? $product->trl->text : '';
        $contentArray['trl_summary'] = !empty($product->trl) ? $product->trl->summary : '';
        $contentArray['trl_meta_des'] = !empty($product->trl) ? $product->trl->meta_description : '';
        $contentArray['trl_meta_key'] = !empty($product->trl) ? $product->trl->meta_keywords : '';


        $contentArray['images'] = array();
        if(!empty($product->imagesOfNews))
        {
            foreach($product->imagesOfNews as $y => $ion)
            {
                $contentArray['images'][$y] = $ion->image->attributes;
                $contentArray['images'][$y]['url'] = $ion->image->getUrl();

                if(!empty($ion->image->trl))
                {
                    $contentArray['images'][$y]['trl_caption'] = $ion->image->trl->caption;
                }
                else
                {
                    $contentArray['images'][$y]['trl_caption'] = '';
                }
            }
        }


        //default template
        $template = $this->default_item_tpl;

        //if category has template name
        if(!empty($product->template_name))
        {
            //remove php extension
            $temp = $product->template_name;
            $temp = str_replace(".php","",$temp);

            //if file exist
            if($this->getViewFile('category/'.$temp))
            {
                //set this template
                $template = $temp;
            }
        }

        //render list
        $this->render('item/'.$template,array('content' => $contentArray));
    }

}