<?php

/**
 * This is the model class for table "system_widget_trl".
 *
 * The followings are the available columns in table 'system_widget_trl':
 * @property integer $id
 * @property string $custom_name
 * @property string $custom_html
 * @property integer $widget_id
 * @property integer $lng_id
 *
 * The followings are the available model relations:
 * @property SystemWidget $widget
 * @property Languages $lng
 */
class SystemWidgetTrl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'system_widget_trl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('widget_id, lng_id', 'numerical', 'integerOnly'=>true),
			array('custom_name', 'length', 'max'=>256),
			array('custom_html', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, custom_name, custom_html, widget_id, lng_id', 'safe', 'on'=>'search'),
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
			'widget' => array(self::BELONGS_TO, 'SystemWidget', 'widget_id'),
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
			'custom_name' => 'Custom Name',
			'custom_html' => 'Custom Html',
			'widget_id' => 'Widget',
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
		$criteria->compare('custom_name',$this->custom_name,true);
		$criteria->compare('custom_html',$this->custom_html,true);
		$criteria->compare('widget_id',$this->widget_id);
		$criteria->compare('lng_id',$this->lng_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SystemWidgetTrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
