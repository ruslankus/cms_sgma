<?php

/**
 * Class AttrGroupForm
 */
class AttrGroupForm extends CFormModel
{
    public $label;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('label', 'required'),
            array('label', 'safe')
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
        );
    }
}
