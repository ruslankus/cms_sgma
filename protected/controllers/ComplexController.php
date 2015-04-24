<?php
/**
 * Class ComplexController
 */
class ComplexController extends Controller
{
    public $default_item_tpl = "default";

    public function actionShow($id)
    {
        /* @var $groups ExtComplexPageFieldGroups[] */

        //find page - send to 404 if not found
        $page = ExtComplexPage::model()->findByPk($id);

        if(empty($page))
        {
            throw new CHttpException(404);
        }

        //firstly - add to content array of attributes
        $resultContents = $page->attributes;
        $resultContents['images'] = array();
        $resultContents['trl_name'] = '';
        $resultContents['trl_text'] = '';
        $resultContents['trl_meta_keywords'] = '';

        //if exist translation - add translatable texts
        if(!empty($page->trl))
        {
            $this->title = $page->trl->title;
            $this->keywords = $page->trl->meta_keywords;

            $resultContents['trl_name'] = $page->trl->title;
            $resultContents['trl_text'] = $page->trl->text;
            $resultContents['trl_meta_keywords'] = $page->trl->meta_keywords;
        }


        if(!empty($page->imagesOfComplexPages))
        {
            $arrImages = array();
            foreach($page->imagesOfComplexPages as $index => $iop)
            {
                $image = $iop->image;
                $arrImage = $image->attributes;
                $arrImage['url'] = $image->getUrl();
                $arrImage['trl_caption'] = '';

                if(!empty($image->tr))
                {
                    $arrImage['trl_caption'] = $image->trl->caption;
                }

                $arrImages[] = $arrImage;
            }
            $resultContents['images'] = $arrImages;
        }

        //pass through all groups which are active in this page
        foreach($page->complexPageFieldGroupsActives as $ga)
        {
            //get array of attributes of group
            $groupArr = $ga->group->attributes;
            $groupArr['trl_name'] = '';
            $groupArr['trl_description'] = '';

            //if exist translation - add translatable texts
            if(!empty($ga->group->trl))
            {
                $groupArr['trl_name'] = $ga->group->trl->name;
                $groupArr['trl_description'] = $ga->group->trl->description;
            }

            //pass through all fields of this group
            foreach($ga->group->complexPageFields as $field)
            {
                //get array of attributes of field
                $fieldArr = $field->attributes;
                $groupArr['fields'][$field->id] = $fieldArr;
                $groupArr['fields'][$field->id]['type'] = $field->type->label;
                $groupArr['fields'][$field->id]['trl_title'] = '';
                $groupArr['fields'][$field->id]['trl_description'] = '';

                //if exist translation - add translatable texts
                if(!empty($field->trl))
                {
                    $groupArr['fields'][$field->id]['trl_title'] = $field->trl->field_title;
                    $groupArr['fields'][$field->id]['trl_description'] = $field->trl->field_description;
                }

                //get value of this field for this page
                $value = $field->getValueObjForItem($page->id);
                $valueField = '';
                switch($field->type_id)
                {
                    case ExtComplexPageFieldTypes::TYPE_NUMERIC:
                        $valueField = $value->numeric_value;
                        break;

                    case ExtComplexPageFieldTypes::TYPE_SELECTABLE:
                        $options = $field->complexPageFieldSelectOptions;

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
                        $iof = $value->imagesOfComplexPageFieldValues;

                        foreach($iof as $iofItem)
                        {
                            $image = $iofItem->image;
                            $valueField = !empty($image) ? $image->attributes : '';
                            $valueField['trl_caption'] = !empty($image->trl) ? $image->trl->caption : '';
                            $valueField['url'] = !empty($image) ? $image->getUrl() : '';
                        }
                        break;

                }

                $groupArr['fields'][$field->id]['value_obj_attributes'] = $value->attributes;
                $groupArr['fields'][$field->id]['value'] = $valueField;
            }

            $resultContents['groups'][$ga->group_id] = $groupArr;
            $groups[] = $ga->group;
        }


        //default template
        $template = $this->default_item_tpl;

        //if category has template name
        if(!empty($page->template_name))
        {
            //remove php extension
            $temp = $page->template_name;
            $temp = str_replace(".php","",$temp);

            //if file exist
            if($this->getViewFile($temp))
            {
                //set this template
                $template = $temp;
            }
        }

        //render contents
        $this->render($template,array('content' => $resultContents));
    }
}