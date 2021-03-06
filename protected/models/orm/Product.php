<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property integer $category_id
 * @property string $branch
 * @property string $label
 * @property string $template_name
 * @property integer $status_id
 * @property integer $priority
 * @property integer $price
 * @property integer $discount_price
 * @property integer $is_new
 * @property integer $stock_qnt
 * @property integer $time_created
 * @property integer $time_updated
 * @property integer $last_change_by
 * @property string $product_code
 *
 * The followings are the available model relations:
 * @property ImagesOfProduct[] $imagesOfProducts
 * @property ProductCategory $category
 * @property Status $status
 * @property ProductFieldGroupsActive[] $productFieldGroupsActives
 * @property ProductFieldValues[] $productFieldValues
 * @property ProductTrl[] $productTrls
 * @property Rating[] $ratings
 * @property TagsOfProduct[] $tagsOfProducts
 */
class Product extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, status_id, priority, price, discount_price, is_new, stock_qnt, time_created, time_updated, last_change_by', 'numerical', 'integerOnly'=>true),
			array('branch, product_code', 'length', 'max'=>1024),
			array('label', 'length', 'max'=>128),
			array('template_name', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category_id, branch, label, template_name, status_id, priority, price, discount_price, is_new, stock_qnt, time_created, time_updated, last_change_by, product_code', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'imagesOfProducts' => array(self::HAS_MANY, 'ImagesOfProduct', 'product_id'),
			'category' => array(self::BELONGS_TO, 'ProductCategory', 'category_id'),
			'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
			'productFieldGroupsActives' => array(self::HAS_MANY, 'ProductFieldGroupsActive', 'product_id'),
			'productFieldValues' => array(self::HAS_MANY, 'ProductFieldValues', 'product_id'),
			'productTrls' => array(self::HAS_MANY, 'ProductTrl', 'product_id'),
			'ratings' => array(self::HAS_MANY, 'Rating', 'product_id'),
			'tagsOfProducts' => array(self::HAS_MANY, 'TagsOfProduct', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => 'Category',
			'branch' => 'Branch',
			'label' => 'Label',
			'template_name' => 'Template Name',
			'status_id' => 'Status',
			'priority' => 'Priority',
			'price' => 'Price',
			'discount_price' => 'Discount Price',
			'is_new' => 'Is New',
			'stock_qnt' => 'Stock Qnt',
			'time_created' => 'Time Created',
			'time_updated' => 'Time Updated',
			'last_change_by' => 'Last Change By',
			'product_code' => 'Product Code',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('branch',$this->branch,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('template_name',$this->template_name,true);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('price',$this->price);
		$criteria->compare('discount_price',$this->discount_price);
		$criteria->compare('is_new',$this->is_new);
		$criteria->compare('stock_qnt',$this->stock_qnt);
		$criteria->compare('time_created',$this->time_created);
		$criteria->compare('time_updated',$this->time_updated);
		$criteria->compare('last_change_by',$this->last_change_by);
		$criteria->compare('product_code',$this->product_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
