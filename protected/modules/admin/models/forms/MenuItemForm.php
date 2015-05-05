<?php

/**
 * Class AddMenuForm
 */
class MenuItemForm extends CFormModel
{
    public $label;
    public $status_id;
    public $type_id;
    public $content_item_id;
    public $parent_id;
    public $menu_id;
    public $link_string;

    public $rules_for_link = false;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        $regular = array(
            array('label, status_id, content_item_id, parent_id, menu_id, type_id', 'required'),
            array('label, status_id, content_item_id, parent_id, menu_id, type_id', 'safe')
        );

        $linkType = array(
            array('label, status_id, parent_id, menu_id, type_id, link_string', 'required'),
            array('label, status_id, parent_id, menu_id, type_id, link_string', 'safe')
        );

        return $this->rules_for_link ? $linkType : $regular;
    }

    /**
     * Labels
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'label' => ATrl::t()->getLabel('Label'),
            'status_id' => ATrl::t()->getLabel('Status'),
            'page_id' => ATrl::t()->getLabel('Page'),
            'product_cat_id' => ATrl::t()->getLabel('Product category'),
            'news_cat_id' => ATrl::t()->getLabel('News category'),
            'content_item_id' => ATrl::t()->getLabel('Content item'),
            'parent_id' => ATrl::t()->getLabel('Parent item'),
            'menu_id' => ATrl::t()->getLabel('Menu'),
            'type_id' => ATrl::t()->getLabel('Type'),
            'link_string' => ATrl::t()->getLabel('Url')
        );
    }
}
