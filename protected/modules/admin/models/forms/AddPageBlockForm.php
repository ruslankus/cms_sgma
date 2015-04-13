<?php

/**
 * Class AddPageForm
 */
class AddPageBlockForm extends CFormModel
{
    public $page_label;
    public $page_id;
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('page_label, page_id', 'required'),          
        );
	}


    public function attributeLabels()
    {
        return array(
            'label' => ATrl::t()->getLabel('$page_label'),           
        );
    }
    
    
}//AddMenuForm    