<?php

/**
 * Class AddPageForm
 */
class AddPageFieldForm extends CFormModel
{
    public $page_label;
    public $block_id;
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('page_label, block_id', 'required'),          
        );
	}


    public function attributeLabels()
    {
        return array(
            'label' => ATrl::t()->getLabel('$page_label'),           
        );
    }
    
    
}//AddMenuForm    