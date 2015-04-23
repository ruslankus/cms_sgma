<?php

/**
 * This is the model class for table "status".
 *
 * The followings are the available columns in table 'status':
 * @property integer $id
 * @property string $label
 *
 * The followings are the available model relations:
 * @property ComplexPage[] $complexPages
 * @property Images[] $images
 * @property Menu[] $menus
 * @property MenuItem[] $menuItems
 * @property News[] $news
 * @property NewsCategory[] $newsCategories
 * @property Page[] $pages
 * @property Product[] $products
 * @property ProductCategory[] $productCategories
 */
class Status extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label', 'safe', 'on'=>'search'),
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
			'complexPages' => array(self::HAS_MANY, 'ComplexPage', 'status_id'),
			'images' => array(self::HAS_MANY, 'Images', 'status_id'),
			'menus' => array(self::HAS_MANY, 'Menu', 'status_id'),
			'menuItems' => array(self::HAS_MANY, 'MenuItem', 'status_id'),
			'news' => array(self::HAS_MANY, 'News', 'status_id'),
			'newsCategories' => array(self::HAS_MANY, 'NewsCategory', 'status_id'),
			'pages' => array(self::HAS_MANY, 'Page', 'status_id'),
			'products' => array(self::HAS_MANY, 'Product', 'status_id'),
			'productCategories' => array(self::HAS_MANY, 'ProductCategory', 'status_id'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Status the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
