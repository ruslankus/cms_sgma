<?php

/**
 * This is the model class for table "languages".
 *
 * The followings are the available columns in table 'languages':
 * @property integer $id
 * @property string $name
 * @property string $prefix
 * @property string $icon
 * @property integer $active
 * @property integer $priority
 *
 * The followings are the available model relations:
 * @property ContactsBlockTrl[] $contactsBlockTrls
 * @property ContactsFieldsTrl[] $contactsFieldsTrls
 * @property ContactsPageTrl[] $contactsPageTrls
 * @property ImagesTrl[] $imagesTrls
 * @property LabelsTrl[] $labelsTrls
 * @property MenuItemTrl[] $menuItemTrls
 * @property MessagesTrl[] $messagesTrls
 * @property NewsCategoryTrl[] $newsCategoryTrls
 * @property NewsTrl[] $newsTrls
 * @property PageTrl[] $pageTrls
 * @property ProductCategoryTrl[] $productCategoryTrls
 * @property ProductFieldGroupsTrl[] $productFieldGroupsTrls
 * @property ProductFieldValuesTrl[] $productFieldValuesTrls
 * @property ProductFieldsTrl[] $productFieldsTrls
 * @property ProductTrl[] $productTrls
 * @property SystemWidgetTrl[] $systemWidgetTrls
 * @property TagTrl[] $tagTrls
 */
class Languages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'languages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('active, priority', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('prefix', 'length', 'max'=>16),
			array('icon', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, prefix, icon, active, priority', 'safe', 'on'=>'search'),
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
			'contactsBlockTrls' => array(self::HAS_MANY, 'ContactsBlockTrl', 'lng_id'),
			'contactsFieldsTrls' => array(self::HAS_MANY, 'ContactsFieldsTrl', 'lng_id'),
			'contactsPageTrls' => array(self::HAS_MANY, 'ContactsPageTrl', 'lng_id'),
			'imagesTrls' => array(self::HAS_MANY, 'ImagesTrl', 'lng_id'),
			'labelsTrls' => array(self::HAS_MANY, 'LabelsTrl', 'lng_id'),
			'menuItemTrls' => array(self::HAS_MANY, 'MenuItemTrl', 'lng_id'),
			'messagesTrls' => array(self::HAS_MANY, 'MessagesTrl', 'lng_id'),
			'newsCategoryTrls' => array(self::HAS_MANY, 'NewsCategoryTrl', 'lng_id'),
			'newsTrls' => array(self::HAS_MANY, 'NewsTrl', 'lng_id'),
			'pageTrls' => array(self::HAS_MANY, 'PageTrl', 'lng_id'),
			'productCategoryTrls' => array(self::HAS_MANY, 'ProductCategoryTrl', 'lng_id'),
			'productFieldGroupsTrls' => array(self::HAS_MANY, 'ProductFieldGroupsTrl', 'lng_id'),
			'productFieldValuesTrls' => array(self::HAS_MANY, 'ProductFieldValuesTrl', 'lng_id'),
			'productFieldsTrls' => array(self::HAS_MANY, 'ProductFieldsTrl', 'lng_id'),
			'productTrls' => array(self::HAS_MANY, 'ProductTrl', 'lng_id'),
			'systemWidgetTrls' => array(self::HAS_MANY, 'SystemWidgetTrl', 'lng_id'),
			'tagTrls' => array(self::HAS_MANY, 'TagTrl', 'lng_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'prefix' => 'Prefix',
			'icon' => 'Icon',
			'active' => 'Active',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('prefix',$this->prefix,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('priority',$this->priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Languages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
