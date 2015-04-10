<?php

/**
 * Class AddPageForm
 */
class AddPageForm extends CFormModel
{
    public $page_label;
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('page_label', 'required'),          
        );
	}


    public function attributeLabels()
    {
        return array(
            'label' => ATrl::t()->getLabel('$page_label'),           
        );
    }
    
    
}//AddMenuForm    