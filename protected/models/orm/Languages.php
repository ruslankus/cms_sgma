<?php

/**
 * This is the model class for table "languages".
 *
 * The followings are the available columns in table 'languages':
 * @property integer $id
 * @property string $name
 * @property string $prefix
 *
 * The followings are the available model relations:
 * @property FaqTrl[] $faqTrls
 * @property FeaturesTrl[] $featuresTrls
 * @property ImagesTrl[] $imagesTrls
 * @property LabelsTrl[] $labelsTrls
 * @property MenusTrl[] $menusTrls
 * @property MessagesTrl[] $messagesTrls
 * @property NewsTrl[] $newsTrls
 * @property PagesTrl[] $pagesTrls
 * @property ProductsTrl[] $productsTrls
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
			array('name', 'length', 'max'=>64),
			array('prefix', 'length', 'max'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, prefix', 'safe', 'on'=>'search'),
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
			'faqTrls' => array(self::HAS_MANY, 'FaqTrl', 'lng_id'),
			'featuresTrls' => array(self::HAS_MANY, 'FeaturesTrl', 'lng_id'),
			'imagesTrls' => array(self::HAS_MANY, 'ImagesTrl', 'lng_id'),
			'labelsTrls' => array(self::HAS_MANY, 'LabelsTrl', 'lng_id'),
			'menusTrls' => array(self::HAS_MANY, 'MenusTrl', 'lng_id'),
			'messagesTrls' => array(self::HAS_MANY, 'MessagesTrl', 'lng_id'),
			'newsTrls' => array(self::HAS_MANY, 'NewsTrl', 'lng_id'),
			'pagesTrls' => array(self::HAS_MANY, 'PagesTrl', 'lng_id'),
			'productsTrls' => array(self::HAS_MANY, 'ProductsTrl', 'lng_id'),
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
