<?php
/**
 * Class AddMenuForm
 */
class TagForm extends CFormModel
{
	public $label;
    public $image;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
        return array(
            array('label','required'),
            array('label', 'safe'),
            array('image', 'file', 'types'=>'jpg, gif, png','allowEmpty' =>true,'maxSize' => 1048576)
        );
	}


    public function attributeLabels()
    {
        return array(
            'label' => ATrl::t()->getLabel('Label'),
            'image' => ATrl::t()->getLabel('Tag thumbnail')
        );
    }
}
