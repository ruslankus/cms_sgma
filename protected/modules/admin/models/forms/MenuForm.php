<?php

/**
 * Class AddMenuForm
 */
class MenuForm extends CFormModel
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
            'label' => ATrl::t()->getLabel('Label'),
            'status_id' => ATrl::t()->getLabel('Status'),
            'template_name' => ATrl::t()->getLabel('Template'),
        );
    }
}
