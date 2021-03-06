<?php

/**
 * This is the model class for table "page".
 *
 * The followings are the available columns in table 'page':
 * @property integer $id
 * @property string $label
 * @property integer $status_id
 * @property integer $priority
 * @property integer $time_created
 * @property integer $time_update
 * @property integer $last_change_by
 * @property string $template_name
 *
 * The followings are the available model relations:
 * @property ImagesOfPage[] $imagesOfPages
 * @property Status $status
 * @property PageTrl[] $pageTrls
 */
class Page extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status_id, priority, time_created, time_update, last_change_by', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>128),
			array('template_name', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, status_id, priority, time_created, time_update, last_change_by, template_name', 'safe', 'on'=>'search'),
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
			'imagesOfPages' => array(self::HAS_MANY, 'ImagesOfPage', 'page_id'),
			'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
			'pageTrls' => array(self::HAS_MANY, 'PageTrl', 'page_id'),
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
			'status_id' => 'Status',
			'priority' => 'Priority',
			'time_created' => 'Time Created',
			'time_update' => 'Time Update',
			'last_change_by' => 'Last Change By',
			'template_name' => 'Template Name',
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
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('time_created',$this->time_created);
		$criteria->compare('time_update',$this->time_update);
		$criteria->compare('last_change_by',$this->last_change_by);
		$criteria->compare('template_name',$this->template_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Page the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
