<?php
/**
 * Class ComplexPageForm
 */
class ComplexPageForm extends CFormModel
{
    public $label;
    public $status_id;
    public $image;
    public $template_name;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('label, status_id, template_name', 'required'),
            array('label, status_id, template_name', 'safe'),
            array('image', 'file', 'types'=>'jpg, gif, png','allowEmpty' =>true,'maxSize' => 1048576)
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
            'status_id' => ATrl::t()->getLabel('Status'),
            'image' => ATrl::t()->getLabel('Image'),
            'template_name' => ATrl::t()->getLabel('Template')
        );
    }
}
