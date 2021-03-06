<?php

/**
 * This is the model class for table "product_field_values".
 *
 * The followings are the available columns in table 'product_field_values':
 * @property integer $id
 * @property integer $product_id
 * @property integer $field_id
 * @property integer $numeric_value
 * @property integer $selected_option_id
 * @property string $text_value
 * @property integer $time_value
 *
 * The followings are the available model relations:
 * @property ImagesOfProductFieldsValues[] $imagesOfProductFieldsValues
 * @property Product $product
 * @property ProductFields $field
 * @property ProductFieldValuesTrl[] $productFieldValuesTrls
 */
class ProductFieldValues extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_field_values';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, field_id, numeric_value, selected_option_id, time_value', 'numerical', 'integerOnly'=>true),
			array('text_value', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, field_id, numeric_value, selected_option_id, text_value, time_value', 'safe', 'on'=>'search'),
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
			'imagesOfProductFieldsValues' => array(self::HAS_MANY, 'ImagesOfProductFieldsValues', 'field_value_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'field' => array(self::BELONGS_TO, 'ProductFields', 'field_id'),
			'productFieldValuesTrls' => array(self::HAS_MANY, 'ProductFieldValuesTrl', 'field_value_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'field_id' => 'Field',
			'numeric_value' => 'Numeric Value',
			'selected_option_id' => 'Selected Option',
			'text_value' => 'Text Value',
			'time_value' => 'Time Value',
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('field_id',$this->field_id);
		$criteria->compare('numeric_value',$this->numeric_value);
		$criteria->compare('selected_option_id',$this->selected_option_id);
		$criteria->compare('text_value',$this->text_value,true);
		$criteria->compare('time_value',$this->time_value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductFieldValues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
