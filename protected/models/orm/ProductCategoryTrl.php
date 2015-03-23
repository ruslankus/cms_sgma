<?php

/**
 * This is the model class for table "product_category_trl".
 *
 * The followings are the available columns in table 'product_category_trl':
 * @property integer $id
 * @property string $header
 * @property string $meta_description
 * @property string $description
 * @property integer $product_category_id
 * @property integer $lng_id
 *
 * The followings are the available model relations:
 * @property Languages $lng
 * @property ProductCategory $productCategory
 */
class ProductCategoryTrl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_category_trl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_category_id, lng_id', 'numerical', 'integerOnly'=>true),
			array('header', 'length', 'max'=>512),
			array('meta_description', 'length', 'max'=>256),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, header, meta_description, description, product_category_id, lng_id', 'safe', 'on'=>'search'),
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
			'lng' => array(self::BELONGS_TO, 'Languages', 'lng_id'),
			'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'header' => 'Header',
			'meta_description' => 'Meta Description',
			'description' => 'Description',
			'product_category_id' => 'Product Category',
			'lng_id' => 'Lng',
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
		$criteria->compare('header',$this->header,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('product_category_id',$this->product_category_id);
		$criteria->compare('lng_id',$this->lng_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductCategoryTrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
