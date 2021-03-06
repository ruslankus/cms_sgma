<?php

/**
 * This is the model class for table "complex_page".
 *
 * The followings are the available columns in table 'complex_page':
 * @property integer $id
 * @property string $label
 * @property string $template_name
 * @property integer $status_id
 * @property integer $time_created
 * @property integer $time_updated
 * @property integer $last_change_by
 * @property integer $priority
 *
 * The followings are the available model relations:
 * @property Status $status
 * @property ComplexPageFieldGroupsActive[] $complexPageFieldGroupsActives
 * @property ComplexPageFieldValues[] $complexPageFieldValues
 * @property ComplexPageTrl[] $complexPageTrls
 * @property ImagesOfComplexPage[] $imagesOfComplexPages
 */
class ComplexPage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'complex_page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status_id, time_created, time_updated, last_change_by, priority', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>128),
			array('template_name', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, template_name, status_id, time_created, time_updated, last_change_by, priority', 'safe', 'on'=>'search'),
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
			'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
			'complexPageFieldGroupsActives' => array(self::HAS_MANY, 'ComplexPageFieldGroupsActive', 'page_id'),
			'complexPageFieldValues' => array(self::HAS_MANY, 'ComplexPageFieldValues', 'page_id'),
			'complexPageTrls' => array(self::HAS_MANY, 'ComplexPageTrl', 'page_id'),
			'imagesOfComplexPages' => array(self::HAS_MANY, 'ImagesOfComplexPage', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'label' => 'Label',
			'template_name' => 'Template Name',
			'status_id' => 'Status',
			'time_created' => 'Time Created',
			'time_updated' => 'Time Updated',
			'last_change_by' => 'Last Change By',
			'priority' => 'Priority',
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
		$criteria->compare('label',$this->label,true);
		$criteria->compare('template_name',$this->template_name,true);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('time_created',$this->time_created);
		$criteria->compare('time_updated',$this->time_updated);
		$criteria->compare('last_change_by',$this->last_change_by);
		$criteria->compare('priority',$this->priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ComplexPage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
