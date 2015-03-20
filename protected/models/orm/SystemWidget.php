<?php

/**
 * This is the model class for table "system_widget".
 *
 * The followings are the available columns in table 'system_widget':
 * @property integer $id
 * @property string $label
 * @property integer $type_id
 * @property string $template_name
 *
 * The followings are the available model relations:
 * @property SystemWidgetType $type
 * @property SystemWidgetTrl[] $systemWidgetTrls
 * @property WidRegistration[] $widRegistrations
 */
class SystemWidget extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'system_widget';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_id', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>128),
			array('template_name', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, type_id, template_name', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'SystemWidgetType', 'type_id'),
			'systemWidgetTrls' => array(self::HAS_MANY, 'SystemWidgetTrl', 'widget_id'),
			'widRegistrations' => array(self::HAS_MANY, 'WidRegistration', 'widget_id'),
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
			'type_id' => 'Type',
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
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('template_name',$this->template_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SystemWidget the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
