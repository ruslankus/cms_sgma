<?php

/**
 * This is the model class for table "menu_item".
 *
 * The followings are the available columns in table 'menu_item':
 * @property integer $id
 * @property integer $menu_id
 * @property string $label
 * @property integer $parent_id
 * @property integer $priority
 * @property integer $type_id
 * @property integer $content_item_id
 * @property integer $status_id
 * @property integer $time_created
 * @property integer $time_updated
 * @property integer $last_change_by
 *
 * The followings are the available model relations:
 * @property Status $status
 * @property MenuItemType $type
 * @property Menu $menu
 * @property MenuItemTrl[] $menuItemTrls
 */
class MenuItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menu_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_id, parent_id, priority, type_id, content_item_id, status_id, time_created, time_updated, last_change_by', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, menu_id, label, parent_id, priority, type_id, content_item_id, status_id, time_created, time_updated, last_change_by', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'MenuItemType', 'type_id'),
			'menu' => array(self::BELONGS_TO, 'Menu', 'menu_id'),
			'menuItemTrls' => array(self::HAS_MANY, 'MenuItemTrl', 'menu_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'menu_id' => 'Menu',
			'label' => 'Label',
			'parent_id' => 'Parent',
			'priority' => 'Priority',
			'type_id' => 'Type',
			'content_item_id' => 'Content Item',
			'status_id' => 'Status',
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
		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('content_item_id',$this->content_item_id);
		$criteria->compare('status_id',$this->status_id);
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
	 * @return MenuItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
