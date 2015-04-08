<?php

/**
 * This is the model class for table "product_fields".
 *
 * The followings are the available columns in table 'product_fields':
 * @property integer $id
 * @property string $field_name
 * @property integer $type_id
 * @property integer $group_id
 * @property integer $priority
 * @property integer $time_created
 * @property integer $time_updated
 * @property integer $last_change_by
 *
 * The followings are the available model relations:
 * @property ProductFieldSelectOptions[] $productFieldSelectOptions
 * @property ProductFieldValues[] $productFieldValues
 * @property ProductFieldGroups $group
 * @property ProductFieldTypes $type
 */
class ProductFields extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_fields';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_id, group_id, priority, time_created, time_updated, last_change_by', 'numerical', 'integerOnly'=>true),
			array('field_name', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, field_name, type_id, group_id, priority, time_created, time_updated, last_change_by', 'safe', 'on'=>'search'),
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
			'productFieldSelectOptions' => array(self::HAS_MANY, 'ProductFieldSelectOptions', 'field_id'),
			'productFieldValues' => array(self::HAS_MANY, 'ProductFieldValues', 'field_id'),
			'group' => array(self::BELONGS_TO, 'ProductFieldGroups', 'group_id'),
			'type' => array(self::BELONGS_TO, 'ProductFieldTypes', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'field_name' => 'Field Name',
			'type_id' => 'Type',
			'group_id' => 'Group',
			'priority' => 'Priority',
			'time_created' => 'Time Created',
			'time_updated' => 'Time Updated',
			'last_change_by' => 'Last Change By',
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
		$criteria->compare('field_name',$this->field_name,true);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('time_created',$this->time_created);
		$criteria->compare('time_updated',$this->time_updated);
		$criteria->compare('last_change_by',$this->last_change_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductFields the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
