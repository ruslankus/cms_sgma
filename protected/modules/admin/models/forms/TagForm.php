<?php
/**
 * Class AddMenuForm
 */
class TagForm extends CFormModel
{
	public $label;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('label','required'),
            array('label', 'safe')
        );
	}


    public function attributeLabels()
    {
        return array(
            'label' => ATrl::t()->getLabel('Label')
        );
    }
}
