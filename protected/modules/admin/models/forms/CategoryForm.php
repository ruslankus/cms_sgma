<?php
/**
 * Class CategoryForm
 */
class CategoryForm extends CFormModel
{
    public $label;
    public $status_id;
    public $parent_id;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('label, status_id, parent_id', 'required'),
            array('label, status_id, parent_id', 'safe')
        );
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
            'parent_id' => ATrl::t()->getLabel('Parent item'),
        );
    }
}
