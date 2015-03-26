<?php

/**
 * Class AddPageForm
 */
class AddPageForm extends CFormModel
{
    public $label;


	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('label', 'required'),          
        );
	}


    public function attributeLabels()
    {
        return array(
            'label' => ATrl::t()->getLabel('label'),           
        );
    }
    
    
}//AddMenuForm    