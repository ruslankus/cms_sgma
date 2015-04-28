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
                $contentArray['items'][$i]['url'] = Yii::app()->createUrl('products/one',array('id' => $product->id));
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

                $contentArray['items'][$i]['tags'] = array();
                if(!empty($product->tagsOfProducts))
                {
                    foreach($product->tagsOfProducts as $j => $top)
                    {
                        $contentArray['items'][$i]['tags'][$j] = $top->tag->attributes;
                        $contentArray['items'][$i]['tags'][$j]['trl_name'] = !empty($top->tag->trl) ? $top->tag->trl->name : '';
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
        if(!empty($product->imagesOfProducts))
        {
            foreach($product->imagesOfProducts as $y => $iop)
            {
                $contentArray['images'][$y] = $iop->image->attributes;
                $contentArray['images'][$y]['url'] = $iop->image->getUrl();

                if(!empty($iop->image->trl))
                {
                    $contentArray['images'][$y]['trl_caption'] = $iop->image->trl->caption;
                }
                else
                {
                    $contentArray['images'][$y]['trl_caption'] = '';
                }
            }
        }

        $contentArray['tags'] = array();
        if(!empty($product->tagsOfProducts))
        {
            foreach($product->tagsOfProducts as $j => $top)
            {
                $contentArray['tags'][$j] = $top->tag->attributes;
                $contentArray['tags'][$j]['trl_name'] = !empty($top->tag->trl) ? $top->tag->trl->name : '';
            }
        }

        $contentArray['attribute_groups'] = array();
        if(!empty($product->productFieldGroupsActives))
        {
            foreach($product->productFieldGroupsActives as $g => $gop)
            {
                $group = $gop->group;
                $contentArray['attribute_groups'][$g] = $group->attributes;
                $contentArray['attribute_groups'][$g]['trl_name'] = !empty($group->trl) ? $group->trl->name : '';
                $contentArray['attribute_groups'][$g]['trl_text'] = !empty($group->trl) ? $group->trl->description : '';

                $contentArray['attribute_groups'][$g]['attributes'] = array();
                foreach($group->productFields as $a => $field)
                {
                    $contentArray['attribute_group'][$g]['attributes'][$a] = $field->attributes;
                    $contentArray['attribute_group'][$g]['attributes'][$a]['trl_name'] = '';
                    $contentArray['attribute_group'][$g]['attributes'][$a]['trl_description'] = '';

                    if(!empty($field->trl))
                    {
                        $contentArray['attribute_group'][$g]['attributes'][$a]['trl_name'] = $field->trl->field_title;
                        $contentArray['attribute_group'][$g]['attributes'][$a]['trl_description'] = $field->trl->field_description;
                    }

                    $contentArray['attribute_group'][$g]['attributes'][$a]['value'] = null;
                    $contentArray['attribute_group'][$g]['attributes'][$a]['value_obj_attributes'] = array();

                    //get value of this field for this product
                    $value = $field->getValueObjForItem($product->id);

                    if(!empty($value))
                    {
                        $valueField = '';
                        switch($field->type_id)
                        {
                            case ExtComplexPageFieldTypes::TYPE_NUMERIC:
                                $valueField = $value->numeric_value;
                                break;

                            case ExtComplexPageFieldTypes::TYPE_SELECTABLE:
                                $options = $field->productFieldSelectOptions;

                                foreach($options as $option)
                                {
                                    if($option->id == $value->selected_option_id)
                                    {
                                        $valueField = array('option_name' => $option->option_name, 'option_value' => $option->option_value);
                                    }
                                }
                                break;

                            case ExtComplexPageFieldTypes::TYPE_DATE:
                                $valueField = $value->time_value;
                                break;

                            case ExtComplexPageFieldTypes::TYPE_TRL_TEXT:
                                $valueField = !empty($value->trl) ? $value->trl->translatable_text : '';
                                break;

                            case ExtComplexPageFieldTypes::TYPE_TEXT:
                                $valueField = $value->text_value;
                                break;

                            case ExtComplexPageFieldTypes::TYPE_IMAGES:
                                $iof = $value->imagesOfProductFieldsValues;

                                foreach($iof as $iofItem)
                                {
                                    /* @var $image ExtImages */

                                    $image = $iofItem->image;
                                    $valueField = !empty($image) ? $image->attributes : '';
                                    $valueField['trl_caption'] = !empty($image->trl) ? $image->trl->caption : '';
                                    $valueField['url'] = !empty($image) ? $image->getUrl() : '';
                                }
                                break;
                        }

                        $contentArray['attribute_group'][$g]['attributes'][$a]['value'] = $valueField;
                        $contentArray['attribute_group'][$g]['attributes'][$a]['value_obj_attributes'] = $value->attributes;
                    }

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