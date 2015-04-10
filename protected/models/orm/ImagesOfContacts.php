<?php

/**
 * This is the model class for table "images_of_contacts".
 *
 * The followings are the available columns in table 'images_of_contacts':
 * @property integer $id
 * @property integer $image_id
 * @property integer $contact_page_id
 *
 * The followings are the available model relations:
 * @property ContactsPage $contactPage
 * @property Images $image
 */
class ImagesOfContacts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'images_of_contacts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image_id, contact_page_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, image_id, contact_page_id', 'safe', 'on'=>'search'),
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
			'contactPage' => array(self::BELONGS_TO, 'ContactsPage', 'contact_page_id'),
			'image' => array(self::BELONGS_TO, 'Images', 'image_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'image_id' => 'Image',
			'contact_page_id' => 'Contact Page',
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
		$criteria->compare('image_id',$this->image_id);
		$criteria->compare('contact_page_id',$this->contact_page_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImagesOfContacts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
