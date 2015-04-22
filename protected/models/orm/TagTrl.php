<?php

/**
 * This is the model class for table "tag_trl".
 *
 * The followings are the available columns in table 'tag_trl':
 * @property integer $id
 * @property integer $tag_id
 * @property integer $lng_id
 * @property string $name
 * @property string $descriptin
 *
 * The followings are the available model relations:
 * @property Languages $lng
 * @property Tag $tag
 */
class TagTrl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tag_trl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tag_id, lng_id', 'numerical', 'integerOnly'=>true),
			array('name, descriptin', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tag_id, lng_id, name, descriptin', 'safe', 'on'=>'search'),
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
			'lng' => array(self::BELONGS_TO, 'Languages', 'lng_id'),
			'tag' => array(self::BELONGS_TO, 'Tag', 'tag_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tag_id' => 'Tag',
			'lng_id' => 'Lng',
			'name' => 'Name',
			'descriptin' => 'Descriptin',
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
		$criteria->compare('tag_id',$this->tag_id);
		$criteria->compare('lng_id',$this->lng_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('descriptin',$this->descriptin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TagTrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
