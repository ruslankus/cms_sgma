<?php

/**
 * Class AttrFieldForm
 */
class AttrFieldForm extends CFormModel
{
    public $field_name;
    public $type_id;
    public $group_id;
    public $use_editor;
    public $img_w;
    public $img_h;
    public $img_fit;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('field_name, type_id, group_id', 'required'),
            array('field_name, type_id, group_id, use_editor, img_w, img_h, img_fit', 'safe'),
            array('img_w, img_h','numerical','integerOnly' => true),
        );
    }


    /**
     * Labels
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'field_name' => ATrl::t()->getLabel('Field name'),
            'type_id' => ATrl::t()->getLabel('Field type'),
            'group_id' => ATrl::t()->getLabel('Group'),
            'use_editor' => ATrl::t()->getLabel('WSYG editor'),
            'img_w' => ATrl::t()->getLabel('Cache width'),
            'img_h' => ATrl::t()->getLabel('Cache height'),
            'img_fit' => ATrl::t()->getLabel('Fit'),
            'img_sizes' => ATrl::t()->getLabel('Cached sizes')
        );
    }
}
