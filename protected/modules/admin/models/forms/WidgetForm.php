<?php

/**
 * Class AddMenuForm
 */
class WidgetForm extends CFormModel
{
    public $label;
    public $type_id;
    public $template_name;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('label, type_id', 'required'),
            array('label, type_id, template_name', 'safe')
        );
    }


    public function attributeLabels()
    {
        return array(
            'label' => ATrl::t()->getLabel('Label'),
            'type_id' => ATrl::t()->getLabel('Type'),
            'template_name' => ATrl::t()->getLabel('Template'),
        );
    }
}
