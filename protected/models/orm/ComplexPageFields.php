<?php

/**
 * This is the model class for table "complex_page_fields".
 *
 * The followings are the available columns in table 'complex_page_fields':
 * @property integer $id
 * @property string $field_name
 * @property integer $type_id
 * @property integer $group_id
 * @property integer $priority
 * @property integer $time_created
 * @property integer $time_updated
 * @property integer $last_change_by
 * @property integer $use_editor
 * @property integer $img_w
 * @property integer $img_h
 * @property integer $img_fit
 *
 * The followings are the available model relations:
 * @property ComplexPageFieldSelectOptions[] $complexPageFieldSelectOptions
 * @property ComplexPageFieldValues[] $complexPageFieldValues
 * @property ComplexPageFieldGroups $group
 * @property ComplexPageFieldTypes $type
 * @property ComplexPageFieldsTrl[] $complexPageFieldsTrls
 */
class ComplexPageFields extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'complex_page_fields';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_id, group_id, priority, time_created, time_updated, last_change_by, use_editor, img_w, img_h, img_fit', 'numerical', 'integerOnly'=>true),
			array('field_name', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, field_name, type_id, group_id, priority, time_created, time_updated, last_change_by, use_editor, img_w, img_h, img_fit', 'safe', 'on'=>'search'),
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
			'complexPageFieldSelectOptions' => array(self::HAS_MANY, 'ComplexPageFieldSelectOptions', 'field_id'),
			'complexPageFieldValues' => array(self::HAS_MANY, 'ComplexPageFieldValues', 'field_id'),
			'group' => array(self::BELONGS_TO, 'ComplexPageFieldGroups', 'group_id'),
			'type' => array(self::BELONGS_TO, 'ComplexPageFieldTypes', 'type_id'),
			'complexPageFieldsTrls' => array(self::HAS_MANY, 'ComplexPageFieldsTrl', 'page_field_id'),
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
			'use_editor' => 'Use Editor',
			'img_w' => 'Img W',
			'img_h' => 'Img H',
			'img_fit' => 'Img Fit',
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
		$criteria->compare('use_editor',$this->use_editor);
		$criteria->compare('img_w',$this->img_w);
		$criteria->compare('img_h',$this->img_h);
		$criteria->compare('img_fit',$this->img_fit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ComplexPageFields the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
