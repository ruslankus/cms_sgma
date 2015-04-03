<?php
/**
 * Class NewsForm
 */
class NewsForm extends CFormModel
{
    public $label;
    public $status_id;
    public $category_id;
    public $image;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('label, status_id, category_id', 'required'),
            array('label, status_id, category_id', 'safe'),
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
            'parent_id' => ATrl::t()->getLabel('Parent item'),
            'image' => ATrl::t()->getLabel('Image')
        );
    }
}
