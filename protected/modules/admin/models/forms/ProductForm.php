<?php
/**
 * Class NewsForm
 */
class ProductForm extends CFormModel
{
    public $label;
    public $status_id;
    public $category_id;
    public $image;
    public $template_name;
    public $is_new;
    public $price;
    public $discount_price;
    public $stock_qnt;
    public $product_code;
    public $selected_tags;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('label, status_id, category_id, product_code', 'required'),
            array('label, status_id, category_id, template_name, price, discount_price, stock_qnt, product_code, is_new', 'safe'),
            array('price, discount_price','numerical'),
            array('stock_qnt','numerical','integerOnly' => true),
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
            'image' => ATrl::t()->getLabel('Image'),
            'template_name' => ATrl::t()->getLabel('Template'),
            'price' => ATrl::t()->getLabel('Price'),
            'discount_price' => ATrl::t()->getLabel('Discount price'),
            'stock_qnt' => ATrl::t()->getLabel('Quantity in stock'),
            'product_code' => ATrl::t()->getLabel('Product code'),
            'selected_tags' => ATrl::t()->getLabel('Selected tags'),
            'is_new' => ATrl::t()->getLabel('New product'),
        );
    }
}
