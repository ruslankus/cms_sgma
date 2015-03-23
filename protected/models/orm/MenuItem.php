<?php

/**
 * This is the model class for table "menu_item".
 *
 * The followings are the available columns in table 'menu_item':
 * @property integer $menu_id
 * @property integer $id
 * @property integer $parent_id
 * @property integer $priority
 * @property integer $type_id
 * @property integer $status_id
 * @property integer $time_created
 * @property integer $time_updated
 * @property integer $last_change_by
 *
 * The followings are the available model relations:
 * @property MenuItemType $type
 * @property Menu $menu
 * @property MenuItemTrl[] $menuItemTrls
 * @property NewsCategory[] $newsCategories
 * @property Page[] $pages
 * @property ProductCategory[] $productCategories
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
			array('menu_id, parent_id, priority, type_id, status_id, time_created, time_updated, last_change_by', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('menu_id, id, parent_id, priority, type_id, status_id, time_created, time_updated, last_change_by', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'MenuItemType', 'type_id'),
			'menu' => array(self::BELONGS_TO, 'Menu', 'menu_id'),
			'menuItemTrls' => array(self::HAS_MANY, 'MenuItemTrl', 'menu_item_id'),
			'newsCategories' => array(self::HAS_MANY, 'NewsCategory', 'menu_item_id'),
			'pages' => array(self::HAS_MANY, 'Page', 'menu_item_id'),
			'productCategories' => array(self::HAS_MANY, 'ProductCategory', 'menu_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'menu_id' => 'Menu',
			'id' => 'ID',
			'parent_id' => 'Parent',
			'priority' => 'Priority',
			'type_id' => 'Type',
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

		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('type_id',$this->type_id);
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
