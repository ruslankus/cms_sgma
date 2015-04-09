<?php

/**
 * This is the model class for table "product_fields_trl".
 *
 * The followings are the available columns in table 'product_fields_trl':
 * @property integer $id
 * @property integer $product_field_id
 * @property integer $lng_id
 * @property string $field_description
 * @property string $field_title
 *
 * The followings are the available model relations:
 * @property ProductFields $productField
 * @property Languages $lng
 */
class ProductFieldsTrl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_fields_trl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_field_id, lng_id', 'numerical', 'integerOnly'=>true),
			array('field_description, field_title', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_field_id, lng_id, field_description, field_title', 'safe', 'on'=>'search'),
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
			'productField' => array(self::BELONGS_TO, 'ProductFields', 'product_field_id'),
			'lng' => array(self::BELONGS_TO, 'Languages', 'lng_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_field_id' => 'Product Field',
			'lng_id' => 'Lng',
			'field_description' => 'Field Description',
			'field_title' => 'Field Title',
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
		$criteria->compare('product_field_id',$this->product_field_id);
		$criteria->compare('lng_id',$this->lng_id);
		$criteria->compare('field_description',$this->field_description,true);
		$criteria->compare('field_title',$this->field_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductFieldsTrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
