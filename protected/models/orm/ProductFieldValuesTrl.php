<?php

/**
 * This is the model class for table "product_field_values_trl".
 *
 * The followings are the available columns in table 'product_field_values_trl':
 * @property integer $id
 * @property integer $lng_id
 * @property integer $field_value_id
 * @property string $translatable_text
 *
 * The followings are the available model relations:
 * @property Languages $lng
 * @property ProductFieldValues $fieldValue
 */
class ProductFieldValuesTrl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_field_values_trl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lng_id, field_value_id', 'numerical', 'integerOnly'=>true),
			array('translatable_text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lng_id, field_value_id, translatable_text', 'safe', 'on'=>'search'),
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
			'fieldValue' => array(self::BELONGS_TO, 'ProductFieldValues', 'field_value_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lng_id' => 'Lng',
			'field_value_id' => 'Field Value',
			'translatable_text' => 'Translatable Text',
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
		$criteria->compare('lng_id',$this->lng_id);
		$criteria->compare('field_value_id',$this->field_value_id);
		$criteria->compare('translatable_text',$this->translatable_text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductFieldValuesTrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
