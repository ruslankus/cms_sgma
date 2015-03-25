<?php

/**
 * Class AddMenuForm
 */
class AddMenuForm extends CFormModel
{
	public $label;
	public $status_id;
    public $template_name;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('label, status_id, template_name', 'required'),
            array('label, status_id, template_name', 'safe')
        );
	}


    public function attributeLabels()
    {
        return array(
            'label' => ATrl::t()->getLabel('label'),
            'status_id' => ATrl::t()->getLabel('status'),
            'template_name' => ATrl::t()->getLabel('template_name'),
        );
    }
}