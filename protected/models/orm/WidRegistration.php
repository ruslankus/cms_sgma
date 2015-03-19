<?php

/**
 * This is the model class for table "wid_registration".
 *
 * The followings are the available columns in table 'wid_registration':
 * @property integer $id
 * @property integer $obj_id
 * @property integer $type_id
 * @property integer $position_nr
 * @property integer $priority
 * @property integer $status_id
 *
 * The followings are the available model relations:
 * @property WidRegistrationType $type
 * @property Menu $obj
 */
class WidRegistration extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wid_registration';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obj_id, type_id, position_nr, priority, status_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, obj_id, type_id, position_nr, priority, status_id', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'WidRegistrationType', 'type_id'),
			'obj' => array(self::BELONGS_TO, 'Menu', 'obj_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'obj_id' => 'Obj',
			'type_id' => 'Type',
			'position_nr' => 'Position Nr',
			'priority' => 'Priority',
			'status_id' => 'Status',
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
		$criteria->compare('obj_id',$this->obj_id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('position_nr',$this->position_nr);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WidRegistration the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
