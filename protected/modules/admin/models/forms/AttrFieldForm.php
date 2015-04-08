<?php

/**
 * Class AttrFieldForm
 */
class AttrFieldForm extends CFormModel
{
    public $field_name;
    public $type_id;
    public $group_id;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('field_name, type_id, group_id', 'required'),
            array('field_name, type_id, group_id', 'safe')
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
            'group_id' => ATrl::t()->getLabel('Group id')
        );
    }
}
